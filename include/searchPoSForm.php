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
    	$html .= '<input type="text" name="data" placeholder="Título">';
    	$html .= '<button type="submit" name="pors-search">Buscar</button>';
    	$html .= '</div>';
    	return $html;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $dataToSearch = isset($datos['data']) ? $datos['data'] : null;
        if ( empty($dataToSearch) ) {
            $erroresFormulario[] = "<p class='red-error'>¿Qué quieres buscar? Escríbelo</p>";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $movie = Filmserie::searchFilmSerie($datos[data]);
			
            if (!$movie) {
                $erroresFormulario[] = "<p class='red-error'>La película o serie no existe.</p>";
            }
            else{
                if ($usuario->compruebaPassword($password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $username;
                    $_SESSION['esAdmin'] = strcmp($fila['rol'], 'admin') == 0 ? true : false;
                    return "main_page.php";
                } else {
                    $erroresFormulario[] = "<p class='red-error'>El usuario o el password no coinciden</p>";
                }
            }
        }
        return $erroresFormulario;
    }
}