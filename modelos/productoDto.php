<?php
class Producto {
	public $id;
	public $nombre;
	public $descripcion;
	public $descripcionlarga;
	public $precio;
	public $categoria_id;
	public $ccategoria;
	public $stock;
	public $estado;
	public $valido;

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
