<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

// ------------------------------------------------------------------------------------------------


// HTTP header

	// UTF 8
	header('Content-Type: text/html; charset=utf-8') ;
	// Cross-domain
	header("Access-Control-Allow-Origin: *");


// DB

// Configuration BDD

	define ('BDD_TYPE', 'mysql') ; // RENSEIGNER LE TYPE DE BDD : MYSQL, MARIADB, PostgreSQL.
	define ('BDD_HOST', 'localhost') ; // RENSEIGNER L'ADRESSE DU SERVEUR DE BDD
	define ('BDD_NAME', 'star-game') ; // RENSEIGNER LE NOM DE LA BDD.
	define ('BDD_USER', 'root') ; // RENSEIGNER L'IDENTIFIANT DE CONNEXION (UTILISATEUR)
	define ('BDD_PASSWD', '') ; // RENSEIGNER LE MOT DE PASSE DE LA BDD.
	
	
// VERSION DES LIBS JS DESIREES
	$config['js-libs'] = array(	'jquery' => 	'2.1.0'	);


// Titre du jeu

define ('TITRE_JEU',"Choub'Attack");

// Email de contact

define ('CONTACT','contact@star-rouenz.fr');

// Adresse base de la page brevet

define ('BREVET_URL','http://www.star-rouenz.fr/choub-attack/brevet/?player=');

// Limite anti-triche

define ('LIMIT_TRICHE',550000);
define ('SALT_TRICHE','you-need-enter-a-salt-here');

// Email blacklisté
$blacklist_email = array() ;
// $blacklist_email[] = '' ;

// Rangs

$rangs[1]['titre'] = 'Chewbacca';
$rangs[1]['min'] = 0 ;
$rangs[1]['rank'] = array(1) ;
$rangs[1]['img'] = '1.jpg' ;
$rangs[1]['description'] = 'Grand et imposant avec sa fourrure, Choubi est contrebandier, copilote du Faucon Millénium, sauveur de la Galaxie… Choubi a aujourd’hui atteint l’apogée de sa vie et est passé maître pour combattre les forces de l’Empire.' ;

$rangs[2]['titre'] = 'Maître Wookiee';
$rangs[2]['min'] = 0 ;
$rangs[2]['rank'] = array(2) ;
$rangs[2]['img'] = '2.jpg' ;
$rangs[2]['description'] = 'Un Wookiee maîtrisant la Force, ce n’est pas courant ! Pourtant, c’est le destin de Lowbacca, neveu du grand Chewbacca, qui en fait un guerrier redoutable avec les forces de l’Empire.' ;

$rangs[3]['titre'] = 'Chef Wookiee';
$rangs[3]['min'] = 0 ;
$rangs[3]['rank'] = array(3) ;
$rangs[3]['img'] = '3.jpg' ;
$rangs[3]['description'] = 'A la fois guerrier redoutable et stratège, le chef Wookiee a mené avec succès les Wookies contre les forces de l’Empire pour en faire quelqu’un de très respecté dans toute la galaxie.' ;

$rangs[10]['titre'] = 'Ninja Wookiee';
$rangs[10]['min'] = 390000 ;
$rangs[10]['rank'] = array() ;
$rangs[10]['img'] = '10.jpg' ;
$rangs[10]['description'] = 'Le Wookiee Ninja cultive une culture traditionnelle du combat très ancienne et secrète. De fait, après un entrainement très dur, ils deviennent les meilleurs combattants Wookiees existants.' ;

$rangs[4]['titre'] = 'Wookiee sauvage';
$rangs[4]['min'] = 340000 ;
$rangs[4]['rank'] = array() ;
$rangs[4]['img'] = '4.jpg' ;
$rangs[4]['description'] = 'Agressif, le Wookiee sauvage est doué pour le combat. Habitué des batailles, il voue une haine féroce à l’Empire. Néanmoins, son tempérament de feu lui joue parfois des tours.' ;

$rangs[5]['titre'] = 'Vieux Wookiee';
$rangs[5]['min'] = 260000 ;
$rangs[5]['rank'] = array() ;
$rangs[5]['img'] = '5.jpg' ;
$rangs[5]['description'] = 'Le vieux Wookiee est plein d’expérience et le montre. Redoutable pour anticiper l’adversaire, toujours puissant grâce à un entraînement régulier, il est pourtant trahi par son corps vieilli.' ;

$rangs[6]['titre'] = 'Bébé Wookiee';
$rangs[6]['min'] = 200000 ;
$rangs[6]['rank'] = array() ;
$rangs[6]['img'] = '6.jpg' ;
$rangs[6]['description'] = 'Les Wookiees développent précocement une aptitude au combat surprenante. Doté d’une grande agilité, leur manque de puissance est préjudiciable.' ;

$rangs[7]['titre'] = 'Ewok piegeur';
$rangs[7]['min'] = 150000 ;
$rangs[7]['rank'] = array() ;
$rangs[7]['img'] = '7.jpg' ;
$rangs[7]['description'] = 'Capable de grandes choses quand il vise juste, le Ewok piégeur est capable de gros dégâts mais reste incroyablement vulnérable.' ;

$rangs[8]['titre'] = 'Ewok sournois';
$rangs[8]['min'] = 100000 ;
$rangs[8]['rank'] = array() ;
$rangs[8]['img'] = '8.jpg' ;
$rangs[8]['description'] = 'Roi du camouflage, cet Ewok a une capacité à surprendre l’ennemi pour le tuer. Néanmoins, il se trouve très vite démuni quand ça ne marche pas. ' ;

$rangs[9]['titre'] = 'Ewok au bâton';
$rangs[9]['min'] = 0 ;
$rangs[9]['rank'] = array() ;
$rangs[9]['img'] = '9.jpg' ;
$rangs[9]['description'] = 'Doté de la meilleure volonté au monde, mais armé seulement d’un bâton, cet Ewok est mignon... Mais inoffensif.' ;