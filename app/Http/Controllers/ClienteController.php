<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->q;

        $clientes = Cliente::orWhere("nombre_completo", "LIKE", "%" . $buscar . "%")
            ->orWhere("ci_nit", "LIKE", "%" . $buscar . "%")
            ->paginate(20);

        return response()->json($clientes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clie = new Cliente;

        $clie->nombre_completo = $request->nombre_completo;
        $clie->ci_nit = $request->ci_nit;
        $clie->telefono = $request->telefono;
        $clie->direccion = $request->direccion;
        $clie->save();

        return response()->json(["data" => $clie, "mensaje" => "Cliente Registrado!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}