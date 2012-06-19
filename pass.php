<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="">
            <input type="checkbox" name="majuscule"/>
            <label>Majuscule</label><br/>
            <input type="checkbox" name="minuscule"/>
            <label> Minuscule </label><br/>
            <input type="checkbox" name="chiffre"/>
            <label> Chiffre </label><br/>
			<input type="checkbox" name="special"/>
            <label> Caract�res ASCII </label><br/>
            <input type="text" name="nombre" onKeypress="if((event.keyCode < 45 || event.keyCode > 57) && event.keyCode > 31 && event.keyCode != 43) event.returnValue = false; if((event.which < 45 || event.which > 57) && event.which > 31 && event.which != 43) return false;">
            <label> Nombre de mot de passe </label><br/>
            <input type="text" name="longueur" onKeypress="if((event.keyCode < 45 || event.keyCode > 57) && event.keyCode > 31 && event.keyCode != 43) event.returnValue = false; if((event.which < 45 || event.which > 57) && event.which > 31 && event.which != 43) return false;">
            <label> Longeur du mot de passe </label><br/>
            <input type="submit" name="boutton"/>
        </form>
        
<?php
        
function getpass($nombre,$valeurs,$nbcarac) {
    
$resultat = "";
    
for ($i=0; $i<$nombre; $i++) {
      
    $val = $valeurs[rand(0,$nbcarac -1)];
	$resultat = $resultat.$val;
}

return $resultat;

}

// longueur mot de passe

//$longueur = $_POST["longueur"]

//ensemble des caract�res
$allcaractere = array();

//tableau majuscule
$majuscule = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

  // tableau minuscule
$minuscule = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

  //  tableau de nombre 
$chiffre = array("0","1","2","3","4","5","6","7","8","9");

$special = array(",","?",";",".",":","/","!","�","&","~","\"","#","(","[","-","|","`","_","\\","^","@",")","]","=","}","<",">");

// verification des checkbox 

// array_merge  : fusionne plusieurs tableaux en un seul

if (isset($_POST["boutton"])) {
	if (isset($_POST['minuscule']) || isset($_POST['minuscule']) || isset($_POST['minuscule']) || isset($_POST['minuscule'])) {

		if (isset($_POST['minuscule']))
			$allcaractere = array_merge($allcaractere, $minuscule);

		 if (isset($_POST["majuscule"]))
			 $allcaractere = array_merge($allcaractere, $majuscule);

		 if (isset($_POST["chiffre"]))
			 $allcaractere = array_merge($allcaractere, $chiffre);

		if (isset($_POST["special"]))
			 $allcaractere = array_merge($allcaractere, $special);

		$nbcaractere = count($allcaractere);
		$resut = getpass($_POST["longueur"], $allcaractere, $nbcaractere);
		echo $resut;
	}
	else 
		echo "Veuillez choisir au moins un type de caract�re que doit comporter votre mot de passe.";
}
     
//$rand_keys = array_rand($majuscule, 10);
//echo $majuscule[$rand_keys[0]];
//echo "<br/>";

//echo rand(15,20);
 //echo "<br/>";
//$res = getpass(10,10,15);
//echo $res;
?>
    </body>
</html>
