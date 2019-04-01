<?php
require_once('form.php');
require_once('filmserie.php');
class formularioInsercionPoS extends Form{
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
        $html .= '<p>¿Cual es la fecha de estreno?</p>';
        $html .= '<input type="date" name="releaseDate" placeholder="Fecha de estreno">';       
        $html .= '<p>¿Cual es el género?</p>';
        $html .= '<input type="text" name="genre" placeholder="Género">';
        $html .= '<p>¿Cual es la duración?</p>';
        $html .= '<input type="number" name="runtime" placeholder="Duración">';
        $html .= '<p>¿Cuántos episodios tiene?</p>';
        $html .= '<input type="number" name="episodes" placeholder="Episodios">';
        $html .= '<p>¿Cual es el director?</p>';
        $html .= '<input type="text" name="directedBy" placeholder="Director">';
    	$html .= '<button type="submit" name="pors-insert">Insertar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $title = isset($datos['title']) ? $datos['title'] : null;
        if ( empty($title) ) {
            $erroresFormulario[] = "El título de la película o serie no puede estar vacío";
        }
        $releaseDate = isset($datos['releaseDate']) ? $datos['releaseDate'] : null;
        if ( empty($releaseDate) ) {
            $erroresFormulario[] = "La fecha de estreno de la película o serie no puede estar vacía";
        }
        $genre = isset($datos['genre']) ? $datos['genre'] : null;
        if ( empty($genre) ) {
            $erroresFormulario[] = "El género de la película o serie no puede estar vacío";
        }
        $runtime = isset($datos['runtime']) ? $datos['runtime'] : null;
        if ( empty($runtime) ) {
            $erroresFormulario[] = "La duración de la película o serie no puede estar vacía";
        }
        $episodes = isset($datos['episodes']) ? $datos['episodes'] : null;
        if ( empty($episodes) ) {
            $erroresFormulario[] = "Los episodios de la película o serie no pueden estar vacío";
        }
        $directedBy = isset($datos['directedBy']) ? $datos['directedBy'] : null;
        if ( empty($directedBy) ) {
            $erroresFormulario[] = "El director de la película o serie no puede estar vacío";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $movie = Filmserie::create($title, $releaseDate, $genre, $runtime, $episodes, $directedBy);
			if(!$movie) {
                $erroresFormulario[] = "El título de la película o serie ya existe";
            }
            else{
                return "main_page.php";
            }
        }
        return $erroresFormulario;
    }
}