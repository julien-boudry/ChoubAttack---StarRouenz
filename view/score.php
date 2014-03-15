<?php

// Sécurisation
IF (!defined('SECU_FILE')) { echo 'Acces non-autorise' ; exit() ; }

// Blocage de api.star-rouenz.fr

if ($_SERVER['HTTP_HOST'] == 'api.star-rouenz.fr') {exit();}

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	
    <title><?php echo TITRE_JEU ; ?></title>
	
	<meta name="keywords" content="star rouenz, star wars, game">
	
	<link rel="stylesheet" type="text/css" href="view/fonts.css">
	<link rel="stylesheet" type="text/css" href="view/style.css">
	
	<?php 
		// Inclusion des librairies externes
		jsLibrairies('jquery', $config['js-libs']['jquery']) ;

		// Préparation variables
		$pagination = 1;
		$looking = NULL;

		if (isset($_GET['pagination']) && ctype_digit($_GET['pagination'])) {$pagination = $_GET['pagination'];}
		if (isset($_GET['looking'])) 										{$looking = $_GET['looking'];}
	?>
	
	<script>
	
			$(document).ready(function() {
				page = 1 ;

				var interval = setInterval('banane(page<?php if ($looking !== NULL) : echo ', "'.$looking.'"'; endif; ?>)', 120000);
			});

			/* AJAX Pagination */
			function banane (pagination, looking) {	 
				var looking = looking || null;

				var param = (looking !== null) ? {'pagination':pagination, 'looking':looking} : {'pagination':pagination} ;

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: param,
					dataType: 'html',
					
					success: function(html)
					{
						$("#score-box").html(html);
					}
					
				});


				page = pagination ;

				console.log ("Page = "+page+" Pagination = "+pagination) ;

				return false;
			};


	
	</script>
	
	
</head>

<body>

	<section id="content">

		<section id="score-box">
			  
				<?php
					the_leaderboard($pagination,$looking,TRUE) ; 
				?>


		</section>

	</section>

</body>

</html>