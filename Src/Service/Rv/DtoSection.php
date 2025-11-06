<?php

namespace Service\Rv;

class DtoSection
{
    private $nome_usuario;
    private $chapa_usuario;
    private $matricula_usuario;
    private $funcao_usuario;
    public function __construct($nome_usuario, $chapa_usuario, $matricula_usuario, $funcao_usuario)
    {
        $this->nome_usuario = $nome_usuario;
        $this->chapa_usuario = $chapa_usuario;
        $this->matricula_usuario = $matricula_usuario;
        $this->funcao_usuario = $funcao_usuario;
    }
    public function getNomeUsuario()
    {
        return $this->nome_usuario;
    }
    public function getChapaUsuario()
    {
        return $this->chapa_usuario;
    }

    public function getMatriculaUsuario()
    {
        return $this->matricula_usuario;
    }
    public function getFuncaoUsuario()
    {
        return $this->funcao_usuario;
    }

}