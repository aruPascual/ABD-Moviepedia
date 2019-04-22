<?php
require_once("aplicacion.php");
require_once("pd.php");
class Filmserie {
	private $id;
	private $title;
	private $releaseDate;
	private $genre;
	private $runtime;
	private $episodes;
	private $directedBy;

	/*constructora*/
	private function __construct($title, $releaseDate, $genre, $runtime, $episodes, $directedBy){
		$this->title = $title;
		$this->releaseDate = $releaseDate;
		$this->genre = $genre;
		$this->runtime = $runtime;
		$this->episodes = $episodes;
		$this->directedBy = $directedBy;
	}

	/*getters*/
	public function id() {
		return $this->id;
	}
	public function title() {
		return $this->title;
	}
	public function releaseDate() {
		return $this->releaseDate;
	}
	public function genre() {
		return $this->genre;
	}
	public function runtime() {
		return $this->runtime;
	}
	public function episodes() {
		return $this->episodes;
	}
	public function directedBy() {
		return $this->directedBy;
	}

	/* devuelve la peícula o serie buscada por el usuario */
	public static function searchFilmSerie($title) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT * FROM filmserie FS WHERE FS.title = '%s'", $conn->real_escape_string($title));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			if ($rs->num_rows == 1) {
				$row = $rs->fetch_assoc();
				$movie = new Filmserie($row['title'], $row['releaseDate'], $row['genre'], $row['runtime'], $row['episodes'], $row['directedBy']);
				$movie->id = $row['idFilm'];
				$result = $movie;
			}
			$rs->free();
		}
		else{
			echo "<p class='red-error'>Error al consultar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $result;
	}

	/* muestra por pantalla una pelicula o serie */
	public static function printPdAndCast($movie) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		/* cast */
		$query = sprintf("SELECT AC.name FROM filmserie FS JOIN (actor AC JOIN cast CS) WHERE FS.idFilm = '%d' AND AC.idActor = CS.idActor AND CS.idFilm = FS.idFilm ORDER BY AC.name"
			, $conn->real_escape_string($movie->id));
		$rs = $conn->query($query);

		if ($rs) {
			if ($rs->num_rows > 0) {
				echo <<< END
				<div class="print" id="pdAndCast">
				<p class="label">Actores y actrices que forman parte del elenco:</p>
				</div>
				<div class="print" id="listCast">
				END;
				$i = 0;
				while ($row = mysqli_fetch_assoc($rs)) {
					echo '<p>- '.$row['name'].'</p>';
				}
				echo '</div>';
			}
			else {
				echo 'Este actor o actriz parece que no ha participado en ninguna película o serie.';
			}
		}

		/* pd */
		$query = sprintf("SELECT name FROM filmserie JOIN pd WHERE idFilm = '%d' AND directedBy = idPd"
			, $conn->real_escape_string($movie->id()));
		$rs = $conn->query($query);
		$row = mysqli_fetch_assoc($rs);

		$pdName = $row['name'];
		echo <<<END
		<div class="print" id="pdAndCast">
		<p class="label">Dirigida por: </p>$pdName
		</div>
		END;
	}

	/* crea una nueva película o serie según los datos introducidos por parámetro*/
	public static function create($title, $releaseDate, $genre, $runtime, $episodes, $directedBy) {
		$movie = self::searchFilmSerie($title);
		if ($movie) {
			return false;
		}
		$pd = Pd::searchPd($directedBy);
		if (!$pd) {
			$pd = Pd::create($directedBy, $releaseDate);
		}
		$movie = new Filmserie($title, $releaseDate, $genre, $runtime, $episodes, $pd->id());
		return self::insert($movie);
	}

	/* inserta en la base de datos */
	private static function insert($movie) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("INSERT INTO filmserie(title, releaseDate, genre, runtime, episodes, directedBy)
			VALUES('%s','%s','%s','%d','%d','%d')"
			, $conn->real_escape_string($movie->title)
			, $conn->real_escape_string($movie->releaseDate)
			, $conn->real_escape_string($movie->genre)
			, $conn->real_escape_string($movie->runtime)
			, $conn->real_escape_string($movie->episodes)
			, $conn->real_escape_string($movie->directedBy));
		if ($conn->query($query)) {
			$movie->id = $conn->insert_id;
		}
		else{
			echo "<p class='red-error'>Error al insertar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno)."</p>";
			exit();
		}
		return $movie;
	}

	/*actualiza una fila de la base de datos*/
	public static function update($movie, $title, $releaseDate, $genre, $runtime, $episodes, $directedBy) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		/*buscamos el id del director o lo creamos si no existe*/
		$pd = Pd::searchPd($directedBy);
		if (!$pd) {
			$pd = Pd::create($directedBy, $releaseDate);
		}
		$query = sprintf("UPDATE filmserie SET title='%s', releaseDate='%s', genre='%s', runtime='%d', episodes='%d', directedBy='%d' WHERE idFilm='%d'"
			, $conn->real_escape_string($title)
			, $conn->real_escape_string($releaseDate)
			, $conn->real_escape_string($genre)
			, $conn->real_escape_string($runtime)
			, $conn->real_escape_string($episodes)
			, $conn->real_escape_string($pd->id())
			, $movie->id);
		if ($conn->query($query)) {
			if ($conn->affected_rows != 1) {
				echo "<p class='red-error'>No se ha podido actualizar: ". $movie->id . " </p>";
				exit();
			}
		}
		else{
			echo "<p class='red-error'>Error al actualizar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $movie;
	}

	/* elimina un película o serie de la base de datos */
	public static function deleteFilmserie($title) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("DELETE FROM filmserie WHERE title='%s'"
			, $conn->real_escape_string($title));
		if ($rs = $conn->query($query)) {
			if ($conn->affected_rows != 1) {
				echo "<p class='red-error'>No se ha podido eliminar: ". $movie->id . " </p>";
				exit();
			}
		}
		else{
			echo "<p class='red-error'>Error al eliminar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $success;
	}

	/* devuelve la última varolación otorgada por un usuario */
	public static function lastRating($usuarioId) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("SELECT FS.title,RA.rating FROM ratingfos RA JOIN filmserie FS WHERE RA.idUser = '%d' AND RA.idFilm = FS.idFilm"
			, $conn->real_escape_string($usuarioId));
		$rs = $conn->query($query);
		$result = false;
		if ($rs) {
			if ($rs->num_rows > 0) {
				$result = array();
				$i = 0;
				while ($row = mysqli_fetch_assoc($rs)) {
					$rating = array();
					$rating[0] = $row['title']; $rating[1] = $row['rating'];
					$result[$i] = $rating;
					$i++;
				}
			}
			$rs->free();
		}
		else{
			echo "<p class='red-error'>Error al consultar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $result;
	}
}