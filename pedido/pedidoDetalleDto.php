<?php
class PedidoDetalle {
	public $id;
	public $producto_id;
	public $cproducto;
	public $cantidad;
	public $precio;
	public $importe;
	public $estado;
	public $fecha_registro;

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
