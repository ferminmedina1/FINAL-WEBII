<?php


class OperacionModel{
    private $db;
    
    function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;" . "dbname=bancoVVBA;charset=utf8" , "root" , "");
    }

    function addOperacion($fecha_alta,$nro_cuenta,$id_cliente,$tipoCuenta){
        $query = $this->db->prepare('INSERT INTO operaciones(fecha_alta,nro_cuenta,id_cliente,tipoCuenta) VALUES (?,?,?,?)');
        $query->execute([$fecha_alta,$nro_cuenta,$id_cliente,$tipoCuenta]);
    }
    
    function getOperacionesByCuentaID($id){
        $query = $this->db->prepare('SELECT * FROM operaciones WHERE id_cuenta = ?');
        $query->execute([$id]);
        $cuentas = $query->fetchAll(PDO::FETCH_OBJ);
        return $cuentas;
    }

    function fondosSuficientes($id){
        $query = $this->db->prepare('SELECT * FROM operaciones WHERE id_cuenta = ?');
        $query->execute([$id]);
        $cuentas = $query->fetchAll(PDO::FETCH_OBJ);
        return $cuentas;
    }
}