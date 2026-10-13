<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    public function index()
    {
        $editoriales = Editorial::latest()->get();

        return view('editorials.index', compact('editoriales'));
    }

    public function create()
    {
        return view('editorials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:editorials,nombre',
        ]);

        Editorial::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()
            ->route('editorials.index')
            ->with('success', 'Editorial registrada correctamente.');
    }

    public function show(Editorial $editorial)
    {
        return view('editorials.show', compact('editorial'));
    }

    public function edit(Editorial $editorial)
    {
        return view('editorials.edit', compact('editorial'));
    }

    public function update(Request $request, Editorial $editorial)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:editorials,nombre,' . $editorial->id,
        ]);

        $editorial->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()
            ->route('editorials.index')
            ->with('success', 'Editorial actualizada correctamente.');
    }

    public function destroy(Editorial $editorial)
    {
        $editorial->delete();

        return redirect()
            ->route('editorials.index')
            ->with('success', 'Editorial eliminada correctamente.');
    }
}