<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('pages.feedback.create');
    }

    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);

        return view('pages.feedback.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:3000',
        ]);

        Feedback::create($data);

        return redirect()->route('feedback.create')
            ->with('success', 'Grazie! Il tuo feedback è stato ricevuto.');
    }
}
