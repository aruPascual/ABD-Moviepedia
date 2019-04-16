<?php
require_once("aplicacion.php");
require_once("filmserie.php");
class Pd {
	private $id;
	private $name;
	private $birthDate;

	/*constructora*/
	private function __construct($name, $birthDate) {
		$this->name = $name;
		$this->birthDate = $birthDate;
	}

	/*getters*/
	public function id(){
		return $this->id;
	}
	public function name(){
		return $this->name;
	}
	public function birthDate(){
		return $this->birthDate;
	}

	/*devuelve un director de la base de datos*/
	public static function searchPd($name){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT * FROM pd PD WHERE PD.name= '%s'", $conn->real_escape_string($name));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			if ($rs->num_rows == 1) {
				$row = $rs->fetch_assoc();
				$pd = new Pd($row['name'], $row['birthDate']);
				$pd->id = $row['idPd'];
				$result = $pd;
			}
			$rs->free();
		}
		else{
			echo "<p class='red-error'>Error al consultar un director en la BD: (". $conn->errno .") ". utf8_encode($conn->errno) . "</p>";
			exit();
		}
		return $result;
	}
	/* muestra por pantalla la información de un director */
	public static function print($pd){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT DISTINCT title, releaseDate FROM pd JOIN filmserie WHERE directedBy = '%d' ORDER BY releaseDate"
			, $conn->real_escape_string($pd->id));
		$rs = $conn->query($query);

		echo <<< END
		<div class="print">
		<p class="label">Nombre: </p>$pd->name
		</div>
		<div class="print">
		<p class="label">Fecha de nacimiento: </p>$pd->birthDate
		</div>
		END;
		if ($rs) {
			if ($rs->num_rows > 0) {
				echo <<< END
				<div class="print-movies">
				<p class="label">Películas y series dirigidas por:</p><p>$pd->name</p>
				</div>
				<div class="print-list-movies">
				END;
				$i = 0;
				while ($row = mysqli_fetch_assoc($rs)) {
					echo '<p>- '.$row['title'] . ' (' .$row['releaseDate'] .')</p>';
				}
				echo '</div>';
			}
			else {
				echo 'Este director parece que no ha dirigido ninguna película.';
			}
		}
	}

	/*crea un nuevo director según los datos introducidos*/
	public static function create($name, $birthDate) {
		$pd = self::searchPd($name);
		if ($pd) {
			return false;
		}
		$pd = new Pd($name, $birthDate);
		return self::insert($pd); 
	}

	/*inserta un director en la base de datos*/
	private static function insert($pd) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("INSERT INTO pd(name, birthDate) VALUES ('%s', '%s')"
			, $conn->real_escape_string($pd->name)
			, $conn->real_escape_string($pd->birthDate));
		if ($conn->query($query)) {
			$pd->id = $conn->insert_id;
		}
		else {
			echo "<p class='red-error'>Error al insertar un director en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
			exit();
		}
		return $pd;
	}

	/*actualiza un director de la base de datos*/
	public static function update($pd, $name, $birthDate){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("UPDATE pd SET name='%s', birthDate='%s' WHERE idPd='%d'"
			, $conn->real_escape_string($name)
			, $conn->real_escape_string($birthDate)
			, $pd->id());
		if ($conn->query($query)) {
			if ($conn->affected_rows != 1) {
				echo "<p class='red-error'>No se ha podido actualizar: ". $pd->id . "</p>";
				exit();
			}
		}
		else {
			echo "<p class='red-error'>Error al actualizar un director en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $pd;
	}

	/* elimina un director de la base de datos */
	public static function deletePd($pdName) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("DELETE FROM pd WHERE name='%s'"
			, $conn->real_escape_string($pdName));
		$rs = $conn->query($query);
		$success = true;
		if (!$rs) {
			$success = false;
			echo "<p class='red-error'>Error al eliminar un director en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $success;
	}
}