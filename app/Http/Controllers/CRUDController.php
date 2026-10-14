<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

abstract class CRUDController extends Controller
{
    protected string $model;
    protected string $label;

    public function index()
    {
        return $this->render('index', ['items' => ($this->model)::withCount('articles')->orderBy('name')->get()]);
    }

    public function create()
    {
        return $this->render('form');
    }

    public function store(Request $request)
    {
        ($this->model)::create($this->validated($request));

        return $this->back('Creato con successo.');
    }

    public function edit($id)
    {
        return $this->render('form', ['item' => ($this->model)::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        ($this->model)::findOrFail($id)->update($this->validated($request, $id));

        return $this->back('Aggiornato con successo.');
    }

    public function destroy($id)
    {
        try {
            ($this->model)::findOrFail($id)->delete();
        } catch (QueryException $e) {
            // 23000 = violazione di foreign key: la categoria ha ancora articoli collegati
            throw_unless($e->getCode() === '23000', $e);

            return back()->with('error', 'Impossibile eliminare: ci sono articoli collegati.');
        }

        return $this->back('Eliminato con successo.');
    }

    private function table(): string
    {
        return (new $this->model)->getTable();
    }

    private function render(string $view, array $data = [])
    {
        return view("pages.taxonomy.$view", $data + ['label' => $this->label, 'route' => $this->table()]);
    }

    private function back(string $message)
    {
        return redirect()->route("{$this->table()}.index")->with('success', $message);
    }

    private function validated(Request $request, $id = null): array
    {
        return $request->validate([
            'name' => "required|string|max:100|unique:{$this->table()},name" . ($id ? ",$id" : ''),
        ]);
    }
}
