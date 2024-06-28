<?php

function conectaDb()   //Funcion que nos conecta a una BBDD
{
    try {
        $db = new PDO("mysql:host=localhost;dbname=tarea3","root");
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $db->exec("set names utf8mb4");
        return $db;
    } 
	catch(PDOException $e) 
	{
        
        print "  <p>Error: No puede conectarse con la base de datos.</p>\n\n";
        print "  <p>Error: " . $e->getMessage() . "</p>\n";
       
        exit();
    }
}

function ConsultaSimple($db,$consulta,$param)
{
	$resul=$db->prepare($consulta);
	if (!$resul->execute($param))    
	{
	  echo "Error al ejecutar la consulta simple";	
	}	

}
function ConsultaDatos($db,$consulta,$param)
{
	$filas=array();
	
	$resul=$db->prepare($consulta);
	if (!$resul->execute($param))    
	{
	  echo "Error al ejecutar la consulta datos";	
	}	
    else
	{
	   while($fila=$resul->fetch()) 
       {
		  $filas[]=$fila;  //Añadimos una fila mas al Array 
	   }
	   
	}	
	
	return $filas;
	
}


function Cerrar($db)    //Cierra una conexión PDO
{
   $db=null;	
}






?>