<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    
    public function viewFriends()
    {
        
        $friends = auth()->user()->friends;
    
        
        $usersToAdd = User::where('id', '!=', auth()->id())
                            ->whereNotIn('id', function ($query) {
                                $query->select('friend_id')
                                        ->from('friendships')
                                        ->where('user_id', auth()->id())
                                        ->where('status', 'accepted');
                            })
                            ->get()
                            ->map(function ($user) {
                                
                                $user->request_sent = Friendship::where('user_id', auth()->id())
                                                                ->where('friend_id', $user->id)
                                                                ->where('status', 'pending')
                                                                ->exists();
                                return $user;
                            });
    
       
        $pendingRequests = Friendship::where('friend_id', auth()->id())
                                     ->where('status', 'pending')
                                     ->get();
    
        return view('friends.index', compact('friends', 'usersToAdd', 'pendingRequests'));
    }
    
    

    
    public function sendRequest($friend_id)
    {
        
        if ($friend_id == auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'You cannot send a friend request to yourself.']);
        }
    
        
        $existingFriendship = Friendship::where(function($query) use ($friend_id) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $friend_id);
        })->orWhere(function($query) use ($friend_id) {
            $query->where('user_id', $friend_id)
                  ->where('friend_id', auth()->id());
        })->first();
    
        if ($existingFriendship) {
            
            return redirect()->back()->withErrors(['error' => 'You are already friends or have already sent a request.']);
        }
    
       
        $friendship = Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $friend_id,
            'status' => 'pending',
        ]);
    
        return redirect()->route('friends.index')->with('success', 'Friend request sent!');
    }

    
    public function undoRequest($friend_id)
    {
        
        $friendship = Friendship::where('user_id', auth()->id())
                                ->where('friend_id', $friend_id)
                                ->where('status', 'pending')
                                ->first();
    
        if ($friendship) {
            $friendship->delete();  
            return redirect()->route('friends.index')->with('success', 'Friend request undone!');
        }
    
        return redirect()->route('friends.index')->withErrors(['error' => 'No pending request found to undo.']);
    }
    
    


    
    public function viewPendingRequests()
    {
        $pendingRequests = Friendship::where('friend_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->get();

        return view('friends.pending', compact('pendingRequests'));
    }

    
    public function acceptRequest($friendship_id)
    {
        $friendship = Friendship::findOrFail($friendship_id);
    
        
        if ($friendship->friend_id !== auth()->id()) {
            return redirect()->route('friends.pending')->withErrors(['error' => 'You cannot accept this request.']);
        }
    
        
        $friendship->status = 'accepted';
        $friendship->save();
    
        
        $existingFriendship = Friendship::where('user_id', $friendship->user_id)
                                         ->where('friend_id', auth()->id())
                                         ->first();
    
        if (!$existingFriendship) {
            Friendship::create([
                'user_id' => $friendship->user_id,
                'friend_id' => auth()->id(),
                'status' => 'accepted',
            ]);
        }
        $existingFriendship2 = Friendship::where('friend_id', $friendship->user_id)
                                         ->where('user_id', auth()->id())
                                         ->first();
        
        if (!$existingFriendship2) {
            Friendship::create([
                'user_id' => auth()->id(),
                'friend_id' => $friendship->user_id,
                'status' => 'accepted',
            ]);
        }
    
        
        return redirect()->route('friends.pending')->with('success', 'Friend request accepted!');
    }
    

    
    public function rejectRequest($friendship_id)
    {
        $friendship = Friendship::findOrFail($friendship_id);
        
        
        if ($friendship->friend_id !== auth()->id()) {
            return redirect()->route('friends.pending')->withErrors(['error' => 'You cannot reject this request.']);
        }

        
        $friendship->delete();

        return redirect()->route('friends.pending')->with('success', 'Friend request rejected!');
    }


    public function searchFriends(Request $request)
    {
        
        $search = $request->input('search');
    
        
        $usersToAdd = User::where('name', 'like', '%' . $search . '%')
        ->where('id', '!=', auth()->id()) //exclude the current user
        ->whereNotIn('id', function ($query) {
            $query->select('friend_id')
                ->from('friendships')
                ->where('user_id', auth()->id())
                ->where('status', 'accepted');  //exclude already accepted friends
        })
        ->get();
    
        
        $friends = auth()->user()->friends;
    
        
        return view('friends.index', compact('friends', 'usersToAdd'));
    }
    
}
