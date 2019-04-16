<?php
require_once("form.php");
require_once("filmserie.php");
class formularioActualizacionPoS extends Form{
	public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }
    
    protected function generaCamposFormulario($datosIniciales){
    	$html = '<div class="form">';
    	$html .= '<p>¿Cuál es el título de la película o sere que vas a actualizar?</p>';
    	$html .= '<input type="text" name="title" placeholder="Título">';
        $html .= '<p>¿La fecha de estreno es otra?</p>';
        $html .= '<input type="date" name="releaseDate" placeholder="Fecha de estreno">';       
        $html .= '<p>¿Pertenece a otro género?</p>';
        $html .= '<input type="text" name="genre" placeholder="Género">';
        $html .= '<p>¿Dura más o dura menos?</p>';
        $html .= '<input type="number" name="runtime" placeholder="Duración">';
        $html .= '<p>Si tiene más de un episodio es que es una serie, ¿no crees?</p>';
        $html .= '<input type="number" name="episodes" placeholder="Episodios">';
        $html .= '<p>¿El director ha cambiado de nombre?</p>';
        $html .= '<input type="text" name="directedBy" placeholder="Director">';
    	$html .= '<button type="submit" name="pors-update">Actualizar</button>';
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

            $movie = Filmserie::searchFilmserie($title);
			if(!$movie) {
                $erroresFormulario[] = "<p class='red-error'>Esta película o serie no existe</p>";
            }
            else{
                $movieUpdate = Filmserie::update($movie, $title, $releaseDate, $genre, $runtime, $episodes, $directedBy);
                if (!$movieUpdate) {
                    $erroresFormulario[] = "<p class='red-error'>No se ha podido actualizar</p>";
                }

                return "main_page.php?updated=".$title;
            }
        }
        return $erroresFormulario;
    }
}