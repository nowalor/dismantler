<?php

/*
 * Should maybe be in database instead?...
 */

namespace App\Helpers\Constants;

class FenixDismantler
{
    const DISMANTLERS =
        [
            'A' => [
                'full_name' => 'Ådalens Bildemontering AB',
                'email' => 'jorgen@adalens.se',
                'code' => 'A',
            ],
            'BO' => [
                'full_name' => 'Borås Bildemontering AB',
                'code' => 'BO',
                'email' => 'info@borasbildemontering.se',
            ],
            'F' => [
                'full_name' => 'Norrbottens Bildemontering AB',
                'code' => 'F',
                'email' => 'info@nbd.se',
            ],
            'N' => [
                'full_name' => 'Jönköpings bildemontering',
                'code' => 'N',
                'email' => 'info@jb-bildemo.se',
            ],
            'AL' => [
                'full_name' => 'Allbildelar',
                'code' => 'AL',
                'email' => 'nicolas.ronnegard@allbildelar.se',
            ],
            'S' => [
                'full_name' => 'Kungsåra',
                'code' => 'S',
                'email' => 'info@kungsarabildemo.se',
            ],
        ];

}
