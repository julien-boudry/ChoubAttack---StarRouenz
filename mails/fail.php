<?php

$mail->Subject = "Star Rouen'z : Merci de votre participation au ".TITRE_JEU;


$body .=	"
".get_prenom($player).",

<br><br>

Il était une fois dans une galaxie lointaine, très lointaine… <br>
<strong>".TITRE_JEU.".</strong> <br><br>
Confronté à l’armée de l’Empire, Choubi a atteint le score de <strong>".$score."</strong>.

<br><br>

Malheureusement, ton Choubi a déjà été plus efficace par le passé ! <br>
Nous ne doutons pas un instant de la <b>Revanche du Choubi</b> et sommes impatients d’assister au <b>Retour du Choubi</b>.  

<br><br>

<strong>May the goodies be with you</strong>

					";