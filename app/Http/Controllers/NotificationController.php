<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $userId = auth()->id(); // Get the authenticated user's ID.
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadCount = $notifications->where('status', 'unread')->count();

        return view('layout.PmsHeader', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount, // Pass $unreadCount to the view.
        ]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function delete($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        // Only get the count without marking as read
        $count = Notification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->count();

        return response()->json(['unreadCount' => $count]);
    }
}
