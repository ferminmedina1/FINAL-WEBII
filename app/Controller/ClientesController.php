<?php

    require_once("./app/Model/ClientesModel.php");
    require_once("./app/Model/OperacionModel.php");
    require_once("./app/Model/CuentasModel.php");
    require_once("./app/View/ClientesView.php");
    require_once("./app/helper/UserHelper.php");

class ClientesController{

    private $view,$clientesModel,$cuentasModel,$operacionModel,$helper;

    function __construct()
    {
        $this->cuentasModel = new CuentasModel();
        $this->clientesModel = new ClientesModel();
        $this->operacionModel = new OperacionModel();
        $this->helper = new UserHelper();
        $this->view = new ClientesView();
    }

    function addCliente(){
        $this->helper->isAdmin();
        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $direccion  = $_POST['direccion'];
        $premium  = $_POST['premium'];

        if(isset($nombre) && isset($dni) && isset($telefono) && isset($direccion) && isset($premium)){
            $cliente = $this->clientesModel->getClienteByDNI($dni);

            if(!$cliente){ //si no existe cliente se crea la cuenta

                $this->clientesModel->addCliente($nombre,$dni,$telefono,$direccion,$premium);
                
                $fecha_alta = date("Y/m/d");
                $tipoCuenta  = $_POST['cuenta'];
                $numeroCuenta = 2;
                $this->cuentasModel->addCuenta($fecha_alta,$numeroCuenta,$cliente->id,$tipoCuenta);
                  
                if($premium){
                    $cuenta = $this->cuentasModel->getCuentasByClienteID($cliente->id);
                    $this->operacionModel->addOperacion(10000,$fecha_alta,2,$cuenta[0]->id);
                }

                $this->view->showHome("Cuenta creada con exito!");
            }else{
                $this->view->showLog("El DNI ya esta registrado!");
            }
        }else{
            header("Location: " .LOGIN);
            die();
        }
    }
}