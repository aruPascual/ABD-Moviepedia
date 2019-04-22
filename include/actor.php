<?php
require_once("aplicacion.php");
require_once("filmserie.php");
class Actor{
	private $id;
	private $name;
	private $birthDate;

	/* constructora */
	private function __construct($name, $birthDate){
		$this->name = $name;
		$this->birthDate = $birthDate;
	}

	/* getters */
	public function id(){
		return $this->id;
	}
	public function name(){
		return $this->name;
	}
	public function birthDate(){
		return $this->birthDate;
	}

	/* metodo que devuelve un actor de la base de datos */
	public static function searchActor($name){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT * FROM actor AC WHERE AC.name= '%s'"
			, $conn->real_escape_string($name));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			if ($rs->num_rows == 1) {
				$row = $rs->fetch_assoc();
				$actor = new Actor($row['name'], $row['birthDate']);
				$actor->id = $row['idActor'];
				$result = $actor;
			}
			$rs->free();
		}
		else{
			echo "<p class='red-error'>Error al consultar un actor o actriz en la BD: (". $conn->errno .") ". utf8_encode($conn->errno) . "</p>";
			exit();
		}
		return $result;
	}

	/* muestra por pantalla la información de un actor o una actriz */
	public static function printMovies($actor){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT DISTINCT FS.title, FS.releaseDate FROM (actor AC JOIN cast CS) JOIN filmserie FS WHERE AC.idActor = '%d' AND AC.idActor = CS.idActor AND CS.idFilm = FS.idFilm ORDER BY FS.releaseDate"
			, $conn->real_escape_string($actor->id));
		$rs = $conn->query($query);

		if ($rs) {
			if ($rs->num_rows > 0) {
				echo <<< END
				<div class="print" id="pdAndCast">
				<p class="label">Películas y series en las que aparece:</p><p>$actor->name</p>
				</div>
				<div class="print" id="listMovies">
				END;
				$i = 0;
				while ($row = mysqli_fetch_assoc($rs)) {
					echo '<p>- '.$row['title'] . ' (' .$row['releaseDate'] .')</p>';
				}
				echo '</div>';
			}
			else {
				echo 'Este actor o actriz parece que no ha participado en ninguna película o serie.';
			}
		}
	}

	/*crea un nuevo actor según los datos introducidos*/
	public static function create($name, $birthDate) {
		$actor = self::searchActor($name);
		if ($actor) {
			return false;
		}
		$actor = new Actor($name, $birthDate);
		return self::insert($actor); 
	}

	/*inserta un actor en la base de datos*/
	private static function insert($actor) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("INSERT INTO actor(name, birthDate) VALUES ('%s', '%s')"
			, $conn->real_escape_string($actor->name)
			, $conn->real_escape_string($actor->birthDate));
		if ($conn->query($query)) {
			$actor->id = $conn->insert_id;
		}
		else {
			echo "<p class='red-error'>Error al insertar un actor o actriz en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
			exit();
		}
		return $actor;
	}

	/*actualiza un actor de la base de datos*/
	public static function update($actor, $name, $birthDate){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("UPDATE actor SET name='%s', birthDate='%s' WHERE idActor='%d'"
			, $conn->real_escape_string($name)
			, $conn->real_escape_string($birthDate)
			, $actor->id());
		if ($conn->query($query)) {
			if ($conn->affected_rows != 1) {
				echo "<p class='red-error'>No se ha podido actualizar: ". $actor->id . "</p>";
				exit();
			}
		}
		else {
			echo "<p class='red-error'>Error al actualizar un actor o actriz de la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $actor;
	}

	/* elimina un actor de la base de datos */
	public static function deleteActor($name) {
		$success = true;

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("DELETE FROM actor WHERE name='%s'" , $conn->real_escape_string($name));
		$rs = $conn->query($query);
		if (!$rs) {
			$success = false;
			echo "<p class='red-error'>Error al eliminar un actor o actriz de la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $success;
	}

	/* añade un actor o actriz al elenco de una película */
	public static function isCast($actorName, $title) {
		/*success tiene tres valores: 0 en caso de exito, 1 en caso de que no se pueda realizar la conexion con la base de datos,
		 2 si falla al buscar actor o film */
		$success = 1;

		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		/* busqueda de la película a la que se va añadir el actor/actriz como parte del elenco */
		$film = Filmserie::searchFilmserie($title);
		$idFilm = $film->id();
		$actor = Actor::searchActor($actorName);
		$idActor = $actor->id;
		if ($film && $actor) {
			$query = sprintf("INSERT INTO `cast`(`idFilm`, `idActor`) VALUES ('%d', '%d')"
				, $idFilm
				, $idActor);
			$rs = $conn->query($query);
			if ($rs) {
				$success = 0;
			}
			else {
				echo "<p class='red-error'>Error al insertar un actor o actriz como elenco en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
				exit();
			}
		}
		else{
			return 2;
		}
		return $success;
	}

	/* devuelve la última varolación otorgada por un usuario */
	public static function rated($usuarioId) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT AC.name,RA.rating FROM ratingactor RA JOIN actor AC WHERE RA.idUser = '%d' AND RA.idActor = AC.idActor"
			, $conn->real_escape_string($usuarioId));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			if ($rs->num_rows > 0) {
				$result = array();
				$i = 0;
				while ($row = mysqli_fetch_assoc($rs)) {
					$rating = array();
					$rating[0] = $row['name']; $rating[1] = $row['rating'];
					$result[$i] = $rating;
					$i++;
				}
			}
			$rs->free();
		}
		else{
			echo "<p class='red-error'>Error al consultar los rating de actores y actrices en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $result;
	}
}