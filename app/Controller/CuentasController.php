<?php

    require_once("./app/Model/ClientesModel.php");
    require_once("./app/Model/OperacionModel.php");
    require_once("./app/Model/CuentasModel.php");
    require_once("./app/View/CuentasView.php");
    require_once("./app/helper/UserHelper.php");

class CuentasController{

    private $view,$clientesModel,$cuentasModel,$operacionModel,$helper;

    function __construct()
    {
        $this->cuentasModel = new CuentasModel();
        $this->clientesModel = new ClientesModel();
        $this->operacionModel = new OperacionModel();
        $this->helper = new UserHelper();
        $this->view = new CuentasView();
    }


    function generarTabla($params = null){
        $id_cliente = $params['ID'];

        $cliente = $this->clientesModel->getClienteByID($id_cliente);
        $cuentas = $this->cuentasModel->getCuentasByClienteID($id_cliente);

        if(!$cliente && !$cuentas && !empty($cuentas)){
            $operaciones = [];
            $saldo = 0;
            foreach($cuentas as $cuenta){
                $operaciones = $this->operacionesModel->getOperacionesByCuentaID($cuenta->id);
                $saldo += $this->getSaldo($operaciones);
            }

            $this->view->showTabla($cliente,$cuentas,$operaciones,$saldo); 
            //lo que queda de logica lo usaria con Smarty
            //simplemente recorro las cuentas y si la id_cuenta de la operacion coincide con el id de la cuenta
            //recorro esa operacion imprimiendo lo que haga falta
        
        }else{
            $this->view->showCuentas("El cliente no existe o no tiene cuentas asociadas!");
        }
    }


    function getSaldo($operaciones){
        $saldo = 0;
        foreach($operaciones as $operacion){
            $saldo += $operacion->monto;
        }
        return $saldo;
    }

}