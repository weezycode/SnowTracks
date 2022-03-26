<?php

namespace App\Service;

class Random
{

    function randomName()
    {
        $name = array(
            'Mariame',
            'Awa',
            'Amélie',
            'Juan',
            'Luis',
            'Pedro',
            'Michel',
            'Paul',
            'Sophie',
            'Sirra'

            // and so on

        );
        return $name[rand(0, count($name) - 1)];
    }

    function randomGroupe()
    {
        $groupe = array(
            'BackFlip',
            'BackFlip360',
            '360Drift',
            // and so on

        );
        return $groupe[rand(0, count($groupe) - 1)];
    }
}
