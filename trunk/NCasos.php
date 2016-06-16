<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

include "Matriz.php";

$T =    isset($_POST['T']) ? $_POST['T'] : null;
$serial =    isset($_POST['serial']) ? $_POST['serial'] : null;
$ArrN = isset($_POST['ArrN']) ? $_POST['ArrN'] : null;
$ArrM = isset($_POST['ArrM']) ? $_POST['ArrM'] : null;

$NCasos = isset($_POST['NCasos']) ? $_POST['NCasos'] : null;

$ArrQuerys = isset($_POST['ArrQuerys']) ? $_POST['ArrQuerys'] : null;
?>

<?php
//1. Se solicita N y M para cada caso T
if(!isset($ArrN) && !isset($ArrQuerys)){
?>

<form name='Casos' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<h2>CUBE SUMMATION</h2>
<h3>Número de casos :  <?php echo $T?> </h3>
<p>Ingrese N y M para cada caso</p> 
<table border="1">

<?php
 
for($i = 1; $i <= $T;$i++)
{
	echo "<tr><td>";
	echo "<b>Caso # $i</b><br><br>";
	echo "Ingrese N (Tamaño matriz): <input type='text' name='ArrN[$i]' maxlength='4' size='3'>";
	echo "<br>";
	echo "Ingrese M (Operaciones):   <input type='text' name='ArrM[$i]' maxlength='4' size='3'>";
	echo "</td></tr>";
	
	
		
}
	echo " <input type='hidden' name='T' value='$T'> ";
	echo "</table>";
	echo "<br><br>";
?>
<input type='submit' value='Continuar'>
</form>
<?php } ?>



<?php
// 2. Se solicita especificar los datos para cada operacion, ya sea UPDATE o QUERY
if(isset($ArrN) && !isset($ArrQuerys)){
	
?>	
<h2>CUBE SUMMATION</h2>
<h3>Número de casos :  <?php echo $T?> </h3>
<p>Ingrese datos para cada operacion:</p>
<p>- UPDATE de la forma (x,y,z,W)</p>
<p>- QUERY de la forma (x1,y1,z1,x2,y2,z2)</p>
<br><br>

<form id='Querys' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table border="1">

<?php 
	$NCasosArr;
	$ArrQuerys = isset($_POST['ArrQuerys']) ? $_POST['ArrQuerys'] : null;
	
	for($i = 1;$i <= $T;$i++)//Num casos de prueba
	{
		echo "<tr><td>";
		echo "<b>Caso # $i</b><br>";
		for($j = 1;$j <=$ArrM[$i];$j++)//Num de Querys
		{
			echo " <input type='radio' name='ArrQuerys[$i][$j][1]' value='U'>Update ";
			echo " <input type='radio' name='ArrQuerys[$i][$j][1]' value='Q'>Query ";
			echo " <input type='text' name='ArrQuerys[$i][$j][2]' value='0' maxlength='3' size='3'>";
			echo " <input type='text' name='ArrQuerys[$i][$j][3]' value='0' maxlength='3' size='3'>";
			echo " <input type='text' name='ArrQuerys[$i][$j][4]' value='0' maxlength='3' size='3'>";
			echo " <input type='text' name='ArrQuerys[$i][$j][5]' value='0' maxlength='3' size='3'>";
			echo " <input type='text' name='ArrQuerys[$i][$j][6]' value='0' maxlength='3' size='3'>";
			echo " <input type='text' name='ArrQuerys[$i][$j][7]' value='0' maxlength='3' size='3'>";
			echo "<br>";

		}
		echo "</td></tr>";
	}
	$serialArrN = serialize($ArrN);
	echo " <input type='hidden' name='serialArrN' value='$serialArrN'> ";
	$serialArrM = serialize($ArrM);
	echo " <input type='hidden' name='serialArrM' value='$serialArrM'> ";
	$serialArrQuerys = serialize($ArrQuerys);
	echo " <input type='hidden' name='serialArrQuerys' value='$serialArrQuerys'> ";
	echo " <input type='hidden' name='T' value='$T'> ";
	echo "</table>";
	echo "<br><br>";
?>
<input type="submit" value="Calcular">

</form>
<?php } ?>

<table border="1">

<?php if(isset($ArrQuerys) && isset($T)){ 

	$ArrN = unserialize($_POST['serialArrN']);
	$ArrM = unserialize($_POST['serialArrM']);
	$salidas = array();
	
	echo "<h2>RESULTADOS</h2>";
	echo "<h3>NUMERO DE CASOS [T]: $T</h3><br>";
	
	for($i=1;$i<=$T;$i++)
	{
		echo "<tr><td>";
		echo "<h4>CASO N° $i: </h4>";
		$n = $ArrN[$i];
		$m = $ArrM[$i];
		echo "- Tamaño matriz [N]: $n <br>";
		echo "- Número de operaciones  [M]: $m <br>";
		echo "<br>";
		echo "-Salidas Caso $i<br>";
		
		$matriz = new Matriz($n);
		for($j = 1; $j <= $m; $j++)
		{
			$tipoQ = $ArrQuerys[$i][$j][1];
			if($ArrQuerys[$i][$j][1] == "U"){
				$x1 = $ArrQuerys[$i][$j][2];
				$y1 = $ArrQuerys[$i][$j][3];
				$z1 = $ArrQuerys[$i][$j][4];
				$W =  $ArrQuerys[$i][$j][5];
				
				$matriz->update($x1,$y1,$z1,$W);
			}
			elseif($ArrQuerys[$i][$j][1] == "Q")
			{
				$x1 = $ArrQuerys[$i][$j][2];
				$y1 = $ArrQuerys[$i][$j][3];
				$z1 = $ArrQuerys[$i][$j][4];
				$x2 = $ArrQuerys[$i][$j][5];
				$y2 = $ArrQuerys[$i][$j][6];
				$z2 = $ArrQuerys[$i][$j][7];
				
				$valor = $matriz->query($x1,$y1,$z1,$x2,$y2,$z2);
				echo $valor."<br>";
				$salidas[] = $valor;				
				
			}else{
				//echo "NADA - Caso N:$i - Operacion N:$j <br>";
				}
			
		}
		echo "<br>-Matriz Final<br>";
		$matriz->imprimir_matriz();
		echo "</td></tr>";
	}
	echo "</table>";
?>

<table border="1">
	<tr>
		<td>
			<h2>RESUMEN DE RESULTADOS</h2>
			<h4>(Todas las salidas para caso 1 hasta caso <?php echo "$T";?>)</h4>
			<?php
			
				for($i = 0;$i < count($salidas);$i++)
				{
					echo "<b>".$salidas[$i]."</b><br>"; 
				}	
				
			?>
		</td>
	</tr>
</table>	

<?php } ?>
</body>
</html>