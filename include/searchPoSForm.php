<?php
require_once("include/form.php");
require_once("include/usuario.php");
class formularioBusquedaPoS extends Form{
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
    	$html .= '<p>¿Cual es el título?</p>';
    	$html .= '<input type="text" name="title" placeholder="Título">';
    	$html .= '<button type="submit" name="pors-search">Buscar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $dataToSearch = isset($datos['title']) ? $datos['title'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el título? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $movie = Filmserie::searchFilmSerie($datos['title']);
			
            if (!$movie) {
                $erroresFormulario[] = "<p class='red-error'>La película o serie no existe.</p>";
            }
            else{
                 return "buscaPoS.php?title=".$datos['title'];
            }
        }
        return $erroresFormulario;
    }
}