<?php

    require_once("./app/Model/ClientesModel.php");
    require_once("./app/Model/OperacionModel.php");
    require_once("./app/Model/CuentasModel.php");
    require_once("./app/Controller/CuentasController.php");
    require_once("./app/View/CuentasView.php");
    require_once("./app/helper/UserHelper.php");

class CuentasController{

    private $view,$clientesModel,$cuentasModel,$operacionModel,$helper,$cuentasController;

    function __construct()
    {
        $this->cuentasModel = new CuentasModel();
        $this->cuentasController = new CuentasController();
        $this->clientesModel = new ClientesModel();
        $this->operacionModel = new OperacionModel();
        $this->helper = new UserHelper();
        $this->view = new CuentasView();
    }

    function transferenciaRapida($params = null){
        $this->helper->isLogged();
        $cuenta_id = $params[':ID'];
        $monto = $_POST['monto'];
        $dni_destinatario = $_POST['dni_destinatario'];
        $tipo_operación = $_POST['tipo_operación'];
        $fecha_alta = date("Y/m/d");

        $operaciones = $this->operacionesModel->getOperacionesByCuentaID($cuenta_id);
        $saldo = 0;
        $saldo += $this->cuentasController->getSaldo($operaciones);
        
        if($saldo >= $monto){
            $destinatario = $this->clientesModel->getClienteByDNI($dni_destinatario);
            
            if($destinatario){
                $this->operacionModel->addOperacion($monto,$fecha_alta,$tipo_operación,$destinatario->id);
            }else{
                $this->view->showHome("No existe cliente con ese DNI.");
            }
        }else{
            $this->view->showHome("No tiene fondos suficientes.");
        }
    }
}
