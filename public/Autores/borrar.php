<?php
session_start();
require __DIR__."/../../vendor/autoload.php";
use Src\Autores;

//Comporbamos que mandamos por post el campo autor el cual hemos serializado , el post lo enviamos atraves del index , por un campo oculto 
if(!isset($_POST['autor'])){
    header("Location:index.php");
    die();
}


//Lo deserializamos
$autor = unserialize($_POST['autor']);


//Comprobacion que existe el id del autor

if(!Autores::existeAutor($autor->id_autor)){
    header("Location:index.php");
    die();
}


Autores::delete($autor->id_autor);
$_SESSION['mensaje']="*** EL AUTOR HA SIDO BORRADA";
header("Location:index.php");