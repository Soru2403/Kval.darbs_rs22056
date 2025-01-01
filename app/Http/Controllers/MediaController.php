<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    // Funkcija, lai atgrieztu galveno mediju lapu ar visu mediju sarakstu
    public function index(Request $request)
    {
        // Iegūstam filtrēšanas parametru no pieprasījuma
        $filterType = $request->query('type');
    
        // Ja ir filtrs, tiek atlasīti mēdiji atbilstoši filtram
        if ($filterType) {
            $media = Media::where('type', $filterType)->get();
        } else {
            // Ja filtrs nav iestatīts, tiek parādīti visi mēdiji
            $media = Media::all();
        }
    
        return view('media.index', [
            'media' => $media,
            'filterType' => $filterType, // Nododam pašreizējo filtru skatā
        ]);
    }

    // Funkcija, lai atgrieztu detalizētu skatu konkrētam medijam
    public function show($id)
    {
        $media = Media::findOrFail($id); // Atrodam konkrēto mediju pēc ID vai atgriežam kļūdu
        return view('media.show', compact('media')); // Nododam mediju datus Blade šablonam
    }

    // Parāda veidlapu jauna mēdija pievienošanai
    public function create()
    {
        // Pārbauda, vai lietotājs ir administrators
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Piekļuve liegta');
        }

        return view('media.create');
    }

    // Saglabā jauno mēdiju datubāzē
    public function store(Request $request)
    {
        // Validācija
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'type' => 'required|in:spēle,filma,seriāls,grāmata', // Pārbauda, vai veids ir pareizs
            'creator' => 'required|max:255',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'genre' => 'required|max:255',
            'image_url' => 'required|url',
        ]);

        // Izveido jaunu mēdiju
        Media::create($request->all());

        // Pāradresē uz mēdiju sarakstu
        return redirect()->route('media.index')->with('success', 'Mēdijs veiksmīgi pievienots!');
    }
    //Mediju rediģēšana
    public function edit($id)
    {
        // Atrodam mēdiju pēc ID
        $media = Media::findOrFail($id);

        // Atgriežam rediģēšanas lapu ar mēdiju datiem
        return view('media.edit', compact('media'));
    }
    
    // Mediju atjaunināšana
    public function update(Request $request, $id)
    {
        // Validējam ienākošos datus
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'creator' => 'required|string',
            'release_year' => 'required|integer',
            'genre' => 'required|string',
            'image_url' => 'nullable|url',
        ]);

        // Atrodam mēdiju un atjaunojam tā datus
        $media = Media::findOrFail($id);
        $media->update($request->all());

        // Pāradresējam uz galveno mēdiju lapu ar ziņojumu
        return redirect()->route('media.index')->with('success', 'Mēdijs veiksmīgi atjaunināts!');
    }

    // Mediju dzēšana  
    public function destroy($id)
    {
        // Atrodam mēdiju pēc ID un izdzēšam
        $media = Media::findOrFail($id);
        $media->delete();

        // Pāradresējam uz galveno mēdiju lapu ar ziņojumu
        return redirect()->route('media.index')->with('success', 'Mēdijs veiksmīgi izdzēsts!');
    }  
}

