<?php
require_once('aplicacion.php');
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
			$rs->free;
		}
		else{
			echo "Error al consultar en la BD: (". $conn->errno .") ". utf8_encode($conn->errno);
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
		$movie = new Filmserie($title, $releaseDate, $genre, $runtime, $episodes, $directedBy);
		return self::insert($movie);
	}

	/* inserta en la base de datos */
	private static function insert($movie) {
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();
		$query = sprintf("INSERT INTO filmserie(title, releaseDate, genre, runtime, episodes, directedBy)
			VALUES('%s','%s','%s','%d','%d','%s')"
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
			echo "Error al insertar en la BD: (". $conn->errno .") ". utf8_encode($conn->errno);
			exit();
		}
		return $movie;
	}
}