<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController
{
    /**
     * @Route("/")
     */

    public function homepage()
    {
        return new Response('what a be with ');
    }

    /**
     * @Route("/question/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf(
            'Regardez ma nouvelle page "%s"!',
            ucwords(str_replace('-', ' ', $slug))
        ));
    }
}
