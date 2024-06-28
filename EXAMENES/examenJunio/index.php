<?php
require_once ("letra.php");
require_once ("daoletra.php");

$textoD = "";

$dao = new daoletra("junio");

session_start();

if (!isset($_SESSION['letras'])) {
    $_SESSION['letras'] = array();
}

function buscar($array, $palabra) {
    foreach ($array as $valor) {
        if (strcasecmp($valor, $palabra) === 0) {
            return true;
        }
    }
    return false;
}

function buscarM($array, $palabra) {
    foreach ($array as $valor) {
        if (strcmp($valor, $palabra) === 0) {
            return true;
        }
    }
    return false;
}

if (isset($_POST["quitar"])) {
    unset($_SESSION['letras']);
    $entrada = $_POST["texto"];
    $array = explode(" ", $entrada);
    $salida = array();

    if (isset($_POST['mayus']) && $_POST['mayus'] == "seleccionado") {
        foreach ($array as $palabra) {
            if (!buscarM($salida, $palabra)) {
                $salida[] = $palabra;
            }
        }
    } else {
        foreach ($array as $palabra) {
            if (!buscar($salida, $palabra)) {
                $salida[] = $palabra;
            }
        }
    }

    $textoD = implode(" ", $salida);
}

function repetida($array, $letra) {
    foreach ($array as $valor) {
        if (is_object($valor) && $valor->__get("letra") == $letra) {
            return true;
        }
    }
    return false;
}

if (isset($_POST["insertar"])) {
    $textoD = $_POST["texto"];
    $arrayT = str_split($textoD);

    foreach ($arrayT as $letra) {
        $letralower = strtolower($letra);
        if ($letralower != " ") {
            if (!repetida($_SESSION['letras'], $letralower)) {
                $nueva = new letra();
                $nueva->__set("letra", $letralower);
                $nueva->__set("veces", 1);
                $_SESSION['letras'][] = $nueva;
            } else {
                foreach ($_SESSION['letras'] as $obj) {
                    if (is_object($obj) && $letralower == $obj->__get("letra")) {
                        $obj->__set("veces", $obj->__get("veces") + 1);
                    }
                }
            }
        }
    }

    // Mostrar cada letra y el número de veces que aparece
    echo "<p>Letras incluidas en la sesión:</p>";
    echo "<ul>";
    foreach ($_SESSION['letras'] as $obj) {
        if (is_object($obj)) {
            echo "<li>" . htmlspecialchars($obj->__get("letra")) . ": " . $obj->__get("veces") . "</li>";
        }
    }
    echo "</ul>";
}

if (isset($_POST["volcar"])) {
    foreach ($_SESSION['letras'] as $obj) {
        if (!empty($obj)) {
            if (is_object($obj)) {
                if ($dao->existe($obj->__get("letra")) == 0) {
                    $dao->Insertar($obj);
                } else {
                    $dao->Actualizar($obj);
                }
            }
        }
        echo "Letras registradas en la base de datos.<br>";
    }
    unset($_SESSION['letras']);
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Examen</title>
</head>

<body>
    <span>Inserte el Contenido del Texto</span><br>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <textarea name="texto" id="texto" cols="50" rows="20"><?php echo htmlspecialchars($textoD); ?></textarea><br>
        <button type="submit" name="quitar">Quitar Repetidas</button>
        <label for="distinguir">Distinguir May/Min</label>
        <input type="checkbox" name="mayus" value="seleccionado"><br>
        <button type="submit" name="insertar">Insertar en Sesion</button>
        <input type="submit" value="Volcar en BBDD" name="volcar">
    </form>
</body>

</html>