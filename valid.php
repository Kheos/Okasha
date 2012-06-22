<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
		<?php
		function isbissextile($year) {
			if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0)
				return true;
			else
				return false;
		}
		
		function nbjoursdebut($jour, $mois, $year) {
			
			$nbjourdebut = 0;
			
			if (isbissextile($year))
				$nbjour = array("31","29","31","30","31","30","31","31","30","31","30","31");
			else
				$nbjour = array("31","28","31","30","31","30","31","31","30","31","30","31");
			
			for ($imois = 0; $imois < ($mois - 1); $imois++) {
				$nbjourdebut = $nbjourdebut + $nbjour[$imois];
			}
			$nbjourdebut = $nbjourdebut + $jour - 1;
				
			return $nbjourdebut;
		}
		
		function nbjoursfin($jour, $mois, $year) {
			
			if (isbissextile($year))
				$nbjour = 365;
			else
				$nbjour = 364;
			
			$nbjourdebut = nbjoursdebut($jour, $mois, $year);
			$nbjourfin = $nbjour - $nbjourdebut;
				
			return $nbjourfin;
		}
		
		$valid = 0;
		if (isset($_POST["date"])) {
			if (isset($_POST["jour"]) && isset($_POST["mois"]) && isset($_POST["year"])) {
				
				$jour = $_POST["jour"];
				$mois = $_POST["mois"];
				$year = $_POST["year"];
				
				$jhier = $jour - 1;
				$mhier = $mois;
				$yhier = $year;
				
				$jdemain = $jour + 1;
				$mdemain = $mois;
				$ydemain = $year;
				
				$nbjourdebut = nbjoursdebut($jour, $mois, $year);
				$nbjourfin = nbjoursfin($jour, $mois, $year);
				
				if ($jour > 31 || $jour == 0 || $mois > 12 || $mois == 0)
					$valid = 0;
				else {
					switch ($mois) {
						case 4:
						case 6:
						case 9:
						case 11:
							if ($jour > 30)
								$valid = 0;
							else {
								if ($jour == 30) {
									$jdemain = 1;
									$mdemain = $mois + 1;
								}
								if ($jour == 1) {
									$jhier = 31;
									$mhier = $mois - 1;
								}
								$valid = 1;
							}
							break;
						case 2:
							if ($jour == 1) {
								$jhier = 31;
								$mhier = 1;
							}
							if ($jour > 29)
								$valid = 0;
							else {
								if (isbissextile($year))
								{
									if ($jour == 29) {
										$jdemain = 1;
										$mdemain = 3;
									}
									if ($jour > 29)
										$valid = 0;
									else
										$valid = 1;
								}
								else {
									if ($jour == 28) {
										$jdemain = 1;
										$mdemain = 3;
									}
									if ($jour > 28)
										$valid = 0;
									else
										$valid = 1;
								}
							}
							break;
						default:
							if ($jour == 1) {
								$mhier = $mois - 1;
								switch ($mois) {
									case 1:
										$jhier = 31;
										$mhier = 12;
										$yhier = $year - 1;
										break;
									case 3:
										if (isbissextile($year))
											$jhier = 29;
										else
											$jhier = 28;
										break;
									case 8:
										$jhier = 31;
										break;
									default:
										$jhier = 30;
										break;
								}
							}
							
							if ($jour == 31) {
								$ydemain = $year + 1;
								$jdemain = 1;
								if ($mois == 12)
									$mdemain = 1;
								else {
									$mdemain = $mois + 1;
								}
							}
							$valid = 1;
							break;
					}
				}
				if (!$valid)
					$valid = "Non";
				else
					$valid = "Oui";
				echo "Hier : ".$jhier."/".$mhier."/".$yhier;
				echo "</br>";
				echo "Demain : ".$jdemain."/".$mdemain."/".$ydemain;
				echo "</br>";
				echo "Nombre de jours depuis le 1er Janvier : ".$nbjourdebut;
				echo "</br>";
				echo "Nombre de jours jusqu'au 31 Décembre : ".$nbjourfin;
			}
			else
				echo "Veuillez remplir tous les champs.";
		}
		?>
		<form method="post" action="">
		<label> Jour : </label>
		<input type="text" name="jour" onKeypress="if((event.keyCode < 48 || event.keyCode > 57) && event.which > 31) event.returnValue = false; if((event.which < 48 || event.which > 57) && event.which > 31) return false;">
		<label> Mois : </label>
		<input type="text" name="mois" onKeypress="if((event.keyCode < 48 || event.keyCode > 57) && event.which > 31) event.returnValue = false; if((event.which < 48 || event.which > 57) && event.which > 31) return false;">
		<label> Année : </label>
		<input type="text" name="year" onKeypress="if((event.keyCode < 48 || event.keyCode > 57) && event.which > 31) event.returnValue = false; if((event.which < 48 || event.which > 57) && event.which > 31) return false;">
		</br>
		<input type="submit" name="date"/>
		</form>
	</body>
</html>
