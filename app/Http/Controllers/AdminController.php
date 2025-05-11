<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use App\Models\Itinerary;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Display the admin dashboard
    public function dashboard()
    {
        // Return the view for the admin dashboard
        return view('admin.dashboard'); // Make sure you have the view 'admin.dashboard'
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

        // Return the view with the itineraries data
        return view('admin.itineraries.index', compact('itineraries'));
    }

   

}


