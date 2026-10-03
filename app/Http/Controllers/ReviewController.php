<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.review.index', [
            'articles' => Article::where('status', 'in_revisione')->with('user', 'category')->get(),
        ]);
    }

    public function resolve(Article $article, string $decision)
    {
        $article->update(['status' => $decision === 'approve' ? 'pubblicato' : 'rifiutato']);
        return back()->with('success', 'Articolo aggiornato.');
    }
}