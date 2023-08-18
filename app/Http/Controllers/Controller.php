<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function buscamsg(int $code, $mensaje)
    {
        $valor = "";
        switch ($code) {
            case 23000:
                $valor = "Valor duplicado ya existe, por favor verifique";
                break;
            case 1:
                $valor = "i es igual a 1";
                break;
            default:
                $valor = $mensaje;

        }

        return $valor;
    }
}
