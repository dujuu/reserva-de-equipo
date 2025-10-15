<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Envía un enlace de restablecimiento de contraseña al correo del usuario.
     */
    public function sendResetLinkEmail(Request $request)
{
    // Acepta "Email" o "email" y lo normaliza
    $email = $request->input('email') ?? $request->input('Email');

    if (!$email) {
        return response()->json([
            'message' => 'El correo no fue recibido correctamente.',
            'debug' => $request->all()
        ], 400);
    }

    // Normalizar el campo a "email" para que Password::sendResetLink funcione
    $request->merge(['email' => $email]);

    $request->validate(['email' => 'required|email']);

    // Verificar existencia del usuario (tu columna real es "Email")
    $user = \App\Models\User::where('Email', $email)->first();

    if (!$user) {
        return response()->json(['message' => 'No existe un usuario con ese correo.'], 404);
    }

    // Forzar compatibilidad con password_resets (Laravel espera "email" minúscula)
    \DB::table('password_resets')->where('email', $email)->delete();

    $token = \Str::random(60);

    \DB::table('password_resets')->insert([
        'email' => $email, // <- usa minúscula aquí
        'token' => $token,
        'created_at' => now(),
    ]);

    // Enviar correo usando tu lógica de email ya configurada
    try {
        \Mail::raw("Token de recuperación: $token", function ($message) use ($email) {
            $message->to($email)->subject('Recuperación de contraseña');
        });

        return response()->json(['message' => 'Correo de recuperación enviado correctamente.']);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'No se pudo enviar el correo. Verifica la configuración del servidor.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
