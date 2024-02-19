<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Utils;

trait ApiDocTrait
{
    public function UploadFile($TOKEN, $Ruta, $nombre_archivo, $file, $generaRoute)
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
        $requestter = new Psr7Request('POST', env('APP_DOC_API') . '/api/ApiDoc/SaveFile', $headers);
        $res = $client->sendAsync($requestter, $options)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data;
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
}
