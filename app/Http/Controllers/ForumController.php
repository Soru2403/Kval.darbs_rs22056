<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\ForumComment;

class ForumController extends Controller
{
    public function __construct()
    {
        // Konstruktoru var izmantot, lai inicializētu middleware vai citu loģiku
    }

    // Foruma galvenā lapa — visi ieraksti
    public function index(Request $request)
    {
        // Saņemam lietotāja izvēlēto kārtošanas virzienu (noklusējums ir 'desc')
        $sort = $request->get('sort', 'desc');

        // Iegūstam ierakstus ar komentāriem, sakārtotus pēc izvēlētā kārtošanas virziena
        $posts = ForumPost::with('comments')
                    ->orderBy('created_at', $sort)
                    ->paginate(10); // Izmantojam paginate() metodi, lai iegūtu ierakstus ar lapošanas atbalstu

        // Atgriežam skatu ar ierakstiem, izvēlēto kārtošanas virzienu un pieprasījuma parametriem
        return view('pages.forum.index', compact('posts', 'sort'));
    }
    public function create()
    {
        // Atgriežam skatu jauna ieraksta izveides formai
        return view('pages.forum.create');
    }
    
    public function store(Request $request)
    {
        // Veicam validāciju, lai pārbaudītu lietotāja ievadītos datus
        $request->validate([
            'title' => 'required|string|max:255', // Obligāts lauks — nosaukums
            'keywords' => 'nullable|string|max:255', // Neobligāts lauks — atslēgvārdi
            'content' => 'required|string', // Obligāts lauks — ieraksta saturs
        ]);
    
        // Izveidojam jaunu ierakstu no autentificētā lietotāja
        auth()->user()->forumPosts()->create($request->only(['title', 'keywords', 'content']));
    
        // Pāradresējam uz foruma sākumlapu ar paziņojumu par veiksmīgu izveidi
        return redirect()->route('forum.index')->with('success', 'Ieraksts veiksmīgi izveidots!');
    }

    // Viena ieraksta lapa ar komentāriem
    public function show($id)
    {
        $post = ForumPost::with('comments.user')->findOrFail($id); // Iegūstam konkrētu ierakstu ar tā komentāriem un komentāru lietotājiem
        return view('pages.forum.show', compact('post')); // Atgriežam skatu ar postu un tā komentāriem
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
            'keywords' => 'nullable|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->only(['title', 'keywords', 'content']));

        return redirect()->route('forum.show', $post->id)->with('success', 'Ieraksts veiksmīgi atjaunināts!');
    }

    // Ieraksta dzēšana
    public function destroyPost($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('delete', $post); // Pārbaudām, vai lietotājam ir tiesības dzēst šo ierakstu
        $post->delete();

        return redirect()->route('forum.index')->with('success', 'Ieraksts dzēsts.');
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
                          ->orWhere('keywords', 'LIKE', "%{$query}%") // Pievienota meklēšana pēc atslēgvārdiem
                          ->latest()
                          ->paginate(10); // Izmantojam paginate() meklēšanas rezultātu lapošanai

        return view('pages.forum.index', compact('posts'));
    }
}





