CREATE TABLE `Image` (
  `id_Image` INT NOT NULL AUTO_INCREMENT,
  `chemin_Image` varchar(100) NOT NULL,
  PRIMARY KEY (`id_Image`)    
);

INSERT INTO `Image` (`chemin_Image`) VALUES (
(`Jeu/1/gameplay1.jpg`),
(`Jeu/1/jaquette1.jpg`),
(`Jeu/2/gameplay2.jpg`),
(`Jeu/2/jaquette2.jpg`),
(`Jeu/3/gameplay3.jpg`),
(`Jeu/3/jaquette3.jpg`),
(`Jeu/4/gameplay4.jpg`),
(`Jeu/4/jaquette4.jpg`),
(`Jeu/5/gameplay5.jpg`),
(`Jeu/5/jaquette5.jpg`),
(`Jeu/6/gameplay6.jpg`),
(`Jeu/6/jaquette6.jpg`),
);

CREATE TABLE `Jeu` (
  `id_Jeu` INT NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prix` FLOAT NOT NULL,
  `date_sortie` DATE NOT NULL,
  `synopsis` varchar(300),
  PRIMARY KEY (`id_Jeu`)    
);

INSERT INTO `Jeu` (`prix`,`date_sortie`,`synopsis`) VALUES (
(`Fifa 21`,`12.36`,`14/08/2020`,`FIFA 21 est un jeu vidéo de football développé par EA Canada et EA Roumanie et édité par EA Sports`)
(`World of Warcraft`,`14.99`,`23/11/2004`,`Le jeu reprend place dans le monde imaginaire d'Azeroth, et dont le cadre historique se situe quatre ans après les évènements concluant Warcraft III . Le joueur choisit son personnage parmi huit, dix ou douze races disponibles divisées en deux factions : l'Alliance et la Horde.`)
(`Minecraft`,`20.00`,`18/11/2011`,`Minecraft plonge le joueur dans un monde créé de manière procédurale, composé de voxels (des cubes) représentant différents matériaux comme de la terre, du sable, de la pierre, de l'eau, de la lave ou des minerais (du fer, de l'or, du charbon, etc. ) formant diverses structures (arbres, cavernes, montagnes, temples).`)
(`Grand Theft Auto 5`,`19.99`,`17/09/2013`,`L'histoire solo suit trois protagonistes : le braqueur de banque à la retraite Michael De Santa, le gangster Franklin Clinton et le trafiquant de drogue et d'armes Trevor Philips, et leurs braquages sous la pression d'une agence gouvernementale corrompue et de puissants criminels.`)
(`Just Dance 22`,`26.54`,`04/11/2021`,`Just Dance 2023 Edition est un jeu de rythme et de danse développé par Ubisoft Paris et édité par Ubisoft.`)
(`Rocket League`,`00.00`,`07/07/2015`,`Deux équipes, composées de un à quatre joueurs conduisant des véhicules, s'affrontent au cours d'un match afin de frapper un ballon et de marquer dans le but adverse. Les voitures sont équipées de propulseurs (boost) et peuvent sauter, permettant de jouer le ballon dans les airs.`)

);

