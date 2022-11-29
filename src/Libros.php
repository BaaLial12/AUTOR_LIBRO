<?php
namespace Src;

use \PDO;
use \PDOException;

class Libros extends Conexion{


    //Atributos
    private int $id_libro;
    private string $titulo;
    private string $isbn;
    private int $autor;
    private ?string $portada;


    public function __construct()
    {
        parent::crearConexion();
    }


    //---------------METODO CRUD------------

    //Funcion la cual me creara un autor
    public function create(){

        $q = "Insert into libros (titulo , isbn , autor , portada) values(:t , :i , :a , :p)";

        $stmt = parent::$cnx->prepare($q);

        try{

            $stmt->execute([
                ':t'=> $this->titulo,
                ':i' => $this->isbn,
                ':a' => $this->autor,
                ':p' => $this->portada
            ]);

        }catch(PDOException $ex){
            die("Error en crear Libro".$ex->getMessage());
        }
        parent::$cnx=null;

    }

    public  function read(){

        $q="select * from libros where id_libro=:i";


        $stmt=parent::$cnx->prepare($q);

        try{

            $stmt->execute([
                ':i' =>$this->id_libro
            ]);

        }catch(PDOException $ex){
            die("Error en read Libro".$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }


    //Funcion la cual me devolvera toda la informacion de los libros
    public static function readAll(){

        parent::crearConexion();


        $q= "select *, nombre from libros, autores where autor=autores.id_autor order by libros.id_libro";

        $stmt = parent::$cnx->prepare($q);

        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("Error en readAll libros".$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    public function update($id){

        $q="update libros set titulo=:t, isbn=:i, autor=:a, portada=:p where id_libro=:id";


        $stmt=parent::$cnx->prepare($q);


        try{
            $stmt->execute([
                ':t'=>$this->titulo,
                ':i'=>$this->isbn,
                ':a'=>$this->autor,
                ':p'=>$this->portada,
                ':id'=>$id
            ]);



        }catch(PDOException $ex){
            die("Error en update libros" .$ex->getMessage());
        }


        parent::$cnx=null;




    }

    public static function delete(int $id_libro){


        parent::crearConexion();
        $q = "Delete from libros where id_libro=:i";


        $stmt = parent::$cnx->prepare($q);

        try {


            $stmt->execute([
                ":i" => $id_libro
            ]);


        } catch (PDOException $ex) {
            die("Error en delete Libros" .$ex->getMessage());
        }

        parent::$cnx=null;


    }



    //-------------OTROS METODOS------------

    private  function HayLibro(){
        $q = "Select id_libro from libros";

        $stmt = parent::$cnx->prepare($q);

        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("Error en HayLibro libros" .$ex->getMessage());
        }

        parent::$cnx=null;

        return $stmt->rowCount();

    }



    public function crearLibro(int $cantidad){
        
        //Primeros comprobamos que no haya Libros
        if(self::HayLibro()) return;


        $faker = \Faker\Factory::create('es_ES');

        //De autores autor ID me traigo en un array todos los id de autor que existe
        $autor = Autores::AutorID();
        for($x=0; $x<$cantidad; $x++){
            (new Libros)->setTitulo($faker->words(3,true))
            ->setIsbn($faker->isbn13())
            //Para poder crear todos los autores accedo al array que hemos guardado en autor y hago un random element
            ->setAutor($faker->randomElement($autor))
            ->setPortada('/../public/img/default.jpg')
            ->create();
        }


    }


    //Funcion la cual me comprobara si un id_libro existe en mi bd 
    public static function ExisteLibroId(int $id_libro){
        parent::crearConexion();

        $q = "Select id_libro from libros where id_libro=:i";

        $stmt = parent::$cnx->prepare($q);



        try{


            $stmt->execute([
                ':i'=> $id_libro
            ]);


        }catch(PDOException $ex){
            die("Error en existeLibroID ".$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->rowCount();




    }


    //Funcion para comprobar que existe un isbn (se usara en crear)
    public static function ExisteISBN(int $isbn , ?int $id=null){
        parent::crearConexion();


        $q =($id==null) ? "select id_libro from libros where isbn=:i" :
        "select id_libro from libros where isbn=:i and $id!=:id";



        $opciones=($id==null) ? [':i'=>$isbn] : [':i'=>$isbn, ':id'=>$id] ;

        $stmt=parent::$cnx->prepare($q);


        try{

            $stmt->execute($opciones);

        }catch(PDOException $ex){
            die("Error en EXISTE ISBN Libro".$ex->getMessage());
        }

        parent::$cnx=null;
        return $stmt->rowCount();


    }









    //GET Y SET
    







    /**
     * Set the value of id_libro
     *
     * @return  self
     */ 
    public function setId_libro($id_libro)
    {
        $this->id_libro = $id_libro;

        return $this;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */ 
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Set the value of autor
     *
     * @return  self
     */ 
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Set the value of portada
     *
     * @return  self
     */ 
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }
}