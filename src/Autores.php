<?php
namespace Src;
use PDO;
use PDOException;

class Autores extends Conexion{

    private int $id_autor;
    private string $apellidos;
    private string $nombre;


    public function __construct()
    {
        parent::crearConexion();
    }



    //----------METODO CRUD--------

    //Funcion la cual me creara un autor
    public function create(){

    $q = "insert into autores (nombre , apellidos) values (:n , :a)";

    $stmt = parent::$cnx->prepare($q);

    try{
        $stmt->execute([
            ':n' => $this->nombre,
            ':a' => $this->apellidos
        ]);

    }catch(PDOException $ex){
        die("Error en crear autor : ".$ex->getMessage());
    }

    parent::$cnx=null;



    }




    //Funcion la cual nos ayudara en update.php que nos ayudara a actualizar el Autor
    public function read(){


        $q = "select * from autores where id_autor=:i";

        $stmt = parent::$cnx->prepare($q);

        try {


            $stmt->execute([
                ":i" => $this->id_autor
            ]);


        } catch (PDOException $ex) {
            die("Error en read Autor " .$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->fetch(PDO::FETCH_OBJ); //como solo me va a devolver 1 unica fila lo pondremos con el fetch obj


    }




    //Funcion la cual me devolvera toda la informacion de autores
    public static function readALL(?int $modo=null){
        parent::crearConexion();


        $q = ($modo==null) ? "Select * from autores " : "Select id_autor , nombre from autores";

        $stmt = parent::$cnx->prepare($q);

        try{

            $stmt->execute();

        } catch(PDOException $ex){
            die("Error en read autor :" .$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);




    }






    //Funcion la cual le paso un id de autor y me lo actualizara
    public function update(int $id_autor){

        $q = "update autores set nombre=:n , apellidos=:a where id_autor=:i";


        $stmt = parent::$cnx->prepare($q);

        try {


            $stmt->execute([
                ":n" => $this-> nombre,
                ":a" => $this-> apellidos,
                ':i' => $id_autor
            ]);


        } catch (PDOException $ex) {
            die("Error en update Autores" .$ex->getMessage());
        }

        parent::$cnx=null;






    }

    //Funcion la cual le paso un id de autor y lo borrara
    public static function delete(int $id_autor){


        parent::crearConexion();
        $q = "Delete from autores where id_autor=:i";


        $stmt = parent::$cnx->prepare($q);

        try {


            $stmt->execute([
                ":i" => $id_autor
            ]);


        } catch (PDOException $ex) {
            die("Error en delete Autores" .$ex->getMessage());
        }

        parent::$cnx=null;




    }




    //------- OTROS METODOS--------------------


    public function crearAutor($cantidad){

        //Si hay autores nos saldremos
        if($this->HayAutor()) return;

        $faker = \Faker\Factory::create('es_ES');
        for($x=0; $x<$cantidad ; $x++){
            (new Autores) ->setNombre($faker->firstName())
            ->setApellidos($faker->lastName()." ".$faker->lastName())
            ->create();
        }



    }
    

    //Funcion la cual me comprobara si hay un autor , me ayudara para generarlos automarticamenre
    private function HayAutor(){
        $q = "Select id_autor from autores";

        $stmt = parent::$cnx->prepare($q);


        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("Error en hay autor : ".$ex->getMessage());
        }

        parent::$cnx=null;

        return $stmt->rowCount(); //En el caso que me devuelva 1 significara que hay autores , sino estara vacio 





    }


    //Funcion la cual comprobaremos que al pasar id , existe 
    public static function existeAutor($id):bool{
        parent::crearConexion();

        $q="Select id_autor from autores where id_autor=:i";

        $stmt = parent::$cnx->prepare($q);


        try{

            $stmt->execute([
                ":i" => $id
            ]);

        }catch(PDOException $ex){
            die("Error en Existe Autor:" .$ex->getMessage());
        }


        parent::$cnx=null;
        return $stmt->rowCount();

    }


    public static function AutorID():array{
        parent::crearConexion();

        $q = "Select id_autor from autores";

        $stmt= parent::$cnx->prepare($q);

        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("Error en AutorID ".$ex->getMessage());

        }

        parent::$cnx=null;

        return $stmt->fetchAll(PDO::FETCH_COLUMN,0);




    }



    public static function Autores():array{
        parent::crearConexion();

        $q = "Select nombre from autores";

        $stmt= parent::$cnx->prepare($q);

        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("Error en Autores ".$ex->getMessage());

        }

        parent::$cnx=null;

        return $stmt->fetchAll(PDO::FETCH_COLUMN,0);
    }


    //---------------- SET y GET------------------



    /**
     * Set the value of id_autor
     *
     * @return  self
     */ 
    public function setId_autor($id_autor)
    {
        $this->id_autor = $id_autor;

        return $this;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}