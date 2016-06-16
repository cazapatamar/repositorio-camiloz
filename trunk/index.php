<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<script type="text/javascript">
	//Se valida que T este entre 1 y 50
	function validarNumCasos(){ 
		if (document.NCasos.T.value.length==0){ 
			alert("El campo 'Número de casos' no puede estar vacio") 
			document.NCasos.T.focus() 
			return 0; 
		}
		else{
			T = document.NCasos.T.value 
			T = parseInt(T)
			if (T<1 || T>50){ 
				alert("Debe ingresar un número entero entre 1 y 50") 
				document.NCasos.T.focus() 
				return 0; 
			}
		}
		document.NCasos.submit();			
}
</script>
</head>
<body>  

<h2>CUBE SUMMATION</h2>

<form name="NCasos" method="post" action="NCasos.php">  
  Número de casos: <input type="text" name="T">
  <br><br>
  <input type="button" value="Enviar" onclick="validarNumCasos()">  
</form>
</body>
</html>