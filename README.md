# paginaLucasJimenezz Base de Datos con productos administradores ETC ya registrados

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL,
  `Rol` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID`, `Rol`) VALUES
(1, 'Administrador'),
(2, 'Trabajador'),
(3, 'Jefe'),
(4, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `correoUsuario` varchar(250) NOT NULL,
  `passUsuario` varchar(250) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `correoUsuario`, `passUsuario`, `ID_Rol`) VALUES
(1, 'lucasjimenez@gmail.com', 'Lucas2000', 1),
(2, 'lucastrabajador@gmail.com', 'Lucas2000', 2),
(3, 'lucasjefe@gmail.com', 'Lucas2000', 3),
(4, 'qwertyxz@gmail.com', 'Lucas2000', 3),
(9, 'pma@gmail.com', 'Lucas2000', 3),
(10, 'qwertyxzzz@gmail.com', 'Lucas2000', 1),
(12, 'usuario@gmail.com', 'Lucas2000', 4),
(13, 'perro@gmail.com', 'perro123', 1),
(17, 'seba@gmail.com', 'Perro', 3),
(21, 'kebin@gmail.com', 'Perro', 2),
(22, 'usuario2@gmail.com', 'Lucas2000', 4),
(25, 'dasdas@dasdas', 'Perro', 3),
(26, 'pma@dasdasd', '3123123', 1),
(28, 'lucasjimenexdasdaz@gmail.com', '1233131', 3),
(31, 'dasda@dasdas', '31231', 1),
(33, 'qwertyxz@gmail.commm', 'Lucase12312', 1),
(35, 'pmadasdasd@dasdasda', 'Lucas2000', 3),
(37, 'qwertyxz@gmail.comdasdas', 'dasdasda', 1),
(38, 'dasda@dasdasda', '23123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuego`
--

CREATE TABLE `videojuego` (
  `idJuego` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `precio` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `videojuego`
--

INSERT INTO `videojuego` (`idJuego`, `titulo`, `descripcion`, `precio`, `imagen`, `stock`) VALUES
(8, 'Street Fighter 6', 'Prepárate para dar rienda suelta a tu guerrero interior con Street Fighter 6, la mejor experiencia de juego de lucha! Con su sistema de combate avanzado y características innovadoras, este juego es la próxima evolución de la icónica franquicia, lleva', 1999, 'imagenesJuegos/stretf.jpg', 0),
(9, '7 Days to Die', 'Si tu género favorito es el de terror, ¡no puedes dejar pasar este juego! Compra 7 Days to Day key y descubre si tienes lo que hay que tener para sobrevivir en este mundo gobernado por la muerte. Crea, personaliza y mejora a tu personaje para darle l', 7999, 'imagenesJuegos/7days.jpg', 0),
(10, 'Mortal Kombat 11', 'Mortal Kombat 11 seguirá con su mitología y extenso universo, algo en lo que siempre ha destacado por encima de otras series de lucha. En esta ocasión se continuará tras la derrota de Shinnok, ofreciéndonos un corrompido Raiden que amenazará a todos ', 9999, 'imagenesJuegos/mortalK.jpeg', 868),
(11, 'God of War', 'Una gran e inesperada noticia ha llegado a los jugadores de PC de todo el mundo: cuatro años después de su lanzamiento original, God of War (PC) Código de Steam de \"Santa Monica Studios\", que hasta ahora había sido exclusivo de PlayStation 4, llega a', 4999, 'imagenesJuegos/gof.jpeg', 0),
(12, 'Tekken 7', 'Tekken 7 key ofrece un juego multijugador de acción y pelea desarrollado por BANDAI NAMCO Entertainment. Vuelve a sentir el Torneo del Rey del Puño de Hierro, pero esta vez, sin embargo, la intensidad, las apuestas, las emociones y las recompensas ¡s', 1999, 'imagenesJuegos/Tekken7.jpg', 36),
(13, 'Dragon Ball: Xenoverse 2 ', 'Crees que Dragon Ball es lo mejor que ha pasado nunca? Con Dragon Ball Xenoverse 2 key, podrás nuevamente adentrarte en el mundo del popular anime, crear tu personaje y seguir las historias que amas, tomando ventaja de la nueva ciudad central, gráfic', 9999, 'imagenesJuegos/dragonball.jpg', 111),
(14, 'FIFA 23', 'FIFA World Cup™ para hombres y mujeres, equipos de clubes, funciones de juego cruzado y aún más en forma de clave de FIFA 23 (PC) Origin. Marca un acontecimiento histórico y un cambio en el género de los juegos deportivos. Desde 1993, los juegos de l', 12000, 'imagenesJuegos/fifa23.jpg', 0),
(15, 'GTA V', 'Al comprar Grand Theft Auto V: Edición online Premium te sumergirás en el inmenso mundo de GTA online con un montón de contenido. No sólo obtendrás el juego base, Grand Theft Auto V, sino que también encontrarás Criminal Enterprise Starter Pack. ¡Val', 19998, 'imagenesJuegos/gtav.jpeg', 0),
(16, 'Minecraft: Java Edition (PC)', '¡El mundo entero a tu alrededor está hecho de bloques, toda la realidad está hecha de bloques! ¡Aves, ovejas, nubes y agua son bloques! Un mundo sin fin, o más bien, eterno, lleno de cuevas, mazmorras, monstruos… Y la mejor parte es que puedes recole', 312312, 'imagenesJuegos/minecrafttt.jpeg', 98),
(19, 'Ready or Not (PC)', 'El juego Ready or Not (PC) Código de Steam es un intenso shooter en primera persona, ambientado en la época moderna, donde el jugador controla una unidad SWAT en peligrosos encuentros con terroristas y entornos realistas. Los desarrolladores de este ', 13231, 'imagenesJuegos/Read.jpg', 44),
(28, 'NBA 2K23 (PC)', '¿Quién está preparado para convertirse en una leyenda de la NBA? La emoción del baloncesto te espera en NBA 2K23. Prepárate para los distintos modos de juego y las nuevas características que ofrece el nuevo juego de la serie. El modo Carrera es aún m', 2132, 'imagenesjuegos/nba.jpg', 0),
(29, 'Move or Die', 'La clave Move or Die en Steam es el sello distintivo de los títulos de acción, ¡listo para llevar a los jugadores a una experiencia de juego única! Presentado por los famosos That Awesome Guys, el título supera las expectativas y brinda entretenimien', 2900, 'imagenesjuegos/moveordie.jpeg', 255);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `correoUsuario` (`correoUsuario`);

--
-- Indices de la tabla `videojuego`
--
ALTER TABLE `videojuego`
  ADD PRIMARY KEY (`idJuego`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `videojuego`
--
ALTER TABLE `videojuego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
