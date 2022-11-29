<?php
namespace Src;

use PDO;
use PDOException;

class Conexion{

    protected static $cnx;

    public function __construct()
    {
        self::crearConexion();
    }



    public static function crearConexion(){
        if(self::$cnx!=null) return;


        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../");
        $dotenv->load();


        $usuario = $_ENV['USER'] ;
        $pass = $_ENV['PASS'] ;
        $db = $_ENV['DB'] ;
        $host = $_ENV['HOST'];


        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        $op = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];


        try{

            self::$cnx = new PDO($dsn , $usuario , $pass , $op);


        } catch(PDOException $ex){
            die("Error en la conexion: " .$ex->getMessage());

        }


    }




}