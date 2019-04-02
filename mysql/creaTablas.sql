SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*--Tabla de usuarios--*/
CREATE TABLE users(
	idUser int(32) NOT NULL,
	username varchar(32) UNIQUE NOT NULL,
	email varchar(32) NOT NULL,
	password varchar(256) NOT NULL,
	rol TINYINT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE users ADD PRIMARY KEY(idUser);

ALTER TABLE users MODIFY idUser int(32) NOT NULL AUTO_INCREMENT;

/*--Tabla de peliculas/series--*/
CREATE TABLE filmserie (
	idFilm int(32) NOT NULL,
	title varchar(64) UNIQUE NOT NULL,
	releaseDate date,
	genre varchar(32) NOT NULL,
	runtime int(32) NOT NULL,
	episodes int(32) NOT NULL,
	directedBy int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE filmserie ADD PRIMARY KEY(idFilm);

ALTER TABLE filmserie MODIFY idFilm int(32) NOT NULL AUTO_INCREMENT;

/*--Tabla de usuarios--*/
CREATE TABLE actor (
	idActor int(32) NOT NULL,
	name varchar(64) NOT NULL,
	birthDate date
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE actor ADD PRIMARY KEY (idActor);

ALTER TABLE actor MODIFY idActor int(32) NOT NULL AUTO_INCREMENT;

/*--Tabla de directores--*/
CREATE TABLE  pd (
	idPd int(32) NOT NULL,
	name varchar(64) NOT NULL,
	birthDate date
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE pd ADD PRIMARY KEY (idPd);

ALTER TABLE pd MODIFY idPd int(32) NOT NULL AUTO_INCREMENT;

ALTER TABLE filmserie 
	ADD CONSTRAINT filmserie_ibfk_1 FOREIGN KEY (directedBy) REFERENCES pd (idPd);

/*--Tabla del elenco--*/
CREATE TABLE cast (
	idFilm int(32) NOT NULL,
	idActor int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE cast ADD PRIMARY KEY (idFilm, idActor);

ALTER TABLE cast 
	ADD CONSTRAINT cast_ibfk_1 FOREIGN KEY (idFilm) REFERENCES filmserie (idFilm),
	ADD CONSTRAINT cast_ibfk_2 FOREIGN KEY (idActor) REFERENCES actor (idActor);

/*--Tabla de valoración de peliculas/series--*/
CREATE TABLE ratingFoS (
	idUser int(32) NOT NULL,
	idFilm int(32) NOT NULL,
	rating int(32) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE ratingFoS ADD PRIMARY KEY (idUser, idFilm);

ALTER TABLE ratingFoS
	ADD CONSTRAINT ratingFoS_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser),
	ADD CONSTRAINT ratingFoS_ibfk_2 FOREIGN KEY (idFilm) REFERENCES filmserie (idFilm);

/*--Tabla de valoración de actores--*/
CREATE TABLE ratingActor (
	idUser int(32) NOT NULL,
	idActor int(32) NOT NULL,
	rating int(32) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE ratingActor ADD PRIMARY KEY (idUser, idActor);

ALTER TABLE ratingActor
	ADD CONSTRAINT ratingActor_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser),
	ADD CONSTRAINT ratingActor_ibfk_2 FOREIGN KEY (idActor) REFERENCES actor (idActor);

/*--Tabla de valoración e directores--*/
CREATE TABLE ratingPd (
	idUser int(32) NOT NULL,
	idPd int(32) NOT NULL,
	rating int(32) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE ratingPd ADD PRIMARY KEY (idUser, idPd);

ALTER TABLE ratingPd
	ADD CONSTRAINT ratingPd_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (idUser),
	ADD CONSTRAINT ratingPd_ibfk_2 FOREIGN KEY (idPd) REFERENCES pd (idPd);

/*commit final*/
COMMIT;