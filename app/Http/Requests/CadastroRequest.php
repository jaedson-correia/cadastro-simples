<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\inscricaoRule;
use Illuminate\Foundation\Http\FormRequest;

class CadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => [
                'required'
            ],
            'tipoPessoa' => [
                'required',
                'integer'
            ],
            'inscricao' => [
                'required',
                'min:'.($this->tipoPessoa === User::TIPO_PF ? 11 : 14),
                new inscricaoRule($this->tipoPessoa),
                'unique:users,inscricao'
            ],
            'email' => [
                'required',
                'email'
            ],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Preencha o campo nome',
            'tipoPessoa.required' => 'Selecione um tipo de pessoa',
            'inscricao.required' => 'Preencha o campo '.($this->tipoPessoa == User::TIPO_PF ? 'CPF' : 'CNPJ'),
            'inscricao.unique' => 'Esse '.($this->tipoPessoa == User::TIPO_PF ? 'CPF' : 'CNPJ').' já está cadastrado',
            'inscricao' => 'Insira um '.($this->tipoPessoa == User::TIPO_PF ? 'CPF' : 'CNPJ').' válido',
            'email.required' => 'Preencha o campo e-mail',
            'email.email' => 'Insira um e-mail válido'
        ];
    }
}
