<?php

namespace App\Http\Controllers\Auth; // <-- Asegúrate de que este namespace coincida con tu ruta

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use App\Models\Persona; 
use App\Models\User;
use App\Models\Rol;


class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario (Persona y User) y genera un token.
     */
    public function register(Request $request) // <--- ¡AQUÍ EMPIEZA EL MÉTODO!
    {
        // 1. Validar TODOS los datos
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'nullable|string|max:255', // Añadido 'nullable' si es opcional
            'Rut' => 'required|string|unique:persona,Rut',
            'email' => 'required|email|unique:persona,Email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // 2. Crear la Entidad Persona
        $persona = Persona::create([
            'Nombre' => $request->Nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2 ?? null,
            'Rut' => $request->Rut,
            'Email' => $request->email,
        ]);
    
        // 3. Crear la Entidad User 
        $user = User::create([
            'idPersona' => $persona->IdPersona, 
            // Contrasena debe coincidir con la 'C' mayúscula de tu tabla
            'Contrasena' => Hash::make($request->password), 
            'estadoSancion' => 'ACTIVO', 
        ]);
    
        // 4. Asignar Rol Predeterminado 
        $defaultRole = Rol::where('Nombre', 'ALUMNO')->first(); 
        
        if ($defaultRole) {
            $user->roles()->attach($defaultRole->IdRol);
        } else {
            // Manejo de error si el rol ALUMNO no existe.
            return response()->json(['message' => 'Error: Rol predeterminado no encontrado.'], 500);
        }
    
        // 5. Generar Token 
        $token = $user->createToken('auth-token')->plainTextToken;
    
        return response()->json([
            'user' => $user->load('persona', 'roles'),
            'token' => $token
        ], 201);
    } 
}