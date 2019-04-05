<?php
require_once("include/form.php");
require_once("include/filmserie.php");
class formularioBorradoPoS extends Form {
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    protected function generaCamposFormulario($datosIniciales) {
    	$html = '<div class="form">';
    	$html .= '<p>¿Deseas eliminar esta película o serie?</p>';
        $html .= '<input type="text" name="title" placeholder="Título">';
    	$html .= '<button type="submit" name="pors-delete">Eliminar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos) {
    	$erroresFormulario = array();
        $dataToSearch = isset($datos['title']) ? $datos['title'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Cuál es el título? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            $movie = Filmserie::deleteFilmserie($datos['title']);
            if (!$movie) {
                $erroresFormulario[] = "<p class='red-error'>No se ha podido eliminar esta película o serie.</p>";
            }
            else{
                return "main_page.php?deleted=".$datos['title'];
            }
        }
    	return $erroresFormulario;
    }
}