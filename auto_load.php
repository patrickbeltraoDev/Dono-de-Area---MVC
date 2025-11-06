<?php
spl_autoload_register(function ($class) {
    // base é a pasta Src
    $base_dir = __DIR__ . '/Src/';
    // converte namespace para caminho
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Classe não encontrada: $file");
    }
}); 




