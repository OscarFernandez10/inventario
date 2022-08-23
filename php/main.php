<?php

//Conexion a la BD, y verificacion de datos de formulario //funciones para evitar inyecciones SQL
//11 FUNCION para VALIDAR FORMULARIOS con EXPRECIONES REGULARES
    function conexion(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario','root','');
        return $pdo;
    }
    //Un ejemplo de como cargar la BD 
    //$pdo ->query("INSERT INTO categoria(categoria_nombre,categoria_ubicacion) VALUES('prueba','texto ubicacion')");

    #funcion Verificar Datos#         #preg_match con expreciones regulares#
    function verificar_datos($filtro,$cadena){
        if(preg_match("/^".$filtro."$/",$cadena)){
            return false;
        }else{
            return true;
        }
    }
    #Condicionales simple#
    # $nombre="Oscar"; 
    #if(verificar_datos("[a-zA-Z]{5,10}",$nombre)){
    #    echo "Los datos no coinciden";     //si pongo {6,10} RR: Los datos no coinciden por que "Oscar" tiene 5 letra#
    //}

    #12 FUNCION PHP para EVITAR INYECCION SQL#
    #Limpiar cadenas de texto#
    #https://www.php.net/manual/es/function.trim.php#
    #trim: Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena ..EJ. ( Oscar) #

    #https://www.php.net/manual/es/function.stripslashes.php#
    #stripslashes — Quita las barras de un string con comillas escapadas#

    #https://www.php.net/manual/es/function.str-ireplace.php#
    #str_ireplace: Version insensible a mayusculas y minusculas de str_replace() #
    function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>","",$cadena);
        $cadena=str_ireplace("</script>","",$cadena);
        $cadena=str_ireplace("<script src","", $cadena);
        $cadena=str_ireplace("<script type=","", $cadena);
        $cadena=str_ireplace("SELECT * FROM", "", $cadena);
        $cadena=str_ireplace("DELETE FROM", "", $cadena);
        $cadena=str_ireplace("INSERT INTO", "", $cadena);
        $cadena=str_ireplace("DROP TABLE", "", $cadena);
        $cadena=str_ireplace("DROP DATABASE", "", $cadena);
        $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena=str_ireplace("SHOW TABLES;", "", $cadena);
        $cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
        $cadena=str_ireplace("<?php", "", $cadena);
        $cadena=str_ireplace("?>", "", $cadena);
        $cadena=str_ireplace("__","", $cadena);
        $cadena=str_ireplace("^", "", $cadena);
        $cadena=str_ireplace("<", "", $cadena);
        $cadena=str_ireplace("[", "", $cadena);
        $cadena=str_ireplace("]", "", $cadena);
        $cadena=str_ireplace("==", "", $cadena);
        $cadena=str_ireplace(";", "", $cadena);
        $cadena=str_ireplace("::", "", $cadena);
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        return $cadena;
    }
    #$texto="<script> Hola mundo </script>";#
    #echo limpiar_cadena($texto);#
    
    
    
    #13 FUNCION PHP para RENOMBRAR FOTOS#
    #Funcion renombrar fotos#
    function renombrar_fotos($nombre){
        $nombre=str_ireplace(" ","_",$nombre);
        $nombre=str_ireplace("/", "_", $nombre);
        $nombre=str_ireplace("#", "_", $nombre);
        $nombre=str_ireplace("-", "_", $nombre);
        $nombre=str_ireplace("$", "_", $nombre);
        $nombre=str_ireplace(".", "_", $nombre);
        $nombre=str_ireplace(",", "_", $nombre);
        $nombre=$nombre."_".rand(0,100);
        return $nombre;
    }
    //$foto="Play Station 5 black/edition";
    //echo renombrar_fotos($foto);       //RR:  Play_Station_5_black_edition_24


    ///////////////////////////////////TABLA BOTON////////////////////////////////////////////////////////////////
    
    #14 FUNCION PHP para GENERAR PAGINADOR DE TABLAS#
    //Funcion paginador de tablas
    function paginador_tabla($pagina,$Npaginas,$url,$botones){
        $tabla='<nav class="pagination is-centered is-rounded" 
        role="navigation" aria-label="pagination">';
    
        if($pagina<=1){
            $tabla.='
            <a class="pagination-previous is-disabled" disabled >Anterior</a>
            <ul class="pagination-list">
            ';
        }else{
            $tabla.='
            <a class="pagination-previous" href="'.$url.($pagina-1).
            '">Anterior</a>
            <ul class="pagination-list">
            <li><a class="pagination-link" href="'.$url.'1">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            ';
        }
        //con esta funcion se va generar todos los botones 
        $ci=0;
        for($i=$pagina; $i<=$Npaginas; $i++){
            if($ci>=$botones){
                break;
            }
            if($pagina==$i){
                $tabla.='<li><a class="pagination-link is-current" href="'.
                $url.$i.'">'.$i.'</a></li>';
            }else{
                $tabla.='<li><a class="pagination-link href="'.$url.$i.'">'.
                $i.'</a></li>';
            }

            $ci++;

        }




            //Esta parte es la boton siguiente desabilitado del boton 3 
        if($pagina==$Npaginas){
            $tabla.='
            </ul>
            <a class="pagination-next is-disabled" disabled >Siguiente</a>
            ';
        }else{
            $tabla.=' 
                <li><span class="pagination-ellipsis">&hellip;</span></li>
                <li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
            </ul>
            <a class="pagination-next" href="'.$url.($pagina+1).
            '">Siguiente</a>
            ';
        }

        $tabla.='</nav>';
        return $tabla;
    }