<?php

namespace app\base;

use app\base\exception\RedirectException;

/**
 * Response definition class
 */
class Response
{
    public function redirect($url, $code = 302, $message = '') {
        http_response_code($code);
        header("Location: $url", true);

        throw new RedirectException($message);
    }
}

