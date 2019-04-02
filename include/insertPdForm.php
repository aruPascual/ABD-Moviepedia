<?php
require_once("include/form.php");
require_once("include/pd.php");
class formularioInsercionPd extends Form{
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
    	$html .= '<p>¿Cual es su nombre?</p>';
    	$html .= '<input type="text" name="name" placeholder="Nombre">';
        $html .= '<p>¿Cual es la fecha de nacimiento?</p>';
        $html .= '<input type="date" name="birthDate" placeholder="Fecha de nacimiento">';
    	$html .= '<button type="submit" name="pd-insert">Insertar</button>';
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
            $pd = Pd::create($name, $birthDate);
			if(!$pd) {
                $erroresFormulario[] = "<p class='red-error'>Ya existe este director</p>";
            }
            else{
                return "main_page.php";
            }
        }
        return $erroresFormulario;
    }
}