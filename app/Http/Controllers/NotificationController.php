<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // View notifications (for admin to see all sent notifications)
    public function viewNotifications()
    {
        // Fetch all notifications ordered by the latest first
        $notifications = Notification::orderByDesc('created_at')->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    // Send notification to all users
    public function sendNotification(Request $request)
    {
        // Validate the notification input
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Get all users
        $users = User::all();

        // Create and store notifications for each user
        foreach ($users as $user) {
            Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => $user->id, // Associate notification with each user
            ]);
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Notifications sent successfully!');
    }
    public function userNotifications()
    {
        // Get the logged-in user's notifications
        $notifications = Notification::where('user_id', auth()->id())  // Get notifications where the user_id matches the logged-in user
                                    ->orderByDesc('created_at')        // Sort them by the latest
                                    ->get();                          // Retrieve the notifications

        // Return the view and pass the notifications
        return view('user.notifications.index', compact('notifications'));
    }
}
