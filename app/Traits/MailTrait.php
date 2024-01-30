<?php

namespace App\Traits;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

trait MailTrait
{


    public function sendMailNotificacion($correo,  $body, $adjunto = null)
    {

        $Encabezado = "Aviso de Monitoreo";

        if ($correo !== '') {
            try {
                // Crear un mensaje de Laravel Mail
                Mail::send([], [], function (Message $message) use ($correo, $Encabezado, $body, $adjunto) {
                    $message->to($correo)
                        ->subject($Encabezado);
                    // Establecer el cuerpo del mensaje en formato HTML
                    $message->html($body);
                    // Adjuntar el archivo si está definido
                    if ($adjunto !== null) {
                        $message->attach($adjunto);
                    }
                });
                Log::info('Correo enviado a ' . $correo);
            } catch (\Exception $e) {
                // Manejar la excepción en caso de un error al guardar el archivo
                info('No se Envio correo ' . $e->getMessage());
            }
        }
    }
}
