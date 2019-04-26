
<?php
//////////////////////////////////////

//cette fonction convertit la date au format "lund 31 janvier 2008"
//fonction pour la convertion des dates
	/*conversion de la date au format francais*/
	function date_format1($date)
	{
		//separation de la date par / ou -
		@list ( $an , $mois ,$jours) = split("[-./]",$date);
		//inverse la date
	   return ($jours."-".$mois."-".$an);
	} 
	//
		/*conversion de la date au format anglais*/
	function date_format2($date)
	{
		//separation de la date par / ou -
		@list ( $jours , $mois ,$an) = split("[-./]",$date);
		//inverse la date
	   return ($an."-".$mois."-".$jours);
	} 
	//
	
	function dcomplete($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%A %d %B %Y",mktime(0,0,0,$mois,$jours,$an));
	}
	function mois($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%B %Y",mktime(0,0,0,$mois,$jours,$an));
	}
	function date_1($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%d %b %y",mktime(0,0,0,$mois,$jours,$an));
	}
	function date_2($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%b %Y",mktime(0,0,0,$mois,$jours,$an));
	}
function dcomplete1($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%A %d %B %Y",mktime(0,0,0,$mois,$jours,$an));
	}
	function dcomplete2($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%d %B %Y",mktime(0,0,0,$mois,$jours,$an));
	}
		function dcomplete3($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%d %b %y",mktime(0,0,0,$mois,$jours,$an));
	}
		function dcomplete6($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%d %m %y",mktime(0,0,0,$mois,$jours,$an));
	}
	function dcomplete01($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%a %d %b %y",mktime(0,0,0,$mois,$jours,$an));
	}
	function dcomplete4($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%d %m",mktime(0,0,0,$mois,$jours,$an));
	}
	function dcomplete5($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%a %d %b",mktime(0,0,0,$mois,$jours,$an));
	}
	function dcomplete_sql($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%a %d %b %y",mktime(0,0,0,$mois,$jours,$an));
	}
	function mois_1($date){
			@list ( $an , $mois ,$jours) = split("[-./]",$date);
			setlocale(LC_TIME,'french');
			return strftime("%B",mktime(0,0,0,$mois,$jours,$an));
	}
	function jour_mois($date)
	{
		//separation de la date par / ou -
		@list ( $an , $mois ,$jours) = split("[-./]",$date);
		//inverse la date
	   return ($jours."-".$mois);
	} 

//////////////////////////////////CALCUL LA DIFFRENCE DE JOUR
 
/// $now   = time();
//$date_dep = strtotime('2016-03-01');
 
function JourDiff($date1, $date_dep){
$diff = abs($date1 - $date_dep); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
 
    $tmp = $diff;
    $seconde = $tmp % 60;
 
    $tmp = floor( ($tmp - $seconde) /60 );
    $minute= $tmp % 60;
 
    $tmp = floor( ($tmp - $minute)/60 );
    $heure = $tmp % 24;
 
    $tmp = floor( ($tmp - $heure)  /24 );
    $jour = $tmp % 30;
	
	 $tmp = floor( ($tmp - $jour)  /30);
    $mois = $tmp % 12;
	
  $tmp = floor( ($tmp - $mois)  /12);
    $annee= $tmp;
	if($annee>'1'){$a='ans';}else{$a='an';}
	if($jour>'1'){$j='jours';}else{$j='jour';}
	$resultat="$annee $a $mois mois $jour $j"; 
    return $resultat;
}

function Jour($date1, $date_dep){
    $diff = abs($date1 - $date_dep); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
 
    $tmp = $diff;
    $seconde = $tmp % 60;
 
    $tmp = floor( ($tmp - $seconde) /60 );
    $minute= $tmp % 60;
 
    $tmp = floor( ($tmp - $minute)/60 );
    $heure = $tmp % 24;
 
    $tmp = floor( ($tmp - $heure)  /24 );
    $jour = $tmp % 365;
	
	 $tmp = floor( ($tmp - $jour)  /365);
    $annee = $tmp;
	$resultat="$jour"; 
    return $resultat;
}

 ?>
    