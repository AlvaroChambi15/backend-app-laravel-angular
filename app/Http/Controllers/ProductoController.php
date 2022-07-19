<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->buscar or $request->buscar != null) {
            $productos = Producto::orWhere("nombre", "like", "%" . $request->buscar . "%")
                ->orWhere("cantidad", "like", "%" . $request->buscar . "%")
                ->with('categoria')->paginate(2);
        } else {
            $productos = Producto::with('categoria')->paginate(2);
        }


        return response()->json($productos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // NO USAMOS CREATE POR QUE ESTAMOS USANDO ANGULAR PARA EL FRONTEND
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|min:3|max:200",
            "categoria_id" => "required"
        ]);
        // GUARDAR
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return response()->json(["mensaje" => "Producto Registrado"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return response()->json($producto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        // ESTE TAMPOCO SE USA
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            "nombre" => "required|min:3|max:200",
            "categoria_id" => "required"
        ]);
        // MODIFICAR
        $producto->nombre = $request->nombre;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return response()->json(["mensaje" => "Producto Modificado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(["mensaje" => "Producto Eliminado"], 201);
    }

    public function actualizarImagen(Request $request, $id)
    {
        if ($file = $request->file("imagen")) {

            $direccion_archivo = time() . "-" . $file->getClientOriginalName();
            $file->move("imagenes/", $direccion_archivo);

            $producto = Producto::find($id);
            $producto->imagen = "imagenes/" . $direccion_archivo;
            $producto->save();

            return response()->json(["mensaje" => "Imagen Actualizada"]);
        }
        return response()->json(["mensaje" => "Debe enviar una imagen"]);
    }
}