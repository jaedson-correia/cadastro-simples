<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroRequest;
use App\Models\User;

class CadastroController extends Controller
{
    public function salvar(CadastroRequest $request)
    {
        $validado = $request->validated();

        $usuario = User::create([
            'nome' => $validado['nome'],
            'tipo_pessoa' => $validado['tipoPessoa'],
            'inscricao' => $validado['inscricao'],
            'email' => $validado['email'],
        ]);

        return response()->json([
            'inscricao' => $usuario->inscricao
        ], 201);
    }
}
