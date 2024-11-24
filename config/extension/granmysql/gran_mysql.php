<?php
/*
    Nombre: Gran MySQL
    Tipo: Plugin
    Función: Este plugin es el sucesor del Jossito "consulta_mysqli", aquí tratamos de mejorar la sintaxis donde no obligamos a llenar cada celda y aprovechamos lo mejor de la POO.
    Creador: Melchor Estrada José Luis (JOSPROX MX | Internacional).
    Web: https://josprox.com
*/

class GranMySQL {
    public string $seleccion = "*";
    public string $tabla = "table_users";
    public mixed $tabla_innerjoin;
    public string $comparar = "id";
    public mixed $comparable;
    public string $personalizacion = "";
    public string $respuesta = "fetch_assoc";

    private ?mysqli $conexion;
    private mixed $prefijo;

    /**
     * Constructor modificado para aceptar un arreglo de configuración.
     * @param array $config
     */
    public function __construct(array $config = []) {
        $this->conexion = conect_mysqli();
        $this->prefijo = env("PREFIJO", "");

        // Si se pasa un arreglo de configuración, inicializar las propiedades.
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function clasic(string $formato = "array") {
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->prefijo}{$this->tabla} {$this->personalizacion};";
            $query = $this->conexion->query($sql);

            if ($query === false) {
                throw new Exception("Error en la consulta: {$this->conexion->error}");
            }

            return $this->procesarResultado($query, $formato);
        } catch (Exception $e) {
            $this->manejarExcepcion($e);
        }
    }

    public function where(string $formato = "array") {
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->prefijo}{$this->tabla} {$this->personalizacion} WHERE {$this->comparar} = ?;";
            $stmt = $this->conexion->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Error preparando la consulta: {$this->conexion->error}");
            }

            $stmt->bind_param("s", $this->comparable);
            $stmt->execute();
            $result = $stmt->get_result();

            $resultado = $this->procesarResultado($result, $formato);
            $stmt->close();
            return $resultado;
        } catch (Exception $e) {
            $this->manejarExcepcion($e);
        }
    }

    public function innerJoin(string $formato = "array") {
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->prefijo}{$this->tabla} 
                    INNER JOIN {$this->prefijo}{$this->tabla_innerjoin} 
                    ON {$this->prefijo}{$this->tabla}.{$this->comparar} = {$this->prefijo}{$this->tabla_innerjoin}.{$this->comparable} 
                    {$this->personalizacion};";

            $query = $this->conexion->query($sql);

            if ($query === false) {
                throw new Exception("Error en la consulta: {$this->conexion->error}");
            }

            return $this->procesarResultado($query, $formato);
        } catch (Exception $e) {
            $this->manejarExcepcion($e);
        }
    }

    private function procesarResultado($query, string $formato) {
        if ($formato === "json") {
            $json = [];
            while ($row = $query->fetch_assoc()) {
                $json[] = $row;
            }
            return json_encode($json, JSON_UNESCAPED_UNICODE);
        }

        if ($this->respuesta === "num_rows") {
            return $query->num_rows;
        } else {
            return $query->{$this->respuesta}();
        }
    }

    private function manejarExcepcion($e) {
        error_log("Error en GranMySQL: " . $e->getMessage());
        throw $e;
    }

    public function __destruct() {
        $this->resetearPropiedades();
        $this->conexion->close();
    }

    private function resetearPropiedades() {
        $this->seleccion = "*";
        $this->tabla = "table_users";
        $this->tabla_innerjoin = null;
        $this->comparar = "id";
        $this->comparable = null;
        $this->personalizacion = "";
        $this->respuesta = "fetch_assoc";
    }
}
?>
