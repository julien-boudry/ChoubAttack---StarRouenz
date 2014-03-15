<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

class ApiCall
{
	private $_demande ;
	private $_details_erreurs ;


	// Constructeur	
	public function __construct ()
	{
	
		IF ( !$this->form_ask() )
		{
			$this -> _details_erreurs[] = "L'appel a l'API n'est pas correctement formule" ;			
			$this -> error () ;
		}
		ELSE
		{
			$this->do_action () ;
		}
	
	}
	
	
		// Test de la demande API
		private function form_ask ()
		{
			$check = TRUE ;
			
			// Tests
			
				//Type de demande
					IF ( !isset ($_GET['demande'])	)
					{
						$check = FALSE ;
					}
					ELSE
					{
						// Cas d'une soummission de score
						IF ( $_GET['demande'] == 'PUT' )
						{
							$this->_demande['methode'] = 'PUT' ;
							
							// Vérification des informations associées
							IF ( !isset ($_GET['email']) || !isset ($_GET['score']) || !isset ($_GET['secu']) )
							{
								$check = FALSE ;
							}
							ELSE
							{
							
								//Email
								IF ( !validate_rouen_email( strtolower($_GET['email']) ) )
								{$check = FALSE ; $this->_details_erreurs[] = "Ce format d'adresse mail n'est pas valide" ;}
								ELSE
								{
									$this->_demande['email'] = strtolower($_GET['email']) ;
								}

									// Email Blacklist
									IF ( is_email_blacklist($this->_demande['email']) )
									{$check = FALSE ; $this->_details_erreurs[] = "Cet email est interdit" ;}

								
								//Score
								IF ( !ctype_digit($_GET['score']) || $_GET['score'] > LIMIT_TRICHE )
								{$check = FALSE ; $this->_details_erreurs[] = "Tricheur !" ;}
								ELSE
								{
									$this->_demande['score'] = $_GET['score'] ;
								}
								
								// Secu

								IF ($check === TRUE)
								{
									$hash_data = $this->_demande['email'] . $this->_demande['score'] . SALT_TRICHE ;

									IF ( $_GET['secu'] !== hash('sha256', $hash_data) && $check !== FALSE )
									{$check = FALSE ; $this->_details_erreurs[] = "Tricheur crypto ?" ;}
								}
							}
	
						}

						// Ajout d'une parties
						ELSEIF ( $_GET['demande'] == 'ADD' )	
						{
							$this->_demande['methode'] = 'ADD' ;
						}

						// COUNT Parties
						ELSEIF ( $_GET['demande'] == 'COUNT' )	
						{
							$this->_demande['methode'] = 'COUNT' ;
						}	

						// Timestamp (millisecondes)
						ELSEIF ( $_GET['demande'] == 'TIME' )	
						{
							$this->_demande['methode'] = 'TIME' ;
						}

						// Infos brevet
						ELSEIF ( $_GET['demande'] == 'PLAYER' )	
						{
							// Vérification des informations associées
							if ( empty($_GET['player']) || !validate_rouen_email($_GET['player']) )
							{
								$check = FALSE ; $this->_details_erreurs[] = "informations en get incorrecte" ;
							}
							else
							{
								$this->_demande['methode']	= 'PLAYER' ;
								$this->_demande['email']	= strtolower($_GET['player']) ;
							}
						}			
						
						ELSE
						{
							$check = FALSE ;
						}
					}
						
			
			// Retour du resultant
				return $check ;
		}
	
	
	// Réponse (Aiguillage)
	private function do_action ()
	{
			$action = new BddTalk () ;			
			
			IF ($this->_demande['methode'] == 'PUT')
			{
							// Session code
							$octects = 125 ;
							$fort = TRUE ;
				$this->_demande['etat'] = hash( 'sha224', bin2hex( openssl_random_pseudo_bytes($octects, $fort) ) ) ;
				
				
				// Envoi du mail de confirmation
				if ($action->add_score ($this->_demande) === TRUE)
				{
					send_confirm_mail ('confirm', $this->_demande['email'], $this->_demande['score'], $this->_demande['etat']) ;

					echo json_encode ( array('etat' => TRUE) ) ;
				}
				else
				{
					send_confirm_mail ('negative', $this->_demande['email'], $this->_demande['score']) ;

					echo json_encode ( array('etat' => 'Score faible') ) ;
				}				

			}

			ELSEIF ($this->_demande['methode'] == 'ADD')
			{
				$action->add_play();

				echo json_encode ( array('etat' => TRUE) ) ;
			}


			ELSEIF ($this->_demande['methode'] == 'COUNT')
			{
				echo $action->count_play();
			}

			ELSEIF ($this->_demande['methode'] == 'TIME')
			{
				echo time();
			}

			ELSEIF ($this->_demande['methode'] == 'PLAYER')
			{
				echo json_encode( $action->infos_player($this->_demande['email']) );
			}
			
	}
	
	// Erreur
	private function error () 
	{
		echo json_encode ( array('etat' => FALSE, 'liste_erreurs' => $this->_details_erreurs) ) ;
	}

}