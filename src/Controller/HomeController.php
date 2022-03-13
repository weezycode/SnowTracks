<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */

    public function homepage()
    {
        $number = random_int(0, 100);
        return $this->render('Home/index.html.twig', [
            'number' => $number,
        ]);
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
