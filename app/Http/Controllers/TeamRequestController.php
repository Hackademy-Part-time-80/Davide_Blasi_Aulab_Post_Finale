<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\TeamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        return DB::transaction(function () use ($teamRequest, $decision) {
            $teamRequest = TeamRequest::lockForUpdate()
                ->findOrFail($teamRequest->id);

            if ($teamRequest->status !== 'in_attesa') {
                return back()->with(
                    'error',
                    'Questa richiesta è già stata gestita.'
                );
            }

            if ($decision === 'approve') {
                $user = $teamRequest->user;
                $role = $teamRequest->requestedRole;

                if (! $user || ! $role) {
                    return back()->with(
                        'error',
                        'Utente o ruolo non più disponibile.'
                    );
                }

                if ($user->hasRole('Admin')) {
                    return back()->with(
                        'error',
                        'Il ruolo di un amministratore non può essere cambiato tramite una candidatura.'
                    );
                }

                $user->role_id = $role->id;
                $user->save();

                $teamRequest->status = 'accettata';
            } else {
                $teamRequest->status = 'rifiutata';
            }

            $teamRequest->save();

            return back()->with(
                'success',
                $decision === 'approve'
                    ? 'Richiesta approvata e ruolo assegnato.'
                    : 'Richiesta rifiutata.'
            );
        });
    }
}
