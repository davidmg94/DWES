<?php
require_once 'LibreriaPDO.php';
require_once 'cliente.php';
class DaoCliente extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    function actualizar($cliente) {
        $sql = "UPDATE clientes SET Nombre=?, Apellido1=?, Apellido2=?, Edad=? WHERE NIF=?";

        $params = array(
            $cliente->nombre,
            $cliente->apellido1,
            $cliente->apellido2,
            $cliente->edad,
            $cliente->nif
        );

        $this->ConsultaSimple($sql, $params);
    }

    function obtener($nif) {
        $nif = trim($nif);

        $sql = "SELECT * FROM clientes WHERE NIF=?";

        $this->datos = array();

        $params = array($nif);

        $this->Consulta($sql, $params);

        $clientes = $this->datos;

        if (!empty($clientes)) {
            $cliente = new Cliente(
                $clientes[0]['NIF'],
                $clientes[0]['Nombre'],
                $clientes[0]['Apellido1'],
                $clientes[0]['Apellido2'],
                $clientes[0]['Edad']);
            return $cliente;
        }
        return null;
    }

    function listar() {
        $sql = "SELECT * FROM clientes";

        $this->datos = array();

        $this->Consulta($sql, array());

        $datosClientes = array();

        $clientes = $this->datos;

        foreach ($clientes as $cliente) {
            $objCliente = new Cliente(
                $cliente['NIF'],
                $cliente['Nombre'],
                $cliente['Apellido1'],
                $cliente['Apellido2'],
                $cliente['Edad']
            );
            array_push($datosClientes, $objCliente);
        }

        return $datosClientes;
    }
}

?>