<?php
require_once("form.php");
require_once("usuario.php");
class formularioBusquedaActor extends Form{
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
    	$html .= '<p>¿Cual es el nombre del actor o actriz?</p>';
    	$html .= '<input type="text" name="actorName" placeholder="Nombre">';
    	$html .= '<button type="submit" name="actor-search">Buscar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $dataToSearch = isset($datos['actorName']) ? $datos['actorName'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el nombre del ator o actriz que estás buscando? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $actor = Actor::searchActor($dataToSearch);
			
            if (!$actor) {
                $erroresFormulario[] = "<p class='red-error'>El actor o actriz que buscas no existe.</p>";
            }
            else{
                 return "buscaActor.php?actorName=".$dataToSearch;
            }
        }
        return $erroresFormulario;
    }
}