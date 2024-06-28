<?php

require_once ("entidad/letra.php");
require_once ("dao/daoletra.php");

$textoD = "";

$dao = new daoletra("concesionario1");

session_start();

if (!isset($_SESSION['letras'])) {
	$_SESSION['letras'] = array();
}

function buscar($array, $palabra) {

	for ($i = 0; $i < count($array); $i++) {

		$valor = $array[$i];
		if (strcasecmp($valor, $palabra) === 0) {

			return true;

		}

	}
	return false;

}

function buscarM($array, $palabra) {

	for ($i = 0; $i < count($array); $i++) {

		$valor = $array[$i];
		if (strcmp($valor, $palabra) === 0) {

			return true;

		}

	}
	return false;

}

if (isset($_POST["quitar"])) {

	$entrada = $_POST["texto"];
	$array = explode(" ", $entrada);
	$salida = array();

	if (isset($_POST['mayus']) && $_POST['mayus'] == "seleccionado") {

		foreach ($array as $palabra) {

			if (buscarM($salida, $palabra) === false) {

				array_push($salida, $palabra);

			}

		}

	} else {

		foreach ($array as $palabra) {

			if (buscar($salida, $palabra) == false) {

				array_push($salida, $palabra);

			}

		}

	}

	$textoD = implode(" ", $salida);

}

function repetida($array, $letra) {

	for ($i = 0; $i < count($array); $i++) {

		$valor = $array[$i];
		if ($valor->__get("letra") == $letra) {
			return true;
		}
	}
	return false;
}

if (isset($_POST["insertar"])) {

	$textoD = $_POST["texto"];

	$arrayT = str_split($textoD);


	foreach ($arrayT as $letra) {

		if ($letra != " ") {

			if (!repetida($_SESSION['letras'], $letra)) {

				$nueva = new letra();
				$nueva->__set("letra", $letra);
				$nueva->__set("veces", 1);

				array_push($_SESSION['letras'], $nueva);

			} else {

				for ($i = 0; $i < count($_SESSION['letras']); $i++) {

					if ($letra == $_SESSION['letras'][$i]->__get("letra")) {

						$_SESSION['letras'][$i]->__set("veces", $_SESSION['letras'][$i]->__get("veces") + 1);

					}

				}

			}

		}


	}

	echo "Letras incluidas en la sesion";

}

if (isset($_POST["submit"])) {

	for ($i = 0; $i < count($_SESSION['letras']); $i++) {

		$codigo = $_SESSION['letras'][$i];

		if ($dao->existe($codigo->__get("letra")) == 0) {

			$dao->Insertar($_SESSION['letras'][$i]);

		} else {

			$dao->Actualizar($_SESSION['letras'][$i]);

		}

	}

}

?>
<html>

<head>
	<meta charset="utf-8">
	<title>Examen</title>
</head>
<span>Inserte el Contenido del Texto</span><br>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

	<textarea name="texto" id="texto" cols="50" rows="20"><?php echo $textoD; ?></textarea><br>

	<button type="quitar" name="quitar">Quitar Repetidas</button>
	<label for="distinguir">Distinguir May/Min</label>
	<input type="checkbox" name="mayus" value="seleccionado"><br>
	<button type="insertar" name="insertar">Insertar en Sesion</button>
	<input type="submit" value="Volcar en BBDD" name="submit">

</form>

<body>
</body>

</html>