<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\TeamRequest;
use Illuminate\Http\Request;

class TeamRequestController extends Controller
{
    public function create()
    {
        return view('pages.team.create', ['roles' => Role::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'requested_role_id' => 'required|exists:roles,id',
            'message' => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();

        TeamRequest::create($data);
        return redirect()->route('homepage')->with('success', 'Richiesta inviata.');
    }

    public function index()
    {
        return view('pages.team.index', [
            'requests' => TeamRequest::where('status', 'in_attesa')->with('user', 'requestedRole')->get(),
        ]);
    }

    public function resolve(TeamRequest $teamRequest, string $decision)
    {
        $teamRequest->update(['status' => $decision === 'approve' ? 'accettata' : 'rifiutata']);

        if ($decision === 'approve') {
            $teamRequest->user->update(['role_id' => $teamRequest->requested_role_id]);
        }

        return back()->with('success', 'Richiesta aggiornata.');
    }
}