<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friendship;

class FriendshipController extends Controller
{
    public function sendRequest(Request $request)
    {
        $request->validate(['friend_id' => 'required|exists:users,id']);
        auth()->user()->sentRequests()->create(['friend_id' => $request->friend_id]);
        return back();
    }

    public function acceptRequest($id)
    {
        $friendship = auth()->user()->receivedRequests()->findOrFail($id);
        $friendship->update(['status' => 'accepted']);
        return back();
    }

    public function destroy($id)
    {
        $friendship = Friendship::where('id', $id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->firstOrFail();

        $friendship->delete();
        return back();
    }
}
