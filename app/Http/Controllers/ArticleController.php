<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function homepage()
    {
        return view('pages.homepage', [
            'articles' => Article::published()->with('user', 'category')->latest()->latest('id')->take(6)->get(),
        ]);
    }

    public function index(Request $request)
    {
        $validator = validator($request->query(), [
            'q' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('articles.index')
                ->withErrors($validator);
        }
        $categoryId = $request->integer('category');
        $authorId = $request->integer('author');
        $search = trim($request->string('q')->toString());

        $query = Article::published()
            ->with('user', 'category')
            ->search($search);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($authorId) {
            $query->where('user_id', $authorId);
        }

        $articles = $query
            ->latest()
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('pages.articles.index', [
            'articles' => $articles,
            'category' => $categoryId ? Category::find($categoryId) : null,
            'author' => $authorId ? User::find($authorId) : null,
        ]);
    }

    public function show(Article $article)
    {
        abort_unless(Gate::allows('view', $article), 404);

        return view('pages.articles.show', ['article' => $article->load('user', 'category', 'tags')]);
    }

    public function create()
    {
        Gate::authorize('create', Article::class);

        return $this->form(new Article);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);
        $this->persist($request, new Article(['user_id' => Auth::id()]));

        return redirect()->route('writer.dashboard')
            ->with('success', 'Articolo inviato: sarà pubblicato dopo la revisione.');
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return $this->form($article->load('tags'));
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);
        $this->persist($request, $article);

        return redirect()->route('writer.dashboard')
            ->with('success', 'Articolo aggiornato: è tornato in revisione.');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return redirect()->route('writer.dashboard')->with('success', 'Articolo eliminato.');
    }

    public function mine()
    {
        return view('pages.writer.dashboard', [
            'articles' => Article::where('user_id', Auth::id())->with('category')->latest()->latest('id')->get(),
        ]);
    }

    private function form(Article $article)
    {
        return view('pages.articles.form', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    private function persist(Request $request, Article $article): void
    {
        $imageRule = $article->exists ? 'nullable' : 'required';

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'body' => 'required|string',
            'cover_image' => $imageRule . '|image|mimes:jpg,jpeg,png,webp|max:10240',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'required|integer|distinct|exists:tags,id',
        ]);

        $tags = $data['tags'] ?? [];
        unset($data['tags'], $data['cover_image']);

        $disk = Storage::disk('public');
        $oldCover = $article->cover_image;
        $newCover = null;

        if ($request->hasFile('cover_image')) {
            $newCover = $request->file('cover_image')->store('covers', 'public');

            if (! $newCover) {
                throw new \RuntimeException('Impossibile salvare la copertina.');
            }

            $data['cover_image'] = $newCover;
        }

        $data['status'] = 'in_revisione';

        try {
            DB::transaction(function () use ($article, $data, $tags) {
                $article->fill($data);
                $article->save();
                $article->tags()->sync($tags);
            });
        } catch (\Throwable $exception) {
            if ($newCover) {
                $disk->delete($newCover);
            }

            throw $exception;
        }

        if ($newCover && $oldCover && $oldCover !== $newCover) {
            $disk->delete($oldCover);
        }
    }
}
