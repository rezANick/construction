<?php 
$to = "azerberenick@hotmail.fr";
			$subject = "Création de compte";

$message="<html><head></head><body>
Bonjour, <br/> Nous vous informons de la création de votre compte d'accès à Customer Feedback After Help.<br/>
 
</body></html>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

mail($to, $subject, $message, $headers); ?>