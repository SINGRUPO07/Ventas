<?php
class CarritoDetalle {
	public $id;
	public $producto_id;
	public $cantidad;
	public $estado;
	public $fecha_registro;
	public $cproducto;
	public $cdescripcion;
	public $precio;

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
