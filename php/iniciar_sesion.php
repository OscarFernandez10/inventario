<?php

    #Almacenando datos#
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);

    #Verificando campos obligatorios#
    if($usuario=="" || $clave==""){
        echo '   
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todo los campos que son obligatorios
            </div>
        ';
        exit();
    }

    #Verificando integridad de los datos#
    //if(verificar_datos($nombre)){
        //if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        if(verificar_datos($usuario)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    //if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        if(verificar_datos($clave)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
   
    $check_user=conexion();
    $check_user=$cherk_user->query("SELECT * FROM usuario WHERE 
    usuario_usuario='$usuario'");

    //rowCount() Para contar cuanto registro hemos seleccionado
    if($check_user->rowCount()==1){
        $check_user=$check_user->fetch();
            /////Si el usuario_usuario que hemos seleccionando de la BD es 
            ////(==)igual $usuario que hemos enviado del formulario
            ////Tambien la clave si todo coincide entonces que todo es correcto y podemoa iniciar la secion, 
            ////////////// o si no va enviar el error echo////////
        if($check_user['usuario_usuario']==$usuario && password_verify
        ($clave,$check_user['usuario_clave'])){

            ///////Variables de secion////////
            $_SESSION['id']=$check_user['usuario_id'];
            $_SESSION['nombre']=$check_user['usuario_nombre'];
            $_SESSION['apellido']=$check_user['usuario_apellido'];
            $_SESSION['usuario']=$check_user['usuario_usuario'];

            ///////Para saber si embiamos encabezado//////
            if(headers_sent()){
                echo "<script> window.location.href='index.php?vista=home' ;</script>";
            }else{
                header("Location: index.php?vista=home");
            }

        }else{
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario o clave incorrectos
                </div>
            ';

        }
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
    }
    $check_user=null;