<?php

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
if (!isset($_SESSION['isAdmin'])) {
    $_SESSION['isAdmin'] = 0;
}
if (!isset($_SESSION['createAttempt'])) {
    $_SESSION['createAttempt'] = false;
}

$data = [];

$pdo = initDb();

if ($_SESSION['isAdmin'] === 0) {
    header('Location: ../');
} else{
    //echo"<script>alert('Administrering upptagen!')</script>";
}
if ($_SESSION['createAttempt']) {
    if ($_SESSION['createSuccess']) {
        $data["createSuccess"] = "<p>Personalen har lagts till!</p>";
        //echo "<p>Personalen har lagts till!</p>";
    } else {
        $data["createSuccess"] = "<p>Lösenorden matchar inte!<br>Försök igen!</p>";
        //echo "<p>Lösenorden matchar inte!<br>Försök igen!</p>";
    }
} else {
    $data["createSuccess"] = "";
}
rendering("views", "admin.twig", $data);