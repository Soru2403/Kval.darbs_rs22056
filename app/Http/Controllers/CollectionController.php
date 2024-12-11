<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::where('is_public', true)->get();
        return view('collections.index', compact('collections'));
    }

    public function myCollections()
    {
        $collections = auth()->user()->collections;
        return view('collections.my', compact('collections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->collections()->create($request->all());

        return redirect()->route('collections.my');
    }

    public function update(Request $request, $id)
    {
        $collection = auth()->user()->collections()->findOrFail($id);
        $collection->update($request->all());

        return redirect()->route('collections.my');
    }

    public function destroy($id)
    {
        $collection = auth()->user()->collections()->findOrFail($id);
        $collection->delete();

        return redirect()->route('collections.my');
    }
}
