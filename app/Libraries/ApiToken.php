<?php

namespace App\Libraries;

use Illuminate\Support\Str;

class ApiToken
{
    private $length;
    private $crypt;

    public function __construct(int $length, string $crypt = 'sha1')
    {
        $this->length = ($length < 200 || $length > 500) ? 200 : $length;
        $this->crypt = $crypt;
    }

    public function generate(...$args): string
    {
        $chain = '';
        foreach ($args as $arg) {
            if (!is_string($arg) && !is_int($arg)) {
                throw new \Exception('Todos los argumentos deben ser de tipo String o Integer', 400);
            }
            $chain .= $arg;
        }
        $chain .= Str::random($this->length);

        return $this->encryptString($chain);
    }

    private function encryptString(string $chain): string
    {
        switch ($this->crypt) {
            case 'md5':
                $chain = md5($chain);
                break;

            default:
                $chain = sha1($chain);
                break;
        }

        return $chain;
    }
}
