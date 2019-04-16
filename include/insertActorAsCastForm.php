<?php
require_once("form.php");
require_once("actor.php");
class formularioInsercionActorComoElenco extends Form{
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
    	$html .= '<p>¿Cuál es el nombre del actor o actriz que forma parte del elenco?</p>';
    	$html .= '<input type="text" name="nameActor" placeholder="Nombre">';
        $html .= '<p>¿Cuál es la película o serie en la que participa?</p>';
        $html .= '<input type="text" name="title" placeholder="Título">';
    	$html .= '<button type="submit" name="actor-to-cast-insert">Insertar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $nameActor = isset($datos['nameActor']) ? $datos['nameActor'] : null;
        if ( empty($nameActor) ) {
            $erroresFormulario[] = "<p class='red-error'>El nombre del actor o actriz no puede estar vacío</p>";
        }
        $title = isset($datos['title']) ? $datos['title'] : null;
        if ( empty($title) ) {
            $erroresFormulario[] = "<p class='red-error'>El título de la película o serie no puede estar vacío</p>";
        }
        if (count($erroresFormulario) === 0) {
            $actor = Actor::isCast($nameActor, $title);
            if ($actor == 1) {
                $erroresFormulario[] = "<p class='red-error'>Ha ocurrido un error al conectar con la BD</p>";
            }
            else if($actor == 2) {
                $erroresFormulario[] = "<p class='red-error'>Este actor/actriz y/o película puede que no existan</p>";
            }
            else if ($actor == 0) {
                return "main_page.php?added=".$nameActor."&as-cast-from=".$title;
            }
        }
        return $erroresFormulario;
    }
}