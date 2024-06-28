<?php
require_once('LibreriaPDO.php');

class ClienteDAO extends DB{
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    public function obtenerTodos() {
        $this->datos=array();

        $consulta = "SELECT * FROM clientes";
        $this->Consulta($consulta, []);

        return $this->datos;
    }

    public function cerrarConexion() {
        $this->Cerrar();
    }
}


class CocheDAO extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    public function obtenerTodos() {
        $this->datos=array();

        $consulta = "SELECT * FROM coches";
        $this->Consulta($consulta, []);

        return $this->datos;
    }

    public function obtenerPrecio($id_coche) {
        $this->datos=array();
        $consulta = "SELECT * FROM coches WHERE Id = ?";
        $param=array($id_coche);
        $this->Consulta($consulta, $param);

        return $this->datos[0]['Precio'];
    }

    public function cerrarConexion() {
        $this->Cerrar();
    }
}

class PedidoDAO extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    public function insertarPedido($id_coche, $id_cliente) {
        $consulta = "INSERT INTO pedido (IdCoche, IdCliente) VALUES (?, ?)";
        $this->ConsultaSimple($consulta, [$id_coche, $id_cliente]);
    }

    public function obtenerPrecioTotal($precio, $extras) {
        $this->datos = array();

        $precio_extras = 0;
        if (!empty($extras)) {
            $consulta = "SELECT SUM(Precio) AS total_extras FROM extra WHERE Id IN ('" . implode("','", $extras) . "')";
            $this->Consulta($consulta, []);
            $precio_extras = $this->datos[0]['total_extras'];
        }

        return $precio + $precio_extras;
    }

    public function cerrarConexion() {
        $this->Cerrar();
    }
}
class ExtraDAO extends DB{
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    public function obtenerTodos() {
        $this->datos=array();

        $consulta = "SELECT * FROM extra";
        $this->Consulta($consulta, []);

        return $this->datos;
    }

    public function cerrarConexion() {
        $this->Cerrar();
    }
}
?>
