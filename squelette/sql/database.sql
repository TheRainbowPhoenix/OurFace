drop table vote ;
drop table tweet ;
drop table post ;
drop table utilisateur ;

CREATE TABLE utilisateur (
 id SERIAL ,
 identifiant VARCHAR(45) NULL ,
 pass VARCHAR(45) NULL ,
 nom VARCHAR(45) NULL ,
 prenom VARCHAR(45) NULL ,
 date_de_naissance TIMESTAMP NULL ,
 statut VARCHAR(100) NULL ,
 avatar VARCHAR(200) NULL ,
 PRIMARY KEY (id) );


CREATE TABLE post (
 id SERIAL ,
 texte VARCHAR(140) NOT NULL ,
 date TIMESTAMP NOT NULL ,
 image VARCHAR(200) NULL ,
 PRIMARY KEY (id) );


CREATE TABLE tweet (
 id SERIAL ,
 emetteur INT NULL ,
 parent INT NULL,
 post INT NULL ,
 nbVotes INT NULL,
 PRIMARY KEY (id) ,
 CONSTRAINT fk_message_utilisateur1
 FOREIGN KEY (emetteur )
 REFERENCES utilisateur (id )
 ON DELETE NO ACTION
 ON UPDATE NO ACTION,
 CONSTRAINT fk_message_post1
 FOREIGN KEY (post )
 REFERENCES post (id )
 ON DELETE NO ACTION
 ON UPDATE NO ACTION);

CREATE TABLE vote (
 id SERIAL ,	
 utilisateur INT,
 message INT,
 PRIMARY KEY (id) );
  

