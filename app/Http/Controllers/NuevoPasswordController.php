<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

class NuevoPasswordController extends Controller
{
    public function recuperarPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if ($status == Password::RESET_LINK_SENT) {
            return ['status' => __($status)];
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => ["required", "confirmed", RulesPassword::defaults()]
        ]);

        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"),
            function ($user) use ($request) {
                $user->forcefill([
                    "password" => Hash::make($request->password),
                    "remember_token" => 'ran_' . time()
                ])->save();
                //ELIMINANDO LOS TOKENS
                // $request->user()->tokens()->delete();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {

            return response([
                "mensaje" => "La contraseña ha cambiado!"
            ]);
        }

        return response([
            "mensaje" => __($status)
        ], 500);
    }
}