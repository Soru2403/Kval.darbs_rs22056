<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    // Funkcija, lai atgrieztu galveno mediju lapu ar visu mediju sarakstu
    public function index()
    {
        $media = Media::all(); // Iegūstam visus medijus no datubāzes
        return view('media.index', compact('media')); // Nododam datus Blade šablonam
    }

    // Funkcija, lai atgrieztu detalizētu skatu konkrētam medijam
    public function show($id)
    {
        $media = Media::findOrFail($id); // Atrodam konkrēto mediju pēc ID vai atgriežam kļūdu
        return view('media.show', compact('media')); // Nododam mediju datus Blade šablonam
    }

    // Funkcija, lai pievienotu vērtējumu konkrētam medijam
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Pārbaudām, vai vērtējums ir no 1 līdz 5
        ]);

        $media = Media::findOrFail($id); // Atrodam mediju pēc ID
        $media->ratings()->create([
            'user_id' => auth()->id(), // Pievienojam lietotāja ID
            'rating' => $request->rating, // Saglabājam vērtējumu
        ]);

        return back(); // Atgriežam lietotāju uz iepriekšējo lapu
    }
}

