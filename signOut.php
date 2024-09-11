<?php
session_start(); // Pokreni sesiju

// Obriši sve podatke u sesiji
session_unset();

// Uništi sesiju
session_destroy();

// Preusmjeri korisnika na početnu stranicu s obaviješću "Welcome Guest"
header("Location: home.php?user=Guest");
exit();
?>
