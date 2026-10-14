<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.review.index', [
            'articles' => Article::where('status', 'in_revisione')->with('user', 'category')->oldest()->get(),
        ]);
    }

    public function resolve(Article $article, string $decision)
    {
        return DB::transaction(function () use ($article, $decision) {
            $article = Article::lockForUpdate()
                ->findOrFail($article->id);

            if ($article->status !== 'in_revisione') {
                return back()->with(
                    'error',
                    'Questo articolo è già stato revisionato.'
                );
            }

            $approved = $decision === 'approve';

            $article->status = $approved ? 'pubblicato' : 'rifiutato';
            $article->save();

            return back()->with(
                'success',
                $approved ? 'Articolo pubblicato.' : 'Articolo rifiutato.'
            );
        });
    }
}
