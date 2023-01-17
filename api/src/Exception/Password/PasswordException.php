<?php

namespace App\Exception\Password;

use phpDocumentor\Reflection\Types\Static_;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordException extends BadRequestHttpException
{
    public static function invalidLength():self{
        throw new self('minimo 6 carateres');
    }

    public static function invalidFormat():self{
        throw new self('formato invalido');
    }
}