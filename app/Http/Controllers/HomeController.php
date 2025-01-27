<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $tasksCount = $this->getTasksCount($user);
        $progress = $this->calculateProgress($user, $tasksCount);
        $message = $this->generateMessage($progress);
        $recentActivities = $this->getRecentActivities($user);

        return view('frontend.layout.home', compact('user', 'tasksCount', 'progress', 'recentActivities', 'message'));
    }

    private function getTasksCount(User $user): int
    {
        return Tasks::where('responsible_id', $user->id)
            ->orWhereHas('involved', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
    }

    private function calculateProgress(User $user, int $tasksCount): float
    {
        $completedTasks = Tasks::where('responsible_id', $user->id)
            ->orWhereHas('involved', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', Tasks::STATUS_COMPLETED)->count();

        return $tasksCount > 0 ? ($completedTasks / $tasksCount) * 100 : 0;
    }

    private function generateMessage(float $progress): string
    {
        if ($progress >= 75) {
            return "Excelente progresso, continue assim!";
        } elseif ($progress >= 50) {
            return "Bom ritmo, continue assim!";
        } else {
            return "Vamos lá, você consegue!";
        }
    }

    private function getRecentActivities(User $user): \Illuminate\Support\Collection
    {
        return Tasks::with('user')
            ->where('responsible_id', $user->id)
            ->orWhereHas('involved', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($task) {
                return [
                    'user_photo' => $task->user->getPathImageAttribute(),
                    'description' => $task->user->name . ' criou uma nova tarefa',
                    'time_ago' => $task->created_at->diffForHumans()
                ];
            });
    }
}
