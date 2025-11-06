<?php
namespace Service;

class ViewRenderer
{
    private $viewPath;
    private $data = [];

    public function __construct($viewPath = __DIR__ . '/../View/')
    {
        $this->viewPath = rtrim($viewPath, '/') . '/';
    }

    public function render($view, $data = [])
    {
        $this->data = $data;
        $file = $this->viewPath . $view . '.php';

        if (!file_exists($file)) {
            throw new \Exception("View não encontrada: {$file}");
        }

        // Torna as variáveis disponíveis dentro da view
        extract($this->data);

        // Inclui o arquivo da view
        include $file;
    }
}
