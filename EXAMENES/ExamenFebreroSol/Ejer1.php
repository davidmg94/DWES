<html>

<body>
  <?php

  function Rellenar($Tam)  //Rellena un Array con Tam numeros al azar de 0 al 9
  {
    $Numeros = array();

    for ($i = 0; $i < $Tam; $i++) {
      $Numeros[] = rand(0, 9);
    }

    return $Numeros;

  }

  function Mostrar($Numeros) {

    for ($i = 0; $i < count($Numeros); $i++) {
      echo "[" . $Numeros[$i] . "] ";
    }
    echo "<br><br>";
  }

  function CondicionSerie($Numeros, $Tipo, $i)    //Funcion que devuelve el resultado de la condicion > o <  en funcion si es ascendente o descendente
  {
    if ($Tipo == "ASC") {
      $Condicion = ($Numeros[$i - 1] < $Numeros[$i]);
    } else {
      $Condicion = ($Numeros[$i - 1] > $Numeros[$i]);
    }

    return $Condicion;
  }

  function MostrarSerie($Numeros, $Tipo) {
    $SerieAct = array();   //Guardamos un Array para mostrar la serie de numeros actual
    $SerieMay = array();   //Guardamos un Array para mostrar la serie mayor
  

    $SerieAct[] = $Numeros[0];  //Inicializamos las series al primer numero
    $SerieMay[] = $Numeros[0];

    $Condicion = "";

    for ($i = 1; $i < count($Numeros); $i++) {
      if (CondicionSerie($Numeros, $Tipo, $i))  //Mientras se cumpla la condicion Ascendente o Descendente
      {
        $SerieAct[] = $Numeros[$i];
      } else  //Se interrumpe la serie
      {
        if (count($SerieAct) > count($SerieMay))   //Si la serie actual tiene mas que la mayor
        {
          $SerieMay = $SerieAct;
        }

        $SerieAct = array();

        $SerieAct[] = $Numeros[$i];  //Inicializamos la serie al numero que cortó la serie anterior
  
      }

    }

    return $SerieMay;
  }

  $Tipo = "ASC";  //Por defecto suponemos que el orden es ascendente
  
  if (isset($_POST['Enviar'])) {

    $Tam = $_POST['Tam'];      //Recogemos el tamaño del array
    $Tipo = $_POST['Tipo'];    //Recogemos el tipo de serie que buscamos
  
    $Numeros = Rellenar($Tam);  //Rellenamos el array con los números generados
  
    echo "El array rellenado al azar es:<br>";

    Mostrar($Numeros);        //Mostramos el array con los numeros generados
  
    $Serie = MostrarSerie($Numeros, $Tipo);

    echo "La mayor serie pedida es :<br>";

    Mostrar($Serie);

    echo "<br><br>";


  }

  ?>

  <form name=f1 method=post action=#>
    Tamaño<input type=text name=Tam size=3><br>
    Tipo:<br>
    Ascendente<input type=radio name=Tipo value=ASC <?php if ($Tipo == "ASC")
      echo "checked"; ?>>
    Descendente<input type=radio name=Tipo value=DSC <?php if ($Tipo == "DSC")
      echo "checked"; ?>><br>


    <input type=submit name=Enviar>

  </form>


</body>

</html>