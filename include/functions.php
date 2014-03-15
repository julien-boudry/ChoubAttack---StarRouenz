<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

	function chargerClasse($class)
	{
	  require 'class'.DIRECTORY_SEPARATOR. $class . '.class.php'; // On inclut la classe correspondante au paramètre passé.
	} 

	
// Envoi du mail de confirmation
	function send_confirm_mail	 ($mode, $player, $score, $code = NULL)
	{

		// Destinataire
		$to = $player.'@students.rouenbs.fr' ;

		// Instanciation PHPmailer
		$mail = new PHPmailer() ;

		// Conf php Mailer
		$mail->From = CONTACT ;
   		$mail->FromName = "Star Rouen'z";
     	$mail->AddAddress($to);
     	$mail->isHTML(true);  
     	$mail->CharSet = 'UTF-8';

     	// Images

		$mail->AddEmbeddedImage('mails/img/logo_srz_min.png','logo_srz', 'Logo Star Rouenz');
		$mail->AddEmbeddedImage('mails/img/ban.jpg','ban_srz', 'Bannière Star Rouen\'Z');


     	// Corps

     	include 'mails/style.php';

     	$body = '<!DOCTYPE html><html><head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.$style.'</head><body>
			<img style="max-height:200px;" src="cid:ban_srz" alt="Bannière Star Rouenz" />
			<br><br>
     	';

     	// Le mail à envoyer	
     	if ($mode === 'confirm' && $code !== NULL)
     	{
			include 'mails/confirmation.php' ;
		}
		else
		{
			include 'mails/fail.php' ;
		}

		$body .= '<br><br><img src="cid:logo_srz" alt="Star Rouen\'z"/></body></html>';


		$mail->Body = $body ;


		// Envoi du mail
		if(!$mail->send()) {
		   echo 'Message could not be sent.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;
		}		
	}

	
	function jsLibrairies($nom_librairie, $version)
	{
		IF($nom_librairie == 'jquery')
		{
			echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js"></script>' ;
		}
		
		IF($nom_librairie == 'jquery-ui')
		{
			echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/'.$version.'/jquery-ui.min.js"></script>' ;
		}
		
	}

	
// Fabrique un tableau des scores
	function the_leaderboard ($pagination = 1, $looking = NULL, $force_looking = FALSE)
	{
		// Affichage classique
	?>
	      <table border="1" id="table_score">

          <tr>
            <th>Rang</th>
			<th>Champion</th>
			<th>Promotion</th>
			<th>Score</th>
          </tr>

	<?php // Fin affichage classique
	
		$search = NULL ;
		$nbr = 10 ;
		
		$action = new BddTalk () ;		
		$data = $action->calc_leaderboard () ;
		$entry = count($data) ;

		if ($looking) // Est fourni
		{
			foreach ($data as $cle => $element)
			{

				if ($element[0] == $looking)
				{
					if ($force_looking === TRUE) {$pagination = (int) (($cle + 1) / $nbr + 1) ;}
					$search = $cle ;
				}
			}

		}
		
		// Retraitement graphique
		
		$i = 0 ; $i2 = 0 ;
		foreach ( $data as $cle => $element )
		{
		
				if ( $i < ($pagination * $nbr) && $i >= ( ($pagination - 1) * $nbr) )
				{
					if ( $cle === $search ) {$select = 'style="color:#32BEEB;"';}
					else {$select = NULL;}

					$link = '<a href="'.BREVET_URL.htmlspecialchars($element[0]).'" target="_parent">' ;

					$tab[] = 
					'<tr id="c-row-'.$cle.'" '.$select.'>
					
						<td>'.$link.($cle + 1).'</a></td>
						<td>'.$link.htmlspecialchars(get_nom($element[0])).'</a></td>
						<td>'.htmlspecialchars(get_promo($element[0])).'</td>
						<td>'.$link.$element[1].'</a></td>
					
					</tr>' ;
					
					$i2++;
				}
			
			$i++ ;
		}

		if (isset($tab))
		{
			$tab = array_reverse($tab);

			foreach ($tab as $element)
			{
				echo $element ;
			}
		}


		// Reprise affichage classique
	?>
	      </table>
	  
	  <?php IF ($pagination > 1) { ?> <span class="pagination" id="previous" onclick="banane(<?php echo ($pagination - 1).',\''.$looking.'\''; ?>)">Précédent</span> <?php } ?>
	  <?php IF ( $entry > ($pagination * $nbr) ) { ?> <span class="pagination" id="next" onclick="banane(<?php echo ($pagination + 1).',\''.$looking.'\''; ?>)">Suivant</span> <?php } ?>

	 <div id="refresh-box" onclick="banane(<?php echo ($pagination).',\''.$looking.'\''; ?>)">
	 	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
			<g id="Captions">
			</g>
			<g id="Refresh">
				<path id="refresh-3-icon" d="M78.398,22.521l-9.023,9.024c-4.901-4.899-11.668-7.93-19.146-7.93   c-14.952,0-27.074,12.127-27.074,27.079c0,0.003,0-0.004,0,0h10.518l-16.8,16.794L0.092,50.695h10.299c0-0.001,0,0.002,0,0   c0-22.001,17.837-39.843,39.838-39.843C61.23,10.852,71.19,15.311,78.398,22.521z M99.908,49.306L83.126,32.511L66.327,49.306   h10.518c0,0.003,0-0.006,0,0c0,14.951-12.124,27.079-27.075,27.079c-7.475,0-14.245-3.03-19.145-7.93L21.6,77.479   c7.21,7.211,17.169,11.67,28.17,11.67c22.002,0,39.838-17.841,39.838-39.843c0-0.002,0,0.001,0,0H99.908L99.908,49.306z"/>
			</g>
		</svg>
	</div>
	  
	<?php		
	}


function validate_rouen_email ($input)
{

	$test = explode('.', $input) ;

	if (
			count($test) === 3 &&
			ctype_digit($test[2])
		)
	{
		return TRUE ;
	}
	else 
	{
		return FALSE ;
	}
}

function is_email_blacklist( $email )
{
global $blacklist_email ;

	return in_array($email, $blacklist_email, TRUE) ;
}


function get_nom ($input)
{
	$data = explode('.', $input) ;

	return ucfirst($data[0]) . ' ' . ucfirst($data[1]) ;
}

function get_prenom ($input)
{
	$data = explode('.', $input) ;

	return ucfirst($data[0]) ;
}

function get_promo ($input)
{
	$data = explode('.', $input) ;
	
	switch ($data[2])
	{
		case 13:	return 'Padawan' ;
		case 12:	return 'Jedi' ;
		case 11:	return 'Maitre Jedi' ;
		case 10:	return 'Maitre Sith' ;
		
		default:	return 'Esprit Jedi 20'.$data[2] ;
	}

}


function calc_rang($class,$nbr_class,$score)
{
	global $rangs ;

	// Test naturel

	$i_s = -1 ;
	foreach ($rangs as $cle => $element)
	{
		if ($element['min'] <= $score && $i_s < $element['min'] && empty($element['rank']) )
		{
			$result = $cle ;
			$i_s = $element['min'] ;
		}
	}

	// Test de primauté

	foreach ($rangs as $cle => $element)
	{
		if (in_array($class, $element['rank']))
		{
			$result = $cle ;

			break ;
		}
	}

	// Synthèse et retour

	if (!isset($result)) {$result = 1 ;} ;

	return $rangs[$result] ;
}