<?php
require_once("include/form.php");
require_once("include/pd.php");
class formularioActualizacionPd extends Form{
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }
    
    protected function generaCamposFormulario($datosIniciales){
    	$html = '<div class="form">';
        $html .= '<p>¿El nombre del director es diferente?</p>';
        $html .= '<input type="text" name="name" placeholder="Nombre">';
        $html .= '<p>¿Cual es la fecha de nacimiento?</p>';
        $html .= '<input type="date" name="birthDate" placeholder="Fecha de nacimiento">';
        $html .= '<button type="submit" name="pd-update">Actualizar</button>';
        $html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $name = isset($datos['name']) ? $datos['name'] : null;
        if ( empty($name) ) {
            $erroresFormulario[] = "<p class='red-error'>El nombre del director no puede estar vacío</p>";
        }
        $birthDate = isset($datos['birthDate']) ? $datos['birthDate'] : null;
        if ( empty($birthDate) ) {
            $erroresFormulario[] = "<p class='red-error'>La fecha de nacimiento del director no puede estar vacía</p>";
        }
        if (count($erroresFormulario) === 0) {
            $pd = Pd::searchPD($name);
            if(!$pd) {
                $erroresFormulario[] = "<p class='red-error'>No existe este director</p>";
            }
            else{
                $pdUpdate = Pd::update($pd, $name, $birthDate);
                if (!$pdUpdate) {
                    $erroresFormulario[] = "<p class='red-error'>No se ha podido actualizar</p>";
                }
                return "main_page.php?updated=".$datos['name'];
            }
        }
        return $erroresFormulario;
    }
}