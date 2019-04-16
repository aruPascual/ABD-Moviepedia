<?php
require_once("form.php");
require_once("filmserie.php");
class formularioInsercionPoS extends Form{
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }
    
    protected function generaCamposFormulario($datosIniciales){
    	$html = '<div class="form">';
    	$html .= '<p>¿Cuál es el título?</p>';
    	$html .= '<input type="text" name="title" placeholder="Título">';
        $html .= '<p>¿Cuál es la fecha de estreno?</p>';
        $html .= '<input type="date" name="releaseDate" placeholder="Fecha de estreno">';       
        $html .= '<p>¿Cuál es el género?</p>';
        $html .= '<input type="text" name="genre" placeholder="Género">';
        $html .= '<p>¿Cuál es la duración?</p>';
        $html .= '<input type="number" name="runtime" placeholder="Duración">';
        $html .= '<p>¿Cuántos episodios tiene?</p>';
        $html .= '<input type="number" name="episodes" placeholder="Episodios">';
        $html .= '<p>¿Cuál es el director?</p>';
        $html .= '<input type="text" name="directedBy" placeholder="Director">';
    	$html .= '<button type="submit" name="pors-insert">Insertar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $title = isset($datos['title']) ? $datos['title'] : null;
        if ( empty($title) ) {
            $erroresFormulario[] = "<p class='red-error'>El título de la película o serie no puede estar vacío</p>";
        }
        $releaseDate = isset($datos['releaseDate']) ? $datos['releaseDate'] : null;
        if ( empty($releaseDate) ) {
            $erroresFormulario[] = "<p class='red-error'>La fecha de estreno de la película o serie no puede estar vacía</p>";
        }
        $genre = isset($datos['genre']) ? $datos['genre'] : null;
        if ( empty($genre) ) {
            $erroresFormulario[] = "<p class='red-error'>El género de la película o serie no puede estar vacío</p>";
        }
        $runtime = isset($datos['runtime']) ? $datos['runtime'] : null;
        if ( empty($runtime) ) {
            $erroresFormulario[] = "<p class='red-error'>La duración de la película o serie no puede estar vacía</p>";
        }
        $episodes = isset($datos['episodes']) ? $datos['episodes'] : null;
        if ( empty($episodes) ) {
            $erroresFormulario[] = "<p class='red-error'>Los episodios de la película o serie no pueden estar vacío</p>";
        }
        $directedBy = isset($datos['directedBy']) ? $datos['directedBy'] : null;
        if ( empty($directedBy) ) {
            $erroresFormulario[] = "<p class='red-error'>El director de la película o serie no puede estar vacío</p>";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $movie = Filmserie::create($title, $releaseDate, $genre, $runtime, $episodes, $directedBy);
			if(!$movie) {
                $erroresFormulario[] = "<p class='red-error'>Ya existe esta película o serie</p>";
            }
            else{
                return "main_page.php?inserted=".$title;
            }
        }
        return $erroresFormulario;
    }
}