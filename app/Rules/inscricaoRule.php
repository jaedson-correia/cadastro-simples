<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;

class inscricaoRule implements InvokableRule
{

    public function __construct(
        protected int $tipoPessoa
    )
    { }
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $inscricao = preg_replace('/\D+/', '', $value);
        if ($this->tipoPessoa == User::TIPO_PF) {
            for ($i = 9; $i < 11; $i++) {
                for ($x = 0, $c = 0; $c < $i; $c++) {
                    $x += $inscricao[$c] * (($i + 1) - $c);
                }
                $x = ((10 * $x) % 11) % 10;
                if ($inscricao[$c] != $x) {
                    $fail('');
                }
            }
        } else if ($this->tipoPessoa == User::TIPO_PJ) {
            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
                $soma += $inscricao[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($inscricao[12] != ($resto < 2 ? 0 : 11 - $resto)) {
                $fail('');
            }

            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                $soma += $inscricao[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($inscricao[13] != ($resto < 2 ? 0 : 11 - $resto)) {
                $fail('');
            }
        }

    }
}
