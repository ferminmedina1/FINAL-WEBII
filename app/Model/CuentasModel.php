<?php


class CuentasModel{
    private $db;

    function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;" . "dbname=bancoVVBA;charset=utf8" , "root" , "");
    }

    function addCuenta($fecha_alta,$nro_cuenta,$id_cliente,$tipoCuenta){
        $query = $this->db->prepare('INSERT INTO cuentas(fecha_alta,nro_cuenta,id_cliente,tipoCuenta) VALUES (?,?,?,?)');
        $query->execute([$fecha_alta,$nro_cuenta,$id_cliente,$tipoCuenta]);
    }

    function getCuentasByClienteID($id){
        $query = $this->db->prepare('SELECT * FROM cuentas WHERE id_cliente = ?');
        $query->execute([$id]);
        $cuentas = $query->fetchAll(PDO::FETCH_OBJ);
        return $cuentas;
    }

    
}