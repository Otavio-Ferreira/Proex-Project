<?php

namespace App\Helpers\Status;

use Illuminate\Support\Str;

class Status
{
    public static function get_status_form($status_id){
        $status = [
            0 => [
                'title' => 'Inativo'
            ],
            1 => [
                'title' => 'Ativo'
            ]
        ];

        return $status[$status_id]['title'];
    } 

    public static function get_status_response_form($status_id)
    {
        $status = [
            0 => [
                'title' => 'Andamento'
            ],
            1 => [
                'title' => 'Enviado'
            ],
            2 => [
                'title' => 'Revisão'
            ],
            3 => [
                'title' => 'Corrigido'
            ],
            4 => [
                'title' => 'Aprovado'
            ]
        ];

        return $status[$status_id]['title'];
    }
}
