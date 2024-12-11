<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::all();
        return view('media.index', compact('media'));
    }

    public function show($id)
    {
        $media = Media::findOrFail($id);
        return view('media.show', compact('media'));
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $media = Media::findOrFail($id);
        $media->ratings()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
        ]);

        return back();
    }
}
