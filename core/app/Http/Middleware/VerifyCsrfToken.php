<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/home/ipnstripe', '/home/tranfee', '/home/convert-fee', '/api/login','api/btc-usd','api/usd-btc'
    ];
}
