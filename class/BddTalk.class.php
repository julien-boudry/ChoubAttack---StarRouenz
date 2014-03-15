<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

class BddTalk
{

	private $_bdd ;


	// Construct
	public function __construct ()
	{
		$this->_bdd = new Bdd () ;
	}


	// Ajout d'un score
	public function add_score ($demande)
	{
		$mode = FALSE ;

		// Supprime les autres scores en instances <=
		$sql_u =
		"
			UPDATE `scores` SET `ETAT`= 'OLD' WHERE `EMAIL` = :email AND `SCORE` <= :score AND `ETAT` != 'OK' AND `ETAT` != 'OLD' ;
		" ;
		// Compte 
		$sql_c =
		"
			SELECT COUNT(`ID`) from `scores` WHERE `EMAIL` = :email AND `SCORE` >= :score AND `ETAT` != 'OLD';
		" ;
		$sql_i =
		'
			INSERT INTO `scores` ( `EMAIL`, `SCORE`, `IP`, `ETAT` )
			VALUES ( :email, :score, :ip, :etat ) ;
		' ;


		$this->_bdd->prepare($sql_u);
		$this->_bdd->prepare($sql_c);
		$this->_bdd->prepare($sql_i);


		$param_u = array	(
							'email'		=> $demande['email'],
							'score'		=> $demande['score']
							) ;
		$param_c = array	(
							'email'		=> $demande['email'],
							'score'		=> $demande['score']
							) ;
		$param_i = array	(
							'email'		=> $demande['email'],
							'score'		=> $demande['score'],
							'ip'		=> $_SERVER["REMOTE_ADDR"],
							'etat'		=> $demande['etat']
						) ;



		// Perime les anciens scores plus faibles
		$this->_bdd->requete ($sql_u, array('prepare' => TRUE), $param_u) ;


		$test_c = $this->_bdd->requete ($sql_c, array('traitement' => 'NUM', 'prepare' => TRUE, 'mode' => 'var'), $param_c) ;

		IF ($test_c == 0)
		{
			$mode = TRUE ;

			$this->_bdd->requete ($sql_i, array('prepare' => TRUE), $param_i) ;
		}


		// Si return TRUE, c'est que le score a été updaté
		return $mode ;
	}
	
	public function validate_code ($code)
	{
	
		$sql_g =	"
					SELECT `EMAIL` from `scores`
					WHERE `ETAT` = :code ;
					" ;					
		$sql_u =	"
					UPDATE `scores`
					SET `ETAT` = 'OK'
					WHERE `ETAT` = :code ;
				" ;
		$sql_d =	"
					UPDATE `scores`
					SET `ETAT` = 'OLD'
					WHERE `EMAIL` = :email
					AND `ETAT` = 'OK' ;
				" ;					
		$param = array	(
							'code'	=> $code
						) ;


		$email = $this->_bdd->requete ($sql_g, array('prepare'=>TRUE, 'traitement' => 'NUM', 'mode' => 'var'), $param) ;

		if ( $email )
		{
			$this->_bdd->requete ($sql_d, array('prepare' => TRUE), array('email' => $email)) ;
		}


		$this->_bdd->requete ($sql_u, array('prepare'=>TRUE), $param) ;
	}
	
	public function calc_leaderboard ()
	{
	
		$sql =	"SELECT `EMAIL`, `SCORE` from `scores`
				WHERE `ETAT` = 'OK'
				ORDER BY `SCORE` DESC
				;
				" ;

		return $this->_bdd->requete ($sql, array('traitement' => 'NUM')) ;
		
	}

	public function add_play ()
	{	
		$sql =	"
					INSERT INTO `play` ( `IP` )
					VALUES ( '".$_SERVER["REMOTE_ADDR"]."' );
				" ;

		$this->_bdd->requete ($sql) ;		
	}

    public function count_play ()
    {
        $sql = 'SELECT COUNT(`ID`) from `play` ;';

		return $this->_bdd->requete( $sql, array('traitement' => 'NUM', 'mode' =>'var') ) ;
    }

    public function infos_player ($email)
    {
        
		// Infos de base

		$sql_g =	"
					SELECT `ID`, `SCORE`, UNIX_TIMESTAMP(`DATE`) AS 'DATE' from `scores`
					WHERE `ETAT` = 'OK'
					AND `EMAIL` = :email
					;
					" ;	


		$infos = $this->_bdd->requete ($sql_g, array('prepare' => TRUE, 'mode' => 'fetch', 'traitement' => 'ASSOC'), array('email' => $email)) ;
		
		// Cas où le joueur demandé n'existe pas
		if ($infos === FALSE) : return array('etat' => false, 'infos' => 'Ce joueur n\'existe pas') ; endif ;


		// Classement

		$classement = $this -> calc_leaderboard ();

		foreach ($classement as $cle => $element)
		{
			if ($element[0] === $email)
			{
				$infos['class'] = $cle + 1 ;

				break ;
			}
		}

		$infos['ply_nbr']	= count($classement);
		$infos['nom']		= get_nom($email);
		$infos['promo']		= get_promo($email);
		$rang 				= calc_rang($infos['class'],$infos['ply_nbr'],$infos['SCORE']);
		$infos['rang']		= $rang['titre'];
		$infos['image']		= 'http://games.star-rouenz.fr/view/img_rank/'.$rang['img'];
		$infos['desc'] 		= $rang['description'] ;

		$infos['etat'] 		= true ;


		// retour final

        return $infos;
    }
	
}