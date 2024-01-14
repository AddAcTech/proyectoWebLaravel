<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'CURP' => 'required|string',
            'name' => 'required|string|max:191',
            'award' => 'required|string|max:191',
            'event_location' => 'required|string|max:191',
            'category' => 'required|string|max:191',
        ]);

        $awarded = new User();
        $awarded->CURP = $request->CURP;
        $awarded->name = $request->name;
        $awarded->award = $request->award;
        $awarded->event_location = $request->event_location;
        $awarded->category = $request->category;
        $awarded->save();

        return response()->json([
            'message' => 'Alta exitosa',
        ]);
    }

    public function login(Request $request)
{
    $request->validate([
        'CURP' => 'required|string',
    ]);

    $user = User::where('CURP', $request->CURP)->first();

    if (!$user) {
        return response()->json([
            'message' => 'CURP incorrecto'
        ], Response::HTTP_UNAUTHORIZED);
    }

    Auth::login($user);

    $token = $user->createToken('auth_token')->plainTextToken; // Genera el token

    return response()->json([
        'message' => 'success',
        'token' => $token, // Envía el token en la respuesta
    ],200);
}


   public function userProfile()
{
    $user = auth()->user(); // Obtenemos la instancia del usuario logueado
    /* if (!$user) {
        return response()->json([
            'message' => 'No se encontró el usuario'
        ], 404);
    } */

    return response()->json($user, 200);
}
    
    public function patchUser(Request $request, $id)
    {
        try {
        $user = User::find($id);
        $user->attendance_status = $request->attendance_status;
        $user->guest = $request->guest;
        $user->physical_condition = $request->physical_condition;
        $user->pdf_invitation = $request->pdf_invitation;
        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
    } 


    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado',
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Sesión cerrada'
        ], 200);
    }

    public function allUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }
}
