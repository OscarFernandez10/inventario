<?php
    
    require_once"main.php";

    #Almacenando datos#
    $nombre=limpiar_cadena($_POST['usuario_nombre']);
    $apellido=limpiar_cadena($_POST['usuario_apellido']);

    $usuario=limpiar_cadena($_POST['usuario_usuario']);
    $email=limpiar_cadena($_POST['usuario_email']);

    $clave_1=limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2=limpiar_cadena($_POST['usuario_clave_2']);

    #Verificando campos obligatorios#
    if($nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" || $clave_2==""){
        echo '   
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todo los campos que son obligatorios
            </div>
        ';
        exit();
    }

    #18 CRUD_ Como GUARDAR DATOS en MySQL desde PHP (USUARIO Cap.2)#
    #Verificando integridad de los datos#
    if(verificar_datos($nombre)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
                tttttttttttttttttt
            </div>
        ';
        exit();
    }
    

    if(verificar_datos($apellido)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
                eeeeeeeeeeeeeee
            </div>
        ';
        exit();
    }
    

    if(verificar_datos($usuario)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
                ssssssssssssssssssss
            </div>
        ';
        exit();
    }
     
    if(verificar_datos($clave_1) || verificar_datos($clave_2)){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVES no coincide con el formato solicitado
                ddddddddddddddddd
            </div>
        ';
        exit();
    }
      
    #Verficando el EMAIL#      //Validar si es el email correcto//
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo ingresado ya se encuentra registrado, por
                        favor elija otro
                    </div>
                ';
                 exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EMAIL ingresado no es valido
                </div>
            ';
            exit();
        }
    }
    //SELECT usuario_email FROM usuario WHERE usuario_email='oscarmfernandez79@gmail.com'


    #19 CRUD_ Como GUARDAR DATOS en MySQL desde PHP (USUARIO Cap.3)#
    #Validar el usuario que no exista en la BD#
          //////////////////VERIFICAR USUARIO//////////////////
                          #Verificando Usuarios#

    $check_usuarioo=conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
    if($check_usuario->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO ingresado ya se encuentra registrado, por
                favor elija otro
            </div>
        ';
         exit();
    }
    $check_usuario=null;

    //////////////////VERIFICAR CLAVE//////////////////
                    #Vaerficando claves#
if($clave_1!=$clave_2){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES que ha ingresado no coinciden
        </div>
    ';
    exit();
}else{
    $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
}
             ///////////////GUARDAR DATOS/////////////////
 #Guardando datos#         ""$guardar_usuario=conexion();""::Esta variable ya tiene la conexion a la BD
//$guardar_usuario=conexion();
///$guardar_usuario=$guardar_usuario->query("INSERT INTO usuario
//(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,
//usuario_email) VALUES('$nombre','$apellido','$usuario','$clave','$email')");

$guardar_usuario=conexion();
$guardar_usuario=$guardar_usuario->query("INSERT INTO usuario
(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,
usuario_email) VALUES(:nombre,:apellido,:usuario,:clave,:email)");

$marcadores=[
    ":nombre"=>$nombre,
    ":apellido"=>$apellido,
   ":usuario"=>$usuario,
    ":clave"=>$clave,
    ":email"=>$email
];
$guardar_usuario->execute($marcadores);

if($guardar_usuario->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se registro con exito
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor intente nueevamente
        </div>
    ';
}
$guardar_usuario=null;