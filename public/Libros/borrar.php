<?php
session_start();
require __DIR__."/../../vendor/autoload.php";
use Src\Libros;

if(!isset($_POST['libro'])){
    header("Location:index.php");
    die();
}


//Lo deserializamos 

$libro = unserialize($_POST['libro']);


//Comprobacion que existe el id de autor y no nos quieren estafar

if(!Libros::ExisteLibroId($libro->id_libro)){
    header("Location:index.php");
    die();
}


//Comprobacion para evitar borrar nuestra imagen default

//Si la imagen es distinta de default , borramos la imagen
if(basename($libro->portada)!='default.jpg'){ // /img/marcas/default.png
    unlink("..".$libro->portada); //Salimos a public y nos metemos a img/marcas/default.png con la serializable de marca->logo 
}


//Si llegamos aqui significa que el id existe y que el id que nos han pasado esta en la bd


Libros::delete($libro->id_libro);
$_SESSION['mensaje']="*** EL LIBRO SE HA BORRADO";
header("Location:index.php");