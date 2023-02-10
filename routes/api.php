<?php

use App\Http\Controllers\CadastroController;
use Illuminate\Support\Facades\Route;

Route::post('cadastrar', [CadastroController::class, 'salvar']);
