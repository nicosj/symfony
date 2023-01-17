<?php

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyExistException extends ConflictHttpException
{
    private const  MESSAGE= 'User with email %s alredy exist';

    public static function fromEmail(string $email):self{
        throw new self(\sprintf(self::MESSAGE, $email));
    }

}