<?php
class Usuario {
	public $id;
	public $nombre;
	public $apellido;
	public $correo;
	public $telefono;
	public $usuario;
	public $tipo;
	public $ctipo;
	public $estado;
	public $cestado;
	public $local_id;
	public $clocal;

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
