<?php

use Controller\Home\ControllerHome;
use Controller\Rv\ControllerRV;
use Controller\Elegiveis\ControllerElegivies;

return [
    'dono_de_area' => ControllerHome::class,
    'rv' => ControllerRV::class,
    'elegiveis' => ControllerElegivies::class,
    'verifyFilter' => [ControllerElegivies::class, 'verifyFilter'],
    'buscarElegiveis' => [ControllerElegivies::class, 'buscarElegiveis'],
    'saveElegiveis' => [ControllerElegivies::class, 'saveElegiveis'],
];
