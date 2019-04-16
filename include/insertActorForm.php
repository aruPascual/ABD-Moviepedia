<?php
require_once("form.php");
require_once("actor.php");
class formularioInsercionActor extends Form{
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }
    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales){
    	$html = '<div class="form">';
    	$html .= '<p>¿Cuál es su nombre?</p>';
    	$html .= '<input type="text" name="name" placeholder="Nombre">';
        $html .= '<p>¿Cuál es la fecha de nacimiento?</p>';
        $html .= '<input type="date" name="birthDate" placeholder="Fecha de nacimiento">';
    	$html .= '<button type="submit" name="actor-insert">Insertar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $name = isset($datos['name']) ? $datos['name'] : null;
        if ( empty($name) ) {
            $erroresFormulario[] = "<p class='red-error'>El nombre del actor o actriz no puede estar vacío</p>";
        }
        $birthDate = isset($datos['birthDate']) ? $datos['birthDate'] : null;
        if ( empty($birthDate) ) {
            $erroresFormulario[] = "<p class='red-error'>La fecha de nacimiento del actor o aztriz no puede estar vacía</p>";
        }
        if (count($erroresFormulario) === 0) {
            $actor = Actor::create($name, $birthDate);
			if(!$actor) {
                $erroresFormulario[] = "<p class='red-error'>Ya existe este actor o actriz</p>";
            }
            else{
                return "main_page.php?inserted=".$name;
            }
        }
        return $erroresFormulario;
    }
}