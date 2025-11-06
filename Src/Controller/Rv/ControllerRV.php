<?php

namespace Controller\Rv; 

use Repository\Connection;
use Repository\Rv\PdoRepository;
use Service\Rv\DtoSection;
use Model\User;
use Service\Rv\ServiceController;
use Controller\Rv\ControllerInterface;

class ControllerRV implements ControllerInterface
{
    private $dtoSection;
    private $mesAnterior;

    public function __construct($dtoSection, $mesAnterior = false)
    {
        $this->dtoSection = $dtoSection;
        $this->mesAnterior = $mesAnterior;
    }

    public function handle()
    {
        $user = new User($this->dtoSection);
        $conn = new Connection();

        try {
            $service = new ServiceController($user, $conn, $this->mesAnterior);
            $service->execute();
        } finally {
            $conn->close();
        }
    }
}

