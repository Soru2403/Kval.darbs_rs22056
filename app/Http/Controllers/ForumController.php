<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\ForumComment;

class ForumController extends Controller
{
    public function __construct()
    {
        // Этот код должен работать, если контроллер наследует класс `Controller` от Laravel
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Foruma galvenā lapa — visi ieraksti
    public function index()
    {
        $posts = ForumPost::with('comments')->latest()->get(); // Iegūstam ierakstus ar komentāriem, sakārtotus pēc datuma
        return view('pages.forum.index', compact('posts'));
    }

    // Viena ieraksta lapa ar komentāriem
    public function show($id)
    {
        // Iegūstam konkrētu ierakstu ar tā komentāriem un komentāru lietotājiem
        $post = ForumPost::with('comments.user')->findOrFail($id); 
        return view('pages.forum.show', compact('post')); // Atgriežam skatu ar postu un tā komentāriem
    }

    // Jauna ieraksta izveide
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Izveidojam jaunu ierakstu autorizēta lietotāja vārdā
        auth()->user()->forumPosts()->create($request->all());

        return back()->with('success', 'Ieraksts veiksmīgi izveidots!');
    }

    // Komentāra pievienošana ierakstam
    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = ForumPost::findOrFail($id); // Atrodam ierakstu pēc ID
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentārs pievienots!');
    }

    // Ieraksta rediģēšana
    public function edit($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post); // Pārbaudām, vai lietotājam ir tiesības rediģēt šo ierakstu
        return view('pages.forum.edit', compact('post'));
    }

    // Ieraksta atjaunināšana
    public function update(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post); // Pārbaudām, vai lietotājam ir tiesības rediģēt šo ierakstu

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->all());

        return redirect()->route('forum.show', $post->id)->with('success', 'Ieraksts veiksmīgi atjaunināts!');
    }

    // Ieraksta dzēšana
    public function destroyPost($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('delete', $post); // Pārbaudām, vai lietotājam ir tiesības dzēst šo ierakstu
        $post->delete();

        return back()->with('success', 'Ieraksts dzēsts.');
    }

    // Komentāra dzēšana
    public function destroyComment($id)
    {
        $comment = ForumComment::findOrFail($id);
        $this->authorize('delete', $comment); // Pārbaudām, vai lietotājam ir tiesības dzēst šo komentāru
        $comment->delete();

        return back()->with('success', 'Komentārs dzēsts.');
    }

    // Ierakstu meklēšana pēc atslēgvārdiem un ieraksta nosaukumiem
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3', // Meklēšanai jābūt vismaz 3 rakstzīmēm
        ]);

        $query = $request->input('query');
        $posts = ForumPost::where('title', 'LIKE', "%{$query}%")
                          ->orWhere('content', 'LIKE', "%{$query}%")
                          ->get();

        return view('pages.forum.index', compact('posts'));
    }
}

