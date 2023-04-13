/* table Image */

CREATE TABLE `Image` (
  `id_Image` INT NOT NULL AUTO_INCREMENT,
  `chemin_Image` varchar(100) NOT NULL,
  PRIMARY KEY (`id_Image`)    
);

INSERT INTO `Image` (`chemin_Image`) VALUES (
(`Images/Jeu/1/gameplay.jpg`),
(`Images/Jeu/1/jaquette.jpg`),
(`Images/Jeu/2/gameplay.jpg`),
(`Images/Jeu/2/jaquette.jpg`),
(`Images/Jeu/3/gameplay.jpg`),
(`Images/Jeu/3/jaquette.jpg`),
(`Images/Jeu/4/gameplay.jpg`),
(`Images/Jeu/4/jaquette.jpg`),
(`Images/Jeu/5/gameplay.jpg`),
(`Images/Jeu/5/jaquette.jpg`),
(`Images/Jeu/6/gameplay.jpg`),
(`Images/Jeu/6/jaquette.jpg`),
);

/* table Jeu */

CREATE TABLE `Jeu` (
  `id_Jeu` INT NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prix` FLOAT NOT NULL,
  `date_sortie` DATE NOT NULL,
  `synopsis` varchar(300),
  PRIMARY KEY (`id_Jeu`)    
);

INSERT INTO `Jeu` (`prix`,`date_sortie`,`synopsis`) VALUES (
(`Fifa 21`,`12.36`,`2020-08-14`,`FIFA 21 est un jeu vidéo de football développé par EA Canada et EA Roumanie et édité par EA Sports`)
(`World of Warcraft`,`14.99`,`2004-11-23`,`Le jeu reprend place dans le monde imaginaire d'Azeroth, et dont le cadre historique se situe quatre ans après les évènements concluant Warcraft III . Le joueur choisit son personnage parmi huit, dix ou douze races disponibles divisées en deux factions : l'Alliance et la Horde.`)
(`Minecraft`,`20.00`,`2011-11-18`,`Minecraft plonge le joueur dans un monde créé de manière procédurale, composé de voxels (des cubes) représentant différents matériaux comme de la terre, du sable, de la pierre, de l'eau, de la lave ou des minerais (du fer, de l'or, du charbon, etc. ) formant diverses structures (arbres, cavernes, montagnes, temples).`)
(`Grand Theft Auto 5`,`19.99`,`2013-09-17`,`L'histoire solo suit trois protagonistes : le braqueur de banque à la retraite Michael De Santa, le gangster Franklin Clinton et le trafiquant de drogue et d'armes Trevor Philips, et leurs braquages sous la pression d'une agence gouvernementale corrompue et de puissants criminels.`)
(`Just Dance 22`,`26.54`,`2021-11-04`,`Just Dance 2023 Edition est un jeu de rythme et de danse développé par Ubisoft Paris et édité par Ubisoft.`)
(`Rocket League`,`00.00`,`2015-07-07`,`Deux équipes, composées de un à quatre joueurs conduisant des véhicules, s'affrontent au cours d'un match afin de frapper un ballon et de marquer dans le but adverse. Les voitures sont équipées de propulseurs (boost) et peuvent sauter, permettant de jouer le ballon dans les airs.`)

);

/* table Role */

CREATE TABLE 'Role' (
  'id_Role' INT AUTO_INCREMENT,
  'nom_Role' VARCHAR(50)
  PRIMARY KEY (`id_Role`)
);

INSERT INTO 'role`' ('nom_Role') VALUES (
    ('Membre'),
    ('Rédacteur'),
    ('Administrateur')
);

/* table Categorie */

CREATE TABLE 'Categorie' (
  'id_Categorie' INT AUTO_INCREMENT,
  'nom_Categorie' VARCHAR(50),
  PRIMARY KEY (`id_Categorie`)

);

INSERT INTO 'Categorie' ('nom_Categorie') VALUES (
    ('Course'),
    ('RPG'),
    ('Sport'),
    ('Sandbox'),
);

/* table Support */

CREATE TABLE 'Support' (
  'id_Support' INT AUTO_INCREMENT,
  'nom_Support' VARCHAR(50),
  PRIMARY KEY (`id_Support`)
);

INSERT INTO 'Support' ('nom_Support') VALUES (
    ('PS'),
    ('Switch'),
    ('PC'),
    ('Xbox'),
    ('Wii')
);

/* table Utilisateur */

CREATE TABLE 'Utilisateur' (
  'id_Utilisateur' INT AUTO_INCREMENT,
  'login_Utilisateur' VARCHAR(50),
  'password_Utilisateur' VARCHAR(50),
  'photoProfil_Utilisateur' VARCHAR(50),
  'nom_Utilisateur' VARCHAR(50),
  'prenom_Utilisateur' VARCHAR(50),
  PRIMARY KEY (`id_Utilisateur`),
  FOREIGN KEY ('id_Role') REFERENCES 'Role'

);

INSERT INTO 'Utilisateur' ('login_Utilisateur', 'password_Utilisateur', 'photoProfil_Utilisateur', 'nom_Utilisateur', 'prenom_Utilisateur') VALUES (
    ('prannou', 'prof_de_SR', 'Images/PhotoProfil/1.png', 'RANNOU', 'Phillipe'),
    ('rmounier', 'prof_de_BDD', 'Images/PhotoProfil/2.png', 'MOUNIER', 'Romain'),
    ('hfeuillatre', 'prof_de_IHM', 'Images/PhotoProfil/3.png', 'FEUILLATRE', 'Hélène'),
    ('fthibault', 'prof_de_physique', 'Images/PhotoProfil/4.png', 'THIBAULT', 'Franck'),
    ('olafond', 'prof_delectronique', 'Images/PhotoProfil/5.png', 'LAFOND', 'Olivier'),
    ('vbouquet', 'prof_de_chimie', 'Images/PhotoProfil/6.png', 'BOUQUET', 'Valérie')
);

/* table Article */

CREATE TABLE 'Article' (
  'id_Article' INT AUTO_INCREMENT,
  'titre_Article' VARCHAR(100),
  'dateCreation_Article' DATE,
  'dateModification_Article' DATE,
  PRIMARY KEY (`id_Article`),
  FOREIGN KEY ('id_jeu') REFERENCES 'Jeu',
  FOREIGN KEY ('id_Utilisateur') REFERENCES 'Utilisateur',

);

INSERT INTO 'Article' ('titre_Article', 'dateCreation_Article', 'dateModification_Article') VALUES (
    ('Créez votre propre monde avec Minecraft !', '2022-05-12', NULL),
    ('Faites de votre salon un Dance Floor avec Just Dance !', '2022-06-04', NULL),
    ('Un Football en voiture ? Tout est possible avec Rocket League !', '2023-04-04', NULL),
    ('Jouer au football sans les ligaments croisés ? Fifa 21 est la solution !', '2023-03-04', NULL),
    ('Possédez-vous des pouvoirs magiques ? World of Warcraft à votre service !', '2022-10-10', NULL),
    ("Avez-vous déjà braqué une banque ? Avec GTA c'est légal !", '2021-12-12', NULL),
);

/* table Avis */

CREATE TABLE 'Avis' (
  'id_Avis' INT AUTO_INCREMENT,
  'titre_Avis' VARCHAR(100),
  'contenu_Avis' VARCHAR(500),
  'dateCreation_Avis' DATE,
  'note_Avis' INT4RANGE(0, 10),
  PRIMARY KEY (`id_Avis`),
  FOREIGN KEY ('id_Utilisateur') REFERENCES 'Utilisateur',
  FOREIGN KEY ('id_Jeu') REFERENCES 'Jeu'
);

/* table est_Categorie */

CREATE TABLE 'est_Categorie' (
  PRIMARY KEY ('id_Jeu') REFERENCES 'Jeu',
  PRIMARY KEY (`id_Categorie`) REFERENCES 'Categorie'
  
);

INSERT INTO 'est_Categorie' ('id_Jeu', 'id_Categorie') VALUES (
    (1, 2),
    (1, 3),
    (2, 2),
    (2, 4),
    (3, 4),
    (4, 1),
    (5, 3),
    (6, 1),
    (6, 3)
);

/* table est_Support */

CREATE TABLE 'est_Support' (
  PRIMARY KEY ('id_Jeu') REFERENCES 'Jeu',
  PRIMARY KEY (`id_Support`) REFERENCES 'Support'
);

INSERT INTO 'est_Support' ('id_Jeu', 'id_Support') VALUES (
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (1, 5),
    (2, 1),
    (2, 3),
    (3, 1),
    (3, 2),
    (3, 3),
    (3, 4),
    (3, 5),
    (4, 1),
    (4, 2),
    (4, 3),
    (4, 4),
    (4, 5),
    (5, 1),
    (5, 2),
    (5, 3),
    (5, 4),
    (5, 5),
    (6, 1),
    (6, 2),
    (6, 3),
    (6, 4)
);

/* table est_Image */

CREATE TABLE 'est_Image' (
  PRIMARY KEY (`id_Article`) REFERENCES 'Article',
  FOREIGN KEY ('id_image') REFERENCES 'Image'
);

INSERT INTO 'est_Image' ('id_Article', 'id_image') VALUES (
    (1, 1),
    (1, 2),
    (2, 3),
    (2, 4),
    (3, 5),
    (3, 6),
    (4, 7),
    (4, 8),
    (5, 9),
    (5, 10),
    (6, 11),
    (6, 12)
);
