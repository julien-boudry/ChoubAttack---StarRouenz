<?php

/*
	API for the Star Rouen'z Choub'Attack game

	By Julien Boudry - MIT LICENSE (Please read LICENSE.txt) -- 2014
	https://github.com/julien-boudry/Star-Rouenz---Choub-Attack_API 
*/

// Sécurisation
define('SECU_FILE', TRUE);

///////////////////////


$imperatif = NULL ;

	// Config
	
		require 'config.php' ;
	
	// Fonctions && Class
	
		require 'include/functions.php' ;
		
		// Chargement automatique des classes	

			require_once 'class/phpmailer/PHPMailerAutoload.php' ;	
			
			spl_autoload_register('chargerClasse') ; // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

	
	// Aiguillage API vs WEB
	
		// Appel API
		if ( 
				isset( $_GET['route'] ) &&
				$_GET['route'] == 'API'
			)
			
		{
			$api = new ApiCall () ;
		}
		
		// Validation du code
		elseif	( 
						isset($_GET['route'] ) &&
						$_GET['route'] === 'VALIDATE' &&
						!empty( $_GET['code'] ) &&
						strlen($_GET['code']) == 56 &&
						ctype_alnum($_GET['code']) &&
						!empty( $_GET['player'] )
				)			
		{			
			$validate = new BddTalk () ;
			$validate->validate_code( $_GET['code'] ) ;
			

			header("Location: ".BREVET_URL.$_GET['player']);
			exit();
		}

		elseif 	( 
				isset( $_GET['route'] ) &&
				$_GET['route'] == 'DEBUG'
				)
			
		{
			require 'view/debug.php' ;	
		}
		
		// Affichage Web
		else		
		{		
			require 'include/view_call.php' ;		
		}

?>