<?php
require_once("form.php");
require_once("actor.php");
class formularioActualizacionActor extends Form{
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }
    
    protected function generaCamposFormulario($datosIniciales){
    	$html = '<div class="form">';
        $html .= '<p>¿El nombre del actor o la actriz es diferente?</p>';
        $html .= '<input type="text" name="name" placeholder="Nombre">';
        $html .= '<p>¿Cuál es la fecha de nacimiento?</p>';
        $html .= '<input type="date" name="birthDate" placeholder="Fecha de nacimiento">';
        $html .= '<button type="submit" name="actor-update">Actualizar</button>';
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
            $erroresFormulario[] = "<p class='red-error'>La fecha de nacimiento del actor o actriz no puede estar vacía</p>";
        }
        if (count($erroresFormulario) === 0) {
            $actor = Actor::searchActor($name);
            if(!$actor) {
                $erroresFormulario[] = "<p class='red-error'>No existe este actor o actriz</p>";
            }
            else{
                $actorUpdate = Actor::update($actor, $name, $birthDate);
                if (!$actorUpdate) {
                    $erroresFormulario[] = "<p class='red-error'>No se ha podido actualizar</p>";
                }
                return "main_page.php?updated=".$name;
            }
        }
        return $erroresFormulario;
    }
}