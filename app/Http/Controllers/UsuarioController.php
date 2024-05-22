<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

    public function index()
    {
        try {
            $usuarios = Usuario::all();
            return response()->json(['data' => $usuarios]);            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante o processamento da sua requisição.'], 500);
        }
    }
    public function show($id)
    {
        try {
            $usuario = Usuario::find($id);

            if ($usuario == null) {
                return response()->json(['error' => 'Usuário não existe'], 404);
            }

            return response()->json($usuario, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante o processamento da sua requisição.'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::find($id);

            if ($usuario == null) {
                return response()->json(['error' => 'Usuário não existe'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string|min:3|max:50',
                'email' => 'email|required:usuarios,email',
                'password' => 'string|min:6|max:20|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->name) {
                $usuario->name = $request->name;
            }

            if ($request->email) {
                $usuario->email = $request->email;
            }

            if ($request->password) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();

            return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante o processamento da sua requisição.'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:50',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:6|max:20|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $usuario = Usuario::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // bcrypt para criptografar a senha
            ]);

            return response()->json(['message' => 'Usuário registrado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante o processamento da sua requisição.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::find($id);

            if ($usuario == null) {
                return response()->json(['error' => 'Usuário não existe'], 404);
            }

            $usuario->delete();

            return response()->json(['message' => 'Usuário excluído com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante o processamento da sua requisição.'], 500);
        }
    }
}
