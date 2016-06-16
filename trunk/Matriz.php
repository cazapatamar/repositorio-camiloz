<?php
//Definición de la clase MATRIZ con su constructor, metodos y atributos
class Matriz {
  
  private $N = 0;
  private $matriz;
  
  public function __construct($N_Param)
  {
    $this->N=$N_Param;
	$this->inicializar();
  }
  
  public function inicializar()
  {
	//Inicializar Matriz con 0 
	for($z = 1;$z <= $this->N;$z++){
		for($y = 1;$y <= $this->N;$y++){
			for($x = 1;$x <= $this->N;$x++){
					$this->matriz[$x][$y][$z] = 0;
				}
			}
		}
  }

public function update($x,$y,$z,$W)
	{
		$this->matriz[$x][$y][$z] = $W;	
	}
  
public function query($x1,$y1,$z1,$x2,$y2,$z2)
	{
		//Funcion QUERY
		$suma=0;
		$sumar = false;

		for($z = 1;$z <= $this->N;$z++){	
			for($y = 1;$y <= $this->N;$y++){
				for($x = 1;$x <= $this->N;$x++)
				{
						if($x==$x1 && $y==$y1 && $z==$z1){
							$sumar = true;
						}
						
						if($sumar){
							$suma += $this->matriz[$x][$y][$z];
						}
						
						if($x==$x2 && $y==$y2 && $z==$z2){
							$sumar = false;
						}
					}
				}
			}
		return $suma;	
	}
	
	public function imprimir_matriz()
	{
		//Imprimir matriz
		echo "<br>";	
		for($z = 1;$z <= $this->N;$z++){
			for($y = 1;$y <= $this->N;$y++){
				for($x = 1;$x <= $this->N;$x++){
						
						echo "($x,$y,$z)";
						$valor = $this->matriz[$x][$y][$z];
						echo " <b>$valor</b>  | ";
					}
				echo "<br>";
				}
			} 
	}
}

?>