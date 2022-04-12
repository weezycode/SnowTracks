<?php

declare(strict_types=1);

namespace  App\Service;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;

final class Token
{


    public function genToken()
    {
        return md5(uniqid());
    }
}
