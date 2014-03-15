<?php

$mail->Subject = "Star Rouen'z : Validez votre score ".TITRE_JEU;

$valide_link = "http://".$_SERVER['SERVER_NAME']."/?route=VALIDATE&player=".$player."&code=".$code ;

$body .=	"
".get_prenom($player).",

<br><br>

Il était une fois dans une galaxie lointaine, très lointaine… <br>
<strong>".TITRE_JEU.".</strong> <br><br>
Confronté à l’armée de l’Empire, Choubi a atteint le score de <strong>".$score.".</strong>

<br><br>

Les <b>Star Rouen’z</b> tiennent à te féliciter pour cette performance qui maintient éloignées les forces de l’Empire et donnent Un Nouvel Espoir pour regagner l’ambiance ! Les <b>goodies</b> approchent, jeune Padawan, mais un petit effort est encore nécessaire. 

<br><br>

<strong>Cliquez vite sur le lien ci-dessous pour valider ton score et accéder à ton brevet de pilotage de Wookiee !</strong><br>
<a href=\"".$valide_link."\" target=\"_blank\">".$valide_link."</a>

<br><br>

<strong>May the goodies be with you</strong>

";