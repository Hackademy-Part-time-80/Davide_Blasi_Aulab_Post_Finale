<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class CRUDcontroller extends Controller
{
    protected string $model;

    private function table(): string
    {
        return (new $this->model)->getTable();
    }

    public function index()
    {
        return view("pages.{$this->table()}.index", [$this->table() => ($this->model)::all()]);
    }

    public function create()
    {
        return view("pages.{$this->table()}.create");
    }

    public function store(Request $request)
    {
        ($this->model)::create($this->validated($request));
        return $this->back('Creato con successo.');
    }

    public function edit($id)
    {
        return view("pages.{$this->table()}.edit", ['item' => ($this->model)::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        ($this->model)::findOrFail($id)->update($this->validated($request, $id));
        return $this->back('Aggiornato.');
    }

    public function destroy($id)
    {
        ($this->model)::destroy($id);
        return $this->back('Eliminato.');
    }

    private function back(string $msg)
    {
        return redirect()->route("{$this->table()}.index")->with('success', $msg);
    }

    private function validated(Request $request, $id = null): array
    {
        return $request->validate([
            'name' => "required|string|max:100|unique:{$this->table()},name" . ($id ? ",$id" : ''),
        ]);
    }
}