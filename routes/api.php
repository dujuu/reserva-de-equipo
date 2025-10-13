<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 1. RUTAS PÚBLICAS 

// Ruta para iniciar sesión
// URL: /api/login
Route::post('/login', [AuthController::class, 'login']);

// Ruta para registrar un nuevo usuario
// URL: /api/register
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta de prueba para verificar el token (ya la tenías)
    // URL: /api/user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Ruta para cerrar sesión (requiere que el usuario esté autenticado para invalidar su token)
    // Método: POST
    // URL: /api/logout
    Route::post('/logout', [AuthController::class, 'logout']); 
    
    // Aquí van tus rutas para POSTS, PRODUCTOS, etc.
});