<?php
require_once('form.php');
require_once('usuario.php');
class formularioRegistro extends Form{
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
        $html .= '<input type="text" name="email" placeholder="Mail">';
        $html .= '<input type="password" name="pass" placeholder="Password">';
        $html .= '<input type="password" name="pass-repeat" placeholder="Repeat password">';
        $html .= '<button type="submit" name="signup-submit"> Enviar </button>';
        $html .= '</div>';
        return $html;
    }
    protected function procesaFormulario($datos){
        $erroresFormulario = array();
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        if ( empty($username) || mb_strlen($username) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        if ( empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $erroresFormulario[] = "El email no tiene un formato valido.";
        }
        
        $password = isset($_POST['pass']) ? $_POST['pass'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($_POST['pass-repeat']) ? $_POST['pass-repeat'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::crea($username, $email, $password, 0);
            
            if (! $usuario ) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $username;
                $_SESSION['rol'] = $usuario->rol();
                return "main_page.php";
            }
        }
        return $erroresFormulario;
    }
}