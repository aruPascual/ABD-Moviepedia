<?php
require_once("form.php");
require_once("pd.php");
class formularioBorradoPd extends Form {
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    protected function generaCamposFormulario($datosIniciales) {
    	$html = '<div class="form">';
    	$html .= '<p>¿Deseas eliminar a este director?</p>';
        $html .= '<input type="text" name="name" placeholder="Nombre">';
    	$html .= '<button type="submit" name="pd-delete">Eliminar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos) {
        $erroresFormulario = array();
        $name = isset($datos['name']) ? $datos['name'] : null;
        if ( empty($name) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el nombre del director? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            $pd = Pd::deletePd($name);
            if (!$pd) {
                $erroresFormulario[] = "<p class='red-error'>No se ha podido eliminar este director.</p>";
            }
            else{
                return "main_page.php?deleted=".$name;
            }
        }
        return $erroresFormulario;
    }
}