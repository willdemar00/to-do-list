<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            })
            ->when($request->filled('email'), function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->input('email') . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('created_at')
            ->paginate(15);
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisteredRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['status'] = $request->boolean('status');

            $user = User::create($data);

            if ($request->hasFile('image')) {
                ImageService::storeImage($request->file('image'), $user);
            }

            DB::commit();
            return redirect()->route('user.index')->with('flash_success', 'Usuário criado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha ao criar o usuário: ' . $e->getMessage());
            return redirect()->route('user.index')->with('flash_error', 'Falha ao criar o usuário.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        return view('backend.user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $data = $request->all();

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
            }

            if ($request->hasFile('image')) {
                if ($user->image) {
                    ImageService::updateImage($request->file('image'), $user);
                } else {
                    ImageService::storeImage($request->file('image'), $user);
                }
            }
            $data['status'] = $request->boolean('status');

            $user->update($data);

            DB::commit();
            return redirect()->route('user.index')->with('flash_success', 'Usuário atualizado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha ao atualizar o usuário: ' . $e->getMessage());
            return redirect()->route('user.index')->with('flash_error', 'Falha ao atualizar o usuário.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            if ($user->tasks()->exists() || $user->involved()->exists()) {
                DB::rollBack();
                return redirect()->route('user.index')->with('flash_error', 'Não é possível excluir o usuário, pois ele está relacionado a uma ou mais tarefas.');
            }

            $user->delete();

            DB::commit();
            return redirect()->route('user.index')->with('flash_success', 'Usuário excluído com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha ao excluir o usuário: ' . $e->getMessage());
            return redirect()->route('user.index')->with('flash_error', 'Falha ao excluir o usuário.');
        }
    }
}
