<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;

class categoriaController extends Controller
{
   
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();
        return view('categoria.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)  //validacion de datos
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
            return redirect()->route('categorias.index')->with('success', 'Categoria Registrada');
        } catch (Exception $e) {
            DB::rollback();
            // Agregar mensaje de error a la sesión
            return redirect()->route('categorias.index')->with('error', 'Error al registrar la categoría.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Caracteristica::where('id', $categoria->caracteristica->id)
            ->update($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoria Editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if ($categoria->caracteristica->estado == 1) {
            Caracteristica::where('id', $categoria->caracteristica->id)
                ->update(['estado' => 0]);
            $message = 'Categoria eliminada';
        } else {
            Caracteristica::where('id', $categoria->caracteristica->id)
                ->update(['estado' => 1]);
            $message = 'Categoria restaurada';
        }
        // Corregir el error tipográfico en 'success'
        return redirect()->route('categorias.index')->with('success', $message);
    }
}
