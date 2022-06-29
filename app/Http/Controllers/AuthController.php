<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validar
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verificar
        $credenciales = request(["email", "password"]);

        //return $request->user();

        if (!Auth::attempt($credenciales)) {
            return response()->json([
                "mensaje" => "No Autorizado"
            ], 401);
        }


        // generar tonken
        $usuario = $request->user();
        $tokenResult = $usuario->createToken("login");
        $token = $tokenResult->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "usuario" => $usuario
        ]);

        // responder
    }

    public function registro(Request $request)
    {
        //validar
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"
        ]);

        // registro
        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);

        $usuario->save();

        // responder
        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "mensaje" => "Logout"
        ]);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user());
    }
}