<?php

declare(strict_types=1);

namespace App\Service;

class Csrf
{
    const SESSION_NAME = 'biblio_csrf_token';
    const FIELD_NAME = 'biblio_csrf_check';

    private static function set_session()
    {
        if (!isset($_SESSION[self::SESSION_NAME])) {
            $_SESSION[self::SESSION_NAME] = bin2hex(random_bytes(32));
        }
    }

    public static function unset_session()
    {
        if (isset($_SESSION[self::SESSION_NAME])) {
            unset($_SESSION[self::SESSION_NAME]);
        }
    }

    public static function check()
    {
        self::set_session();
        if (!isset($_POST[self::FIELD_NAME]) || $_POST[self::FIELD_NAME] !== $_SESSION[self::SESSION_NAME]) {
            self::unset_session();
            header('HTTP/1.1 403 Forbidden');
            exit('<h1>Forbidden</h1>');
        }
        self::unset_session();
    }

    public static function token($input = true)
    {
        self::set_session();

        if ($input) {
            return '<input type="hidden" name="' . self::FIELD_NAME . '" value="' . $_SESSION[self::SESSION_NAME] . '" />';
        }
    }
}
