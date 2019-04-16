/* inserción de valores en la tabla de usuarios */
INSERT INTO `users` (`idUser`, `username`, `email`, `password`, `rol`) 
VALUES (1, 'admin', 'admin@gmail.com', '$2y$10$4bfcBg2F0DigooaPbDNjQeVIo5TxvL63Uha51i66eqCztGENXtWTW', '1');

/* inserción de valores en la tabla pd */
INSERT INTO `pd` (`idPd`, `name`, `birthDate`)
 VALUES (1, 'James Cameron', '1954-08-16')
 	, (2, 'Jon Favreau', '1966-10-19')
 	, (3, 'George Lucas', '1944-05-14');

/* inserción de valores en la tabla filmserie */
INSERT INTO `filmserie` (`idFilm`, `title`, `releaseDate`, `genre`, `runtime`, `episodes`, `directedBy`) 
VALUES (1, 'Avatar', '2009-12-10', 'Ciencia ficción', '162', '1', '1')
	, (2, 'Iron Man', '2008-04-30', 'Ciencia ficción', '126', '1', '2')
	, (3, 'Titanic', '1998-01-09', 'Drama', '194', '1', '1')
	, (4, 'Terminator', '1984-08-26', 'Ciencia ficción', '108', '1', '1')
	, (5, 'Piraña II', '1983-06-04', 'Horror', '94', '1', '1');

/* inserción de valores en la tabla actor */
INSERT INTO `actor` (`idActor`, `name`, `birthDate`) 
VALUES (1, 'Robert Downey Jr.', '1965-04-04');