<?php
require_once("include/form.php");
require_once("include/pd.php");
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
        $dataToSearch = isset($datos['name']) ? $datos['name'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el nombre del director? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            $pd = Pd::deletePd($datos['name']);
            if (!$pd) {
                $erroresFormulario[] = "<p class='red-error'>No se ha podido eliminar este director.</p>";
            }
            else{
                return "main_page.php?deleted=".$datos['name'];
            }
        }
        return $erroresFormulario;
    }
}