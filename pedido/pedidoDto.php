<?php
class Pedido {
	public $id;
	public $usuario_id;
	public $local_id;
	public $tipopago_id;
	public $fecha_registro;
	public $monto_total;
	public $estado;

	public function __construct($properties=[]){
        if (!empty($properties)) {
            array_walk($properties, function ($val, $key) {
                $this->fromArray($key, $val);
            });
        }
    }

    public function fromArray($property, $value){
        return (property_exists($this, $property)) ? $this->$property = $value : null;
    }
	public function toArray()
  {
      return get_object_vars($this);
  }
}
?>
