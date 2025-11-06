<?php

namespace Model;

use Service\Rv\DtoSection;

class User
{
    private $nome;
    private $chapa;
    private $matricula;
    private $funcao;

    public function __construct(DtoSection $dto)
    {
        $this->nome = $dto->getNomeUsuario();
        $this->chapa = $dto->getChapaUsuario();
        $this->matricula = $dto->getMatriculaUsuario();
        $this->funcao = $dto->getFuncaoUsuario();
    }

    public function getNome()
    {
        return strtoupper($this->nome);
    }

    public function getChapa()
    {
        return $this->chapa;
    }

    public function getMatricula()
    {
        return $this->matricula;
    }

    public function getFuncao()
    {
        return $this->funcao;
    }

    public function funcaoUser()
    {
        return strtoupper(explode(' ', $this->getFuncao())[0]);
    }
}