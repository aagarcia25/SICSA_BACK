<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use InvalidArgumentException;
use RuntimeException;

trait ApiDocTrait
{

    public function UploadFile($TOKEN, $Ruta, $nombre_archivo, $file, $generaRoute)
    {
        // Validar que la ruta del archivo no esté vacía
        if (empty($file)) {
            throw new InvalidArgumentException("La ruta del archivo no puede estar vacía");
        }

        // Depuración: Imprimir la ruta del archivo
        error_log("Ruta del archivo: " . $file);

        try {
            $client = new Client();
            $headers = [
                'Authorization' => $TOKEN,
            ];
            $options = [
                'verify' => false,
                'timeout' => 500.14,
                'multipart' => [
                    [
                        'name' => 'ADDROUTE',
                        'contents' => $generaRoute,
                    ],
                    [
                        'name' => 'ROUTE',
                        'contents' => $Ruta,
                    ],
                    [
                        'name' => 'APP',
                        'contents' => 'SICSA',
                    ],
                    [
                        'name' => 'FILE',
                        'contents' => Utils::tryFopen($file, 'r'),
                        'filename' => $nombre_archivo,
                        'headers' => [
                            'Content-Type' => '<Content-type header>',
                        ],
                    ],
                ]
            ];

            // Crear la solicitud
            $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/SaveFile', $headers);

            // Enviar la solicitud y obtener la respuesta
            $res = $client->sendAsync($requestter, $options)->wait();
            $data = json_decode($res->getBody()->getContents());

            return $data;
        } catch (FileNotFoundException $e) {
            throw new RuntimeException("El archivo especificado no fue encontrado: " . $e->getMessage());
        } catch (Exception $e) {
            throw new RuntimeException("Ocurrió un error al intentar subir el archivo: " . $e->getMessage());
        }
    }


    public function GetFile($TOKEN, $Ruta, $nombre_archivo)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],
                [
                    'name' => 'NOMBRE',
                    'contents' => $nombre_archivo,
                ],

            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/GetByName', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        //var_dump($data);
        return $data;
    }

    public function DeleteFile($TOKEN, $Ruta, $nombre_archivo)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],
                [
                    'name' => 'NOMBRE',
                    'contents' => $nombre_archivo,
                ],

            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/DeleteFile', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function DeleteFileByRoute($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],

            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/DeleteFileByRoute', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function ListFile($TOKEN, $Ruta, $nombre_archivo)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],

            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/GetByName', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function GetByRoute($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],
            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/GetByRoute', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function CreateDirectorio($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],


            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/CreateDirectorio', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function DeleteDirectorio($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],


            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/DeleteDirectorio', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }


    public function ListFileSimple($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],


            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/ListFileSimple', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }


    public function DeleteFileSimple($TOKEN, $Ruta)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ROUTE',
                    'contents' => $Ruta,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],

            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/DeleteFileSimple', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }

    public function moverArchivos($TOKEN, $ORIGEN, $DESTINO)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ORIGEN',
                    'contents' => $ORIGEN,
                ],
                [
                    'name' => 'DESTINO',
                    'contents' => $DESTINO,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],


            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/moverArchivos', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }


    public function VerificaMueveArchivos($TOKEN, $ORIGEN, $DESTINO)
    {

        $client = new Client();
        $headers = [
            'Authorization' => $TOKEN,
        ];
        $options = [
            'verify' => false,
            'timeout' => 500.14,
            'multipart' => [
                [
                    'name' => 'ORIGEN',
                    'contents' => $ORIGEN,
                ],
                [
                    'name' => 'DESTINO',
                    'contents' => $DESTINO,
                ],
                [
                    'name' => 'APP',
                    'contents' => 'SICSA',
                ],


            ]
        ];
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/VerificaMueveArchivos', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
    }
}
