<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

/////////////////////////////////////////////////////

/* Class de gestion PDO - Julien Boudry : V. 0.4 RC1 */ 

class Bdd
{
	private $_connect_state = FALSE ;
	private $_bdd ;
	private $_stock_prepare ;	

		public function __construct ()
		{
			$this->_stock_prepare = array() ;
		}		
	
	// SCRIPT DE CONNEXION
		private function connect ()
		{
			$pdo_options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ) ;

			$base = BDD_TYPE . ':host=' . BDD_HOST . ';dbname=' . BDD_NAME ;

			try
			{
				$this -> _bdd = new PDO($base, BDD_USER, BDD_PASSWD, $pdo_options);	
			}
			catch (Exception $e)
			{
					die('Erreur : ' . $e->getMessage());		
			}
			
			$this -> _connect_state = TRUE ;
		}
		
		private function need_connect ($do = TRUE)
		{
			IF ($do === TRUE)
			{
				IF ($this->_connect_state === FALSE)
				{
					$this->connect() ;
					
					return TRUE ;
				}
				ELSE { return FALSE ; }
			}
			ELSE
			{ return $this->_connect_state ; }
		}
	
	
	// Requête simple
	public function requete ($requete, array $type = NULL, $param = NULL)
	{	
		$this->need_connect();

		$requete = trim($requete);
		
		IF ( !isset($type['prepare']) || $type['prepare'] !== TRUE ) // cas DO
		{
			$for_exec = array('INSERT','UPDATE','DELETE','insert','update','delete');

			IF ( array_search(substr($requete,0,6),$for_exec) !== FALSE )
			{
				$ex_mod = 'exec';

				$result = $this -> _bdd -> exec($requete) ;
			}
			else
			{
				$ex_mod = 'query';

				$result = $this -> _bdd -> query($requete) ;
			}
		}
		
		ELSE // Cas PREPARE
		{
			$ex_mod = 'execute';

			$this -> stock_prepare($requete) ;
			
			$cle = $this->test_stockage_prepare($requete) ;
			
			$this->_stock_prepare[$cle]['prepare_object'] -> execute($param) ;
			$result = $this->_stock_prepare[$cle]['prepare_object'] ;	
		}
		
		// Traitement erreur
		IF ( $result === FALSE )
		{
			trigger_error('Requête invalide') ;
			return $result ;
		}
		
		IF ( !isset($type['traitement']) || $type['traitement'] == FALSE ) { $traitement = 'PDO::FETCH_BOTH' ; } ELSE { $traitement = 'PDO::FETCH_' . $type['traitement'] ; }
		
		
		// Détermination du traitement final (fetch)
		IF ($ex_mod == 'exec')
		{
			return $result ;
		}
		ELSEIF (!isset($type['mode']) || $type['mode'] == 'fetchAll')
		{
			return $result -> fetchAll( constant ( $traitement )  ) ;
		}
		ELSEIF ($type['mode'] == 'fetch')
		{
			return $result -> fetch( constant ( $traitement )  ) ;
		}
		ELSEIF ($type['mode'] == 'var')
		{
			return $result -> fetchColumn() ;
		}
		ELSE
		{
			return $result -> $type['mode']() ;
		}
	}
	
		private function stock_prepare ($requete)
		{
			IF ( $this->test_stockage_prepare($requete) === FALSE )
			{
				$this->_stock_prepare[] = array	(
													'requete'			=> $requete,
													'prepare_object'	=> $this -> _bdd -> prepare($requete)
												);											
			}
		}
	
		private function test_stockage_prepare ($requete)
		{
			$is_stock = FALSE ;
				
				FOREACH ($this->_stock_prepare as $cle => $element)
				{
					IF ( $element['requete'] === $requete )
					{
						$is_stock = $cle ; 
						break ;
					}
				}
			
			return $is_stock ;
		}
		
	// Cas où l'on prepare juste une requête future
	public function prepare ($requete)
	{
		$this -> need_connect();
		
		$this -> stock_prepare($requete) ;
	}
}