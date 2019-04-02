<?php
require_once("include/aplicacion.php");
require_once("include/pd.php");
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
		return self::save($movie);
	}

	/*actualiza o inserta*/
	public static function save($movie) {
		if ($movie->id !== null) {
			return self::update($movie);
		}
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
	private static function update($movie) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("UPDATE filmserie SET title='%s', releaseDate='%s', genre='%s', runtime='%d', episodes='%d', directedBy='%d')
			WHERE idFilm='%i'"
			, $conn->real_escape_string($movie->title)
			, $conn->real_escape_string($movie->releaseDate)
			, $conn->real_escape_string($movie->genre)
			, $conn->real_escape_string($movie->runtime)
			, $conn->real_escape_string($movie->episodes)
			, $conn->real_escape_string($movie->directedBy)
			, $movie->id);
		if ($conn->query($query)) {
			if ($conn->affected_rows !== 1) {
				echo "<p class='red-error'>No se ha podide actualizar: ". $movie->id . " </p>";
				exit();
			}
		}
		else{
			echo "<p class='red-error'>Error al actualizar una película o serie en la BD: (". $conn->errno .") ". utf8_encode($conn->errno). "</p>";
			exit();
		}
		return $movie;
	}
}