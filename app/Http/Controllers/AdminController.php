<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use App\Models\Itinerary;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\GroupTrip;

class AdminController extends Controller
{
    // Display the admin dashboard
    public function dashboard()
    {
        // Return the view for the admin dashboard
        $notifications = Notification::orderByDesc('created_at')->take(5)->get(); // You can modify the number of notifications to show

        // Return the view for the admin dashboard and pass the notifications
        return view('admin.dashboard', compact('notifications'));
        //return view('admin.dashboard'); // Make sure you have the view 'admin.dashboard'
    }
    // Display the list of users
    public function index()
    {
        // Get all users from the database
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // Show the form to add a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a new user in the database
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Encrypt the password
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    // Delete a user from the database
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
    

    public function viewItineraries()
{
    // Fetch all itineraries with user data (eager loading)
    $itineraries = Itinerary::with('user')->get();

    // Return the view with the itineraries data for admin
    return view('admin.itineraries.index', compact('itineraries'));
}

    public function showItinerary($id)
    {
        // Fetch a single itinerary with its user data (eager loading)
        $itinerary = Itinerary::with('user')->findOrFail($id);

        // Return the view to show the details without the share functionality for admin
        return view('admin.itineraries.show', compact('itinerary'));
    }

    public function viewGroupTrips()
{
    // Fetch all group trips created by any user (excluding the admin ones)
    $groupTrips = GroupTrip::with('user') // Eager load the user who created the trip
                        ->orderBy('created_at', 'desc') // Show the latest created trips first
                        ->get();

    // Return the view and pass the group trips to it
    return view('admin.group_trips.index', compact('groupTrips'));
}


    public function viewNotifications()
{
    // Use a raw SQL query to fetch distinct notifications based on title and message
    $notifications = Notification::select('title', 'message', 'created_at')
        ->distinct() // Ensure no duplicate notifications based on title and message
        ->orderByDesc('created_at')  // Order by the latest notification
        ->get();

    // Return the view with the notifications data
    return view('admin.notifications.index', compact('notifications'));
}


   

}


