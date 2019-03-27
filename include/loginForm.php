<?php
require_once('form.php');
require_once('usuario.php');
class formularioLogin extends Form{
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
        $html .= '<input type="text" name="username" placeholder="Username">';
        $html .= '<input type="password" name="pass" placeholder="Password">';
        $html .= '<button type="submit" name="login-submit"> Enviar </button>';
        $html .= '</div>';
        return $html;
    }
    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $username = isset($datos['username']) ? $datos['username'] : null;
        if ( empty($username) ) {
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }
        $password = isset($datos['pass']) ? $datos['pass'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }
        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php
            $usuario = Usuario::buscaUsuario($username);
			
            if (!$usuario) {
                $erroresFormulario[] = "El usuario o el password no coinciden";
            }
            else{
                if ($usuario->compruebaPassword($password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $username;
                    $_SESSION['esAdmin'] = strcmp($fila['rol'], 'admin') == 0 ? true : false;
                    return "main_page.php";
                } else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                }
            }
        }
        return $erroresFormulario;
    }
}