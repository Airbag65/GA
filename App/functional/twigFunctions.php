<?php
function rendering(string $path, string $view, $data){
    // denna funktion kallas på i index.php
    // det var er path som därmed inte stämde och när den laddning inte fungerade så krashade det
    // jag lade till bytet nedan som ni ser
    // enklaste sättet att hitta felet för mig var att skriva en enkel echo och exit för att se när det gick åt fanders
    //echo "hit";
    // exit();
    // dessa flyttade jag successivt genom koden för att se var felet uppstår och då hittade jag det på mapparna med Twig
    $loader = new \Twig\Loader\FilesystemLoader("../App/".$path);
    $twig = new \Twig\Environment($loader, []);
    $template = $twig->load($view);
    echo $template->render($data);
}
