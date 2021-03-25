<?php


class ClientesModel{
    private $db;

    function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;" . "dbname=bancoVVBA;charset=utf8" , "root" , "");
    }

    function addCliente($nombre,$dni,$telefono,$direccion,$premium){
        $query = $this->db->prepare('INSERT INTO clientes(nombre,dni,telefono,direccion,premium) VALUES (?,?,?,?)');
        $query->execute([$nombre,$dni,$telefono,$direccion,$premium]);
    }

    function getClienteByDNI($dni){
        $query = $this->db->prepare("SELECT * FROM clientes WHERE dni = ?");
        $query->execute([$dni]);
        $cliente = $query->fetch(PDO::FETCH_OBJ);
        return $cliente;
    }

    function getClienteByID($id){
        $query = $this->db->prepare("SELECT * FROM clientes WHERE id = ?");
        $query->execute([$id]);
        $cliente = $query->fetch(PDO::FETCH_OBJ);
        return $cliente;
    }
}