<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Rāda lietotāja profila lapu
    public function profile()
    {
        // Atgriež profila skatu ar lietotāja datiem
        return view('users.profile', ['user' => Auth::user()]);
    }

    // Apstrādā lietotāja profila atjaunināšanu
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
            $user->password = Hash::make($request->password);
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

    // Administratora panelis
    public function adminDashboard()
    {
        // Tikai admina lietotājiem
        $this->authorize('isAdmin', User::class);

        // Atgriež visu lietotāju sarakstu administrēšanai
        $users = User::paginate(10); // Lapas izmērs: 10 ieraksti
        return view('admin.dashboard', compact('users'));
    }

    // Dzēš lietotāju (tikai administrators)
    public function destroy($id)
    {
        $this->authorize('isAdmin', User::class);

        $user = User::findOrFail($id);

        // Pārbauda, lai administrators pats sevi nedzēstu
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'Nevarat dzēst sevi!']);
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Lietotājs veiksmīgi dzēsts.');
    }

    // Maina lietotāja privilēģijas (tikai administrators)
    public function changePrivileges(Request $request, $id)
    {
        $this->authorize('isAdmin', User::class);

        $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->is_admin = $request->is_admin;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Lietotāja privilēģijas veiksmīgi mainītas.');
    }
}
