<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Support\Facades\Session;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostrar el dashboard con la lista de contactos
     */
    public function index(Request $request)
    {
        $query = Contacto::query();
        
        // Filtro de búsqueda
        if ($request->has('buscar') && !empty($request->buscar)) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                  ->orWhere('usuario', 'like', '%' . $buscar . '%')
                  ->orWhere('telefono', 'like', '%' . $buscar . '%')
                  ->orWhere('mensaje', 'like', '%' . $buscar . '%');
            });
        }
        
        // Ordenar por fecha de creación (más recientes primero)
        $contactos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('contactos.index', compact('contactos'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar formulario para crear nuevo contacto
     */
    public function create()
    {
        return view('contactos.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guardar nuevo contacto en la base de datos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'usuario' => 'required|string|max:50',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres',
            'usuario.required' => 'El usuario es obligatorio',
            'usuario.max' => 'El usuario no puede tener más de 50 caracteres',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres',
            'mensaje.required' => 'El mensaje es obligatorio',
            'mensaje.max' => 'El mensaje no puede tener más de 1000 caracteres',
        ]);

        // Crear el nuevo contacto
        Contacto::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'telefono' => $request->telefono,
            'mensaje' => $request->mensaje,
        ]);

        Session::flash('success', 'Contacto creado exitosamente.');
        return redirect()->route('contactos.index');
    }

    /**
     * Display the specified resource.
     * Mostrar un contacto específico
     */
    public function show(Contacto $contacto)
    {
        return view('contactos.show', compact('contacto'));
    }

    /**
     * Show the form for editing the specified resource.
     * Mostrar formulario para editar contacto
     */
    public function edit(Contacto $contacto)
    {
        return view('contactos.edit', compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     * Actualizar contacto en la base de datos
     */
    public function update(Request $request, Contacto $contacto)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'usuario' => 'required|string|max:50',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres',
            'usuario.required' => 'El usuario es obligatorio',
            'usuario.max' => 'El usuario no puede tener más de 50 caracteres',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres',
            'mensaje.required' => 'El mensaje es obligatorio',
            'mensaje.max' => 'El mensaje no puede tener más de 1000 caracteres',
        ]);

        // Actualizar el contacto
        $contacto->update([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'telefono' => $request->telefono,
            'mensaje' => $request->mensaje,
        ]);

        Session::flash('success', 'Contacto actualizado exitosamente.');
        return redirect()->route('contactos.index');
    }

    /**
     * Remove the specified resource from storage.
     * Eliminar contacto de la base de datos
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        
        Session::flash('success', 'Contacto eliminado exitosamente.');
        return redirect()->route('contactos.index');
    }

    /**
     * Búsqueda AJAX de contactos
     */
    public function buscar(Request $request)
    {
        $query = $request->get('q');
        
        $contactos = Contacto::where('nombre', 'like', '%' . $query . '%')
                            ->orWhere('usuario', 'like', '%' . $query . '%')
                            ->orWhere('telefono', 'like', '%' . $query . '%')
                            ->limit(10)
                            ->get();
        
        return response()->json($contactos);
    }
}

