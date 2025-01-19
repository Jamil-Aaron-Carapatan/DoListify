<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('pages.partials.personalView', function ($view) {
            $taskId = request()->route('task'); // Get the task ID from the route
            $task = \App\Models\Task::find($taskId); // Fetch the task from the database
            $view->with('task', $task);
        });

        View::composer('layout.PmsHeader', function ($view) {
            $userId = auth()->id(); // Get the authenticated user's ID.

            // Retrieve unread notifications count.
            $unreadCount = Notification::where('user_id', $userId)
                ->where('status', 'unread')
                ->count();

            // Retrieve the latest notifications (e.g., limit to 10).
            $notifications = Notification::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            // Share variables with the view.
            $view->with([
                'unreadCount' => $unreadCount, 
                'notifications' => $notifications,
            ]);
        });
    }
}
