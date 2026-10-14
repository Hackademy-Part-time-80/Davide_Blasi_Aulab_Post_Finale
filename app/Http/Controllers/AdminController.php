<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Role;
use App\Models\TeamRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'counts' => Article::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'requests' => TeamRequest::with('user', 'requestedRole')->where('status', 'in_attesa')->oldest()->get(),
            'users' => User::with('role')->orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function setRole(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Non puoi cambiare il tuo stesso ruolo.');
        }

        $data = $request->validate(['role_id' => 'nullable|exists:roles,id']);
        $user->forceFill($data)->save();

        return back()->with('success', "Ruolo di {$user->name} aggiornato.");
    }
}
