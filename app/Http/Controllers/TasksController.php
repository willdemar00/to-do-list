<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TasksRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tasks = Tasks::with(['user', 'involved'])
            ->when($request->filled('title'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('date', Carbon::parse($request->input('start_date'))->format('Y-m-d'));
            })
            ->where(function ($query) use ($request) {
                $userId = Auth::id();
                if ($request->filled('selected_user_ids')) {
                    // IDs selecionados
                    $selectedUserIds = explode(',', $request->input('selected_user_ids'));

                    // Tarefas relacionadas aos IDs selecionados (involved ou responsável)
                    $query->where(function ($query) use ($selectedUserIds) {
                        $query->whereHas('involved', function ($query) use ($selectedUserIds) {
                            $query->whereIn('user_id', $selectedUserIds);
                        })
                            ->orWhereIn('responsible_id', $selectedUserIds);
                    });
                } else {
                    // Tarefas relacionadas ao usuário logado (responsável ou envolvido)
                    $query->where('responsible_id', $userId)
                        ->orWhereHas('involved', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('pagination', 15));

        $scheduledTasks = Tasks::whereNotNull('date')
            ->where('status', Tasks::STATUS_PENDING)
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('date', Carbon::parse($request->input('start_date'))->format('Y-m-d'));
            })
            ->get();
            if (!$request->filled('start_date')) {
                $today = Carbon::today()->format('Y-m-d');
                $scheduledTasks = $scheduledTasks->where('date', $today);
            }

        return view('frontend.tasks.index', compact('tasks', 'scheduledTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('frontend.tasks.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TasksRequest $request)
    {
        try {
            DB::beginTransaction();
            $fields = $request->validated();
            $fields['responsible_id'] = Auth::id();

            $task = Tasks::create($fields);

            if ($request->filled('selected_user_ids')) {
                $userIds = explode(',', $request->input('selected_user_ids'));
                $task->involved()->sync($userIds);
            }

            DB::commit();

            return redirect()->route('tasks.index')->with('flash_success', 'Tarefa criada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Ocorreu um erro ao criar a tarefa: ' . $e->getMessage());
            return redirect()->back()->with('flash_error', 'Ocorreu um erro ao criar a tarefa');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $task = Tasks::findOrFail($id);

        return view('frontend.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $task = Tasks::findOrFail($id);

        return view('frontend.tasks.form', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TasksRequest $request, Tasks $task)
    {
        try {
            DB::beginTransaction();
            $fields = $request->validated();

            if ($request->filled('selected_user_ids')) {
                $userIds = explode(',', $request->input('selected_user_ids'));

                if ($request->has('remove_responsible')) {
                    if (count($userIds) > 0) {
                        $fields['responsible_id'] = $userIds[0];
                        $userIds = array_diff($userIds, [$userIds[0]]);
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('flash_error', 'Não é possível remover o responsável sem adicionar outras pessoas envolvidas.');
                    }
                }

                $task->involved()->sync($userIds);
            } elseif ($request->has('remove_responsible')) {
                DB::rollBack();
                return redirect()->back()->with('flash_error', 'Não é possível remover o responsável sem adicionar outras pessoas envolvidas.');
            } else {
                $task->involved()->sync([]);
            }

            if ($request->has('status')) {
                $fields['status'] = $request->input('status');
            }

            $task->update($fields);

            DB::commit();

            return redirect()->route('tasks.index')->with('flash_success', 'Tarefa atualizada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Ocorreu um erro ao atualizar a tarefa: ' . $e->getMessage());
            return redirect()->back()->with('flash_error', 'Ocorreu um erro ao atualizar a tarefa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $task)
    {
        try {
            DB::beginTransaction();

            // Excluir registros relacionados na tabela task_user
            $task->involved()->detach();

            $task->delete();

            DB::commit();

            return redirect()->route('tasks.index')->with('flash_success', 'Tarefa excluída com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Ocorreu um erro ao excluir a tarefa: ' . $e->getMessage());
            return redirect()->back()->with('flash_error', 'Ocorreu um erro ao excluir a tarefa');
        }
    }

    /**
     * Search for users based on a query.
     */
    public function searchUsers(Request $request): JsonResponse
    {

        $users = User::select('id', 'name')
            ->where('name', 'like', "%" . $request->input('query') . "%")
            ->where('status', User::STATUS_ACTIVE)
            ->limit(5)
            ->get();

        $users->each(function ($user) {
            $user->image_url = $user->path_image;
        });

        return response()->json($users);
    }

    /**
     * Update the status of a task.
     */
    public function updateStatus(Request $request): JsonResponse
    {
        try {
            $task = Tasks::findOrFail($request->input('id'));
            $task->status = $request->input('status');
            $task->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Ocorreu um erro ao atualizar o status da tarefa: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
