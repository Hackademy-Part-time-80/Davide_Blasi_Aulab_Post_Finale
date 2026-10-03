<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function homepage()
    {
        return view('pages.homepage', ['articles' => Article::where('status', 'pubblicato')->latest()->take(6)->get()]);
    }

    public function index()
    {
        return view('pages.articles.index', ['articles' => Article::where('status', 'pubblicato')->latest()->paginate(12)]);
    }

    public function show(Article $article)
    {
        abort_unless($article->status === 'pubblicato' || $article->user_id === auth()->id(), 404);
        return view('pages.articles.show', compact('article'));
    }

    public function create()
    {
        return view('pages.articles.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }
        $data['user_id'] = auth()->id();
        $data['status'] = 'in_revisione';

        Article::create($data);
        return redirect()->route('articles.index')->with('success', 'Articolo inviato per la revisione!');
    }

    public function edit(Article $article)
    {
        abort_if($article->user_id !== auth()->id(), 403);
        return view('pages.articles.edit', ['article' => $article, 'categories' => Category::all()]);
    }

    public function update(Request $request, Article $article)
    {
        abort_if($article->user_id !== auth()->id(), 403);
        $data = $request->validate($this->rules());
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } else {
            unset($data['cover_image']);
        }
        $data['status'] = 'in_revisione';

        $article->update($data);
        return redirect()->route('articles.show', $article)->with('success', 'Articolo aggiornato.');
    }

    public function destroy(Article $article)
    {
        abort_if($article->user_id !== auth()->id(), 403);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Articolo eliminato.');
    }
}