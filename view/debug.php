<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

// $test = new Bdd () ;

// $sql_g =	"
// 			SELECT `EMAIL` from `scores`
// 			WHERE `ETAT` = 'fgh' ;
// 			" ;					
// $sql_u =	"
// 			UPDATE `scores`
// 			SET `ETAT` = 'OK'
// 			WHERE `ETAT` = :code ;
// 		" ;					
// $param = array	(

// 				) ;

// $email = $test->requete ($sql_g, array('prepare'=>TRUE, 'traitement' => 'NUM', 'mode' => 'var'), $param) ;

// var_dump($email) ;