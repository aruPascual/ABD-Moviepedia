<?php
require_once("include/form.php");
require_once("include/usuario.php");
class formularioBusquedaPd extends Form{
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
    	$html .= '<p>¿Cual es el nombre del director?</p>';
    	$html .= '<input type="text" name="data" placeholder="Nombre">';
    	$html .= '<button type="submit" name="pd-search">Buscar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $dataToSearch = isset($datos['data']) ? $datos['data'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el nombre del director? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $pd = Pd::searchPd($datos['data']);
			
            if (!$pd) {
                $erroresFormulario[] = "<p class='red-error'>El director no existe.</p>";
            }
            else{
                 return "buscaPd.php?pdName=".$pd->name();
            }
        }
        return $erroresFormulario;
    }
}