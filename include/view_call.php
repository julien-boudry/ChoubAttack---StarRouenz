<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }



	if ( isset($_POST['pagination']) && ctype_digit($_POST['pagination']) )
	{
		if ( isset($_POST['looking']) )
		{
			the_leaderboard ($_POST['pagination'], $_POST['looking']);
		}
		else
		{
			the_leaderboard ($_POST['pagination']);
		}
	}
	else
	{
		require 'view/score.php' ;
	}