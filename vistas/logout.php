<?php
        ///////////////21 Como DESTRUIR o CERRAR una SESION con PHP////// con navbar.php/////
    session_destroy();

     ///////Para saber si embiamos encabezado//////devuelve false y usamos else  true
    if(headers_sent()){
        echo "<script> window.location.href='index.php?vista=login';</script>";
    }else{
        header("Location: index.php?vista=login");
    }