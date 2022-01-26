<?php
function rendering(string $path, string $view, $data){
    $loader = new \Twig\Loader\FilesystemLoader($path);
    $twig = new \Twig\Environment($loader, []);
    $template = $twig->load($view);
    echo $template->render($data);
}
