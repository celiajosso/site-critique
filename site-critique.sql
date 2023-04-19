/* table Image */

CREATE TABLE Image (
  id_Image INT NOT NULL AUTO_INCREMENT,
  chemin_Image varchar(100) NOT NULL,
  PRIMARY KEY (id_Image)    
);

INSERT INTO Image (chemin_Image) VALUES
("Images/Jeu/1/gameplay.jpg"),
("Images/Jeu/1/jaquette.jpg"),
("Images/Jeu/2/gameplay.jpg"),
("Images/Jeu/2/jaquette.jpg"),
("Images/Jeu/3/gameplay.jpg"),
("Images/Jeu/3/jaquette.jpg"),
("Images/Jeu/4/gameplay.jpg"),
("Images/Jeu/4/jaquette.jpg"),
("Images/Jeu/5/gameplay.jpg"),
("Images/Jeu/5/jaquette.jpg"),
("Images/Jeu/6/gameplay.jpg"),
("Images/Jeu/6/jaquette.jpg");

/* table Jeu */

CREATE TABLE Jeu (
  id_Jeu INT NOT NULL AUTO_INCREMENT,
  nom varchar(30) NOT NULL,
  prix FLOAT NOT NULL,
  date_sortie DATE NOT NULL,
  synopsis varchar(300),
  PRIMARY KEY (id_Jeu)    
);

INSERT INTO Jeu (nom, prix, date_sortie, synopsis) VALUES
("Fifa 21","12.36","2020-08-14","FIFA 21 est un jeu vidéo de football développé par EA Canada et EA Roumanie et édité par EA Sports"),
("World of Warcraft","14.99","2004-11-23","Le jeu reprend place dans le monde imaginaire d'Azeroth, et dont le cadre historique se situe quatre ans après les évènements concluant Warcraft III . Le joueur choisit son personnage parmi huit, dix ou douze races disponibles divisées en deux factions : l'Alliance et la Horde."),
("Minecraft","20.00","2011-11-18","Minecraft plonge le joueur dans un monde créé de manière procédurale, composé de voxels (des cubes) représentant différents matériaux comme de la terre, du sable, de la pierre, de l'eau, de la lave ou des minerais (du fer, de l'or, du charbon, etc. ) formant diverses structures (arbres, cavernes, montagnes, temples)."),
("Grand Theft Auto 5","19.99","2013-09-17","L'histoire solo suit trois protagonistes : le braqueur de banque à la retraite Michael De Santa, le gangster Franklin Clinton et le trafiquant de drogue et d'armes Trevor Philips, et leurs braquages sous la pression d'une agence gouvernementale corrompue et de puissants criminels."),
("Just Dance 22","26.54","2021-11-04","Just Dance 2023 Edition est un jeu de rythme et de danse développé par Ubisoft Paris et édité par Ubisoft."),
("Rocket League","00.00","2015-07-07","Deux équipes, composées de un à quatre joueurs conduisant des véhicules, s'affrontent au cours d'un match afin de frapper un ballon et de marquer dans le but adverse. Les voitures sont équipées de propulseurs (boost) et peuvent sauter, permettant de jouer le ballon dans les airs.");

/* table Role */

CREATE TABLE Role (
  id_Role INT AUTO_INCREMENT,
  nom_Role VARCHAR(50),
  PRIMARY KEY (id_Role)
);

INSERT INTO Role (nom_Role) VALUES
    ('Membre'),
    ('Rédacteur'),
    ('Administrateur');

/* table Categorie */

CREATE TABLE Categorie (
  id_Categorie INT AUTO_INCREMENT,
  nom_Categorie VARCHAR(50),
  PRIMARY KEY (id_Categorie)
);

INSERT INTO Categorie (nom_Categorie) VALUES
    ('Course'),
    ('RPG'),
    ('Sport'),
    ('Sandbox'),
    ('Autres');

/* table Support */

CREATE TABLE Support (
  id_Support INT AUTO_INCREMENT,
  nom_Support VARCHAR(50),
  PRIMARY KEY (id_Support)
);

INSERT INTO Support (nom_Support) VALUES
    ('PS'),
    ('Switch'),
    ('PC'),
    ('Xbox'),
    ('Wii'),
    ('Autres');

/* table Utilisateur */

CREATE TABLE Utilisateur (
  id_Utilisateur INT AUTO_INCREMENT,
  login_Utilisateur VARCHAR(50),
  password_Utilisateur VARCHAR(50),
  photoProfil_Utilisateur VARCHAR(50),
  nom_Utilisateur VARCHAR(50),
  prenom_Utilisateur VARCHAR(50),
  mail_Utilisateur VARCHAR(50),
  dateNaissance_Utilisateur DATE,
  dateCreation_Utilisateur DATE,
  dateConnexion_Utilisateur DATETIME,
  id_Role INT,
  PRIMARY KEY (id_Utilisateur),
  FOREIGN KEY (id_Role) REFERENCES Role(id_Role)
);

INSERT INTO Utilisateur (login_Utilisateur, password_Utilisateur, photoProfil_Utilisateur, nom_Utilisateur, prenom_Utilisateur, id_role, mail_Utilisateur, dateNaissance_Utilisateur, dateCreation_Utilisateur, dateConnexion_Utilisateur) VALUES
    ("prannou", "prof_de_SR", "Images/PhotoProfil/1.png", "RANNOU", "Phillipe", 2, "prannou@gmail.com", "1988-02-16", "2022-04-01", "2023-04-15 16:00:02"),
    ("rmounier", "prof_de_BDD", "Images/PhotoProfil/2.png", "MOUNIER", "Romain", 3, "rmounier@gmail.com", "1991-07-03", "2021-09-07", "2023-04-02 15:23:59"),
    ("hfeuillatre", "prof_de_IHM", "Images/PhotoProfil/3.png", "FEUILLATRE", "Hélène", 3, "hfeuillatre@gmail.com", "1991-05-28", "2021-01-01", "2023-04-17 09:12:32"),
    ("fthibault", "prof_de_physique", "Images/PhotoProfil/4.png", "THIBAULT", "Franck", 2, "fthibault@gmail.com", "1965-05-28", "2022-08-08", "2023-01-06 20:06:48"),
    ("olafond", "prof_delectronique", "Images/PhotoProfil/5.png", "LAFOND", "Olivier", 1, "olafond@gmail.com", "1973-01-19", "2023-03-03", "2023-04-10 14:03:15"),
    ("vbouquet", "prof_de_chimie", "Images/PhotoProfil/6.png", "BOUQUET", "Valérie", 1, "vbouquet@gmail.com", "1973-10-12", "2023-02-16", "2023-04-01 19:02:47");

/* table Article */

CREATE TABLE Article (
  id_Article INT AUTO_INCREMENT,
  titre_Article VARCHAR(100),
  dateCreation_Article DATE,
  dateModification_Article DATE,
  contenu_Article VARCHAR(2000),
  noteRedacteur_Article INT,
  id_Jeu INT,
  id_UtilisateurCreateur INT,
  id_UtilisateurModifieur INT,
  PRIMARY KEY (id_Article),
  FOREIGN KEY (id_jeu) REFERENCES Jeu(id_Jeu),
  FOREIGN KEY (id_UtilisateurCreateur) REFERENCES Utilisateur(id_Utilisateur),
  FOREIGN KEY (id_UtilisateurModifieur) REFERENCES Utilisateur(id_Utilisateur)
);

INSERT INTO Article (titre_Article, dateCreation_Article, dateModification_Article, id_Jeu, id_UtilisateurCreateur, contenu_Article, noteRedacteur_Article) VALUES
    ('Jouer au football sans les ligaments croisés ? Fifa 21 est la solution !', '2023-03-04', NULL, 1, 3, "On ne va pas vous faire marronner des heures en ménageant un faux suspense : ce n'est pas en pleine période de transition vers la next-gen qu'il faut attendre une métamorphose de FIFA ère Frostbite. En place depuis FIFA 17, le moteur de jeu partagé par tout EA a bien été tweaké au fil des saisons, sans parvenir à trouver un équilibre vraiment satisfaisant. Oh, FIFA 21 continuera peut-être d'assurer le service minimum pour les fans de foot en manque de tribunes, mais si vous étiez déjà fatigués de FIFA 20, cette édition s'annonce du même tonneau. En attendant les innombrables patchs qui rendront peut-être ce test caduc dans quelques semaines, autant résumer la situation : FIFA 21 corrige quelques aberrations du précédent, mais il en préserve la philosophie. Parés pour les explications ?", 7),
    ('Possédez-vous des pouvoirs magiques ? World of Warcraft à votre service !', '2022-10-10', NULL, 2, 2, "World of Warcraft est un des MMORPG qui rend les joueurs addictifs, et ça se comprend ! Les possibilités sont multiples, il y a tellement de choses à faire sur Azeroth et en Outre-terre ! Mais malheureusement, on comprend vite pourquoi ce jeu est si addictif : Il est affreusement répétitif : Pour avoir X ou Y armure, il va falloir passer du temps à dégommer des joueurs ennemis ou des monstres dans les donjons. Au final, on consacre enormément de temps sur WoW, pour pas grand chose. Outre le fait qu'il soit répétitif, l'histoire de World of Warcraft, ou plutôt celle de Warcraft en général est extrêmement bien conçue, ce qui rend le contexte très immersif. Le jeu de rôle sur World of Warcraft est un des meilleurs à ce jour, et c'est, pour moi, l'avantage majeur de ce jeu.", 8),
    ('Créez votre propre monde avec Minecraft !', '2022-05-12', NULL, 3, 4, "Minecraft, le jeu au succès rebondissant, est rentré dans les meilleurs jeux dès sa sortie sur Nintendo Switch : 21 juin 2018. Le jeu est rentré dans le top 10 du classement sur Nintendo Switch la première journée de sa sortie. Des bugs sont fréquents à l'entrée de nouvelles versions, mais les ajouts sont majeurs de par la 1.17. Ma note a 2 points en dessous de la note maximale, pourquoi ? D'abord, la communauté ne manque pas d'inspiration, des centaines de pack (de textures, maps, skins, mods, ajouts incroyables) sont ajoutés chaque semaine dans le magasin. Ensuite, Mojang, les créateurs du jeu, sont passés de mises à jours chaque semaine à une demi-année. Avant la 1.14, Mojang n'avait plus de joueurs sur Minecraft à cause du manque de mises à jours et d'ajouts, mais à partir de cette version, le jeu à été totalement différent : de nouveaux mobs ont été ajoutés au jeu, Minecraft avait changé. Les anciens joueurs/joueuses ont commencer à rejouer à ce jeu, malgré les bugs toujours présents. Voilà ma critique, résumé final : pour ceux qui aime la création, l'action, l'aventure et parfois du WTF (sur les mods), acheter-le si ce n'est pas déjà fait !", 7),
    ("Avez-vous déjà braqué une banque ? Avec GTA c'est légal !", '2021-12-12', NULL, 4, 3, "Rarement un jeu aura autant cristallisé les passions que Grand Theft Auto V. D'un côté la flamme des joueurs, sevrés de vrai GTA depuis plusieurs années, malgré les prestations très honorables de la concurrence. De l'autre la poudre aux yeux d'une machine marketing parfaitement huilée, jusqu'à contrôler la moindre parcelle d'information comme si elle était classée Secret Défense. Après plusieurs mois d'attente, on sait enfin ce que vaut le dernier GTA de sa génération.", 9),
    ('Faites de votre salon un Dance Floor avec Just Dance !', '2022-06-04', NULL, 5, 1, "Just Dance 2022 se différencie des autres jeux de la licence, par la grande qualité de réalisation des différentes danses. En effet Ubisoft ont voulu passer un cap avec un rendu visuel absolument remarquable, des effets de caméras à foison, des coachs très variés (stop motion, 3D, back dancers...) et des styles visuels très hétérogènes et inspirés. Le rendu parait plus mature, voir presque cinématographique. D'ailleurs c'est la première fois que l'on discerne clairement les expressions faciales des coachs aussi clairement, ce qui rajoute beaucoup de vie au jeu. Le jeu fournit 40 nouvelles danses piochant dans plusieurs répertoires (actuel, rétro, kpop, et worldmusic). En ce qui concerne les chorégraphies, tout le monde peut s'y retrouver, il y a du très facile, comme du difficile et du très difficile (avec les versions extrêmes des danses). En ce qui concerne les bémols, on regrettera le manque de nouveau mode. Le online est toujours un peu timide. Pour ce qui est du mode Kids, il ne faut pas s'attendre à du nouveau car ce sont exactement les mêmes danses que dans les précédents Just Dance. Et enfin le mode Quick play reste le même que l'année dernière, ce mode lance une playlist de danse prédéfinit par la console. On retiendra ce Just Dance surtout pour la qualité de réalisation des danses, et j'ai envie de dire tant mieux car c'est la sève du jeu. On souhaitera pour le prochain opus de nouveaux challenges et modes.", 6),
    ('Un Football en voiture ? Tout est possible avec Rocket League !', '2023-04-04', NULL, 6, 2, "Rocket League est l'exemple même d'un bon jeu vidéo ! Une durée de vie inépuisable, du fun, de la tension et des actions épiques à chaque parties, toujours quelqu'un en ligne, une tonne de bonus à débloquer... FONCEZ ! Dès règles simples, il s'agit ni plus ni moins d'un jeu de football en arène fermées... avec des voitures ! Le tout est rythmée par un boost que l'on remplit avec les bonus au sol et un double saut qui permet de se projeter dans toutes les directions et même de voler. Rajoutez à cela la force de la coopération en équipe... et les exploits individuels possibles. Les graphismes sont superbes (Unreal Engine), c'est fluide, c'est beau bref juste ce qu'il faut. Ce jeu est addictif à souhaits ! A la fin d'une partie on a toujours envie de relancer la suivante et ce n'est pas prêt de s'arrêter !", 8);

/* table Avis */

CREATE TABLE Avis (
  id_Avis INT AUTO_INCREMENT,
  titre_Avis VARCHAR(100),
  contenu_Avis VARCHAR(500),
  dateCreation_Avis DATE,
  note_Avis INT,
  id_Utilisateur INT,
  id_Jeu INT,
  PRIMARY KEY (id_Avis),
  FOREIGN KEY (id_Utilisateur) REFERENCES Utilisateur(id_Utilisateur),
  FOREIGN KEY (id_Jeu) REFERENCES Jeu(id_Jeu)
);

/* table est_Categorie */

CREATE TABLE est_Categorie (
  id_Jeu INT,
  id_Categorie INT,
  PRIMARY KEY (id_Jeu, id_Categorie),
  FOREIGN KEY (id_Jeu) REFERENCES Jeu (id_Jeu),
  FOREIGN KEY (id_Categorie) REFERENCES Categorie (id_Categorie)
);

INSERT INTO est_Categorie (id_Jeu, id_Categorie) VALUES
    (1, 2),
    (1, 3),
    (2, 2),
    (2, 4),
    (3, 4),
    (4, 1),
    (5, 3),
    (6, 1),
    (6, 3);

/* table est_Support */

CREATE TABLE est_Support (
  id_Jeu INT,
  id_Support INT,
  PRIMARY KEY (id_Jeu, id_Support),
  FOREIGN KEY (id_Jeu) REFERENCES Jeu (id_Jeu),
  FOREIGN KEY (id_Support) REFERENCES Support (id_Support)
);

INSERT INTO est_Support (id_Jeu, id_Support) VALUES
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
    (6, 4);

/* table est_Image */

CREATE TABLE est_Image (
  id_Article INT,
  id_Image INT,
  PRIMARY KEY (id_Article, id_Image),
  FOREIGN KEY (id_Article) REFERENCES Article (id_Article),
  FOREIGN KEY (id_Image) REFERENCES Image (id_Image)
);

INSERT INTO est_Image (id_Article, id_image) VALUES
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
    (6, 12);
