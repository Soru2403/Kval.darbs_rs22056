<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Administratora panelis
    public function adminDashboard()
    {
        // Pārbauda, vai lietotājs ir administrators
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Jums nav piekļuves administrācijas panelim!');
        }

        // Iegūst lietotāju sarakstu administrēšanai
        $users = User::paginate(10); // Lapas izmērs: 10 ieraksti
        return view('admin.dashboard', compact('users'));
    }

    // Dzēš lietotāju (tikai administrators)
    public function destroy($id)
    {
        // Pārbauda, vai lietotājs ir administrators
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Jums nav tiesību dzēst lietotājus!');
        }

        $user = User::findOrFail($id);

        // Neļauj administratoram dzēst pats sevi
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'Nevarat dzēst sevi!']);
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Lietotājs veiksmīgi dzēsts.');
    }

    // Maina lietotāja privilēģijas (tikai administrators)
    public function changePrivileges(Request $request, $id)
    {
        // Pārbauda, vai lietotājs ir administrators
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Jums nav tiesību mainīt lietotāja privilēģijas!');
        }

        $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->is_admin ? 'admin' : 'user'; // Maina lietotāja lomu
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Lietotāja privilēģijas veiksmīgi mainītas.');
    }

    // Lietotāja profils
    public function profile()
    {
        // Atgriež skatu ar pašreizējā lietotāja datiem
        return view('users.profile', ['user' => Auth::user()]);
    }

    // Rāda cita lietotāja profilu pēc ID
    public function show($id)
    {
        // Atrod lietotāju pēc ID vai atgriež kļūdu
        $user = User::findOrFail($id);

        // Atgriež lietotāja profila skatu
        return view('users.profile', compact('user'));
    }

    // Rāda formu profila rediģēšanai
    public function edit()
    {
        // Iegūst pašreizējo autentificēto lietotāju
        $user = Auth::user();

        // Atgriež skatu ar rediģēšanas formu
        return view('users.edit', compact('user'));
    }

    // Atjaunina lietotāja profilu
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validē ievades laukus
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Atjaunina lietotāja datus
        $user->name = $request->name;
        $user->email = $request->email;

        // Ja parole ir ievadīta, to atjauno
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save(); // Saglabā izmaiņas

        return redirect()->route('profile')->with('success', 'Profils veiksmīgi atjaunināts!');
    }

    // Lietotāja sākumlapa
    public function home()
    {
        // Atgriež lietotāja sākumlapas skatu
        $user = Auth::user();
        return view('users.home', compact('user'));
    }
}