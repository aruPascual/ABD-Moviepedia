<?php
require_once("form.php");
require_once("actor.php");
class formularioBorradoActor extends Form {
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    protected function generaCamposFormulario($datosIniciales) {
    	$html = '<div class="form">';
    	$html .= '<p>¿Deseas eliminar a este actor o actriz?</p>';
        $html .= '<input type="text" name="name" placeholder="Nombre">';
    	$html .= '<button type="submit" name="actor-delete">Eliminar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $name = isset($datos['name']) ? $datos['name'] : null;
        if (empty($name) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el nombre del actor o actriz? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            $actor = Actor::deleteActor($name);
            if (!$actor) {
                $erroresFormulario[] = "<p class='red-error'>No se ha podido eliminar este actor o actriz.</p>";
            }
            else{
                return "main_page.php?deleted=".$name;
            }
        }
        return $erroresFormulario;
    }
}