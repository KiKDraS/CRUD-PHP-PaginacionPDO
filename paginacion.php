<?php 
    try {
        $base= new PDO("mysql:host=localhost; dbname=pruebas", "root", "");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET utf8");
        $cantidad=5; //Registros por página
        if(isset($_GET['pagina'])){
            if($_GET['pagina']==1){
                header('location:index.php');
            }else{
                $pagina=$_GET['pagina'];
            }
        }else {
            $pagina=1; //Página en la que carga la web
        }
        $empezar_desde=($pagina-1)*$cantidad;//Con esta cuenta podemos modificar el número inicial del registro a mostrar dependiendo de la página en que nos encontremos. Ej. $pagina=1-1= 0, por lo tanto cuando nos encontremos en la página 1, el primer registro a mostrar será el cero, al modificar el valor de la variable $pagina, modificaremos el número del primer registro a mostrar 
        $sql_total="select * from productos";
        $resultado=$base->prepare($sql_total);
        $resultado->execute();
        $num_filas=$resultado->rowCount();//Cantidad de registros devueltos
        $total_paginas=ceil($num_filas/$cantidad);//Total de páginas a mostrar diviendo la cantidad de registros devueltos sobre la cantidad de registros que se desean motrar. ceil(), redondea el resultado 
        echo "Número de registro de la consulta: " . $num_filas . "<br>";
        echo "Mostramos: " .$cantidad . " registros por página <br>";
        echo "Mostrando la página " . $pagina . " de " . $total_paginas . "<br><hr>";
        $resultado->closeCursor();
        $sql_limite="select * from productos limit $empezar_desde, $cantidad";//Limit= Parametro SQL que admite dos datos. El 1ro cuál es el primer registro a ver y el 2do cuántos registros a partir de el. Los registro tienen la organización de un array.
        $resultado=$base->prepare($sql_limite);
        $resultado->execute();
        while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
            echo "Sección: " . $registro['SECCIÓN'] . "<br>";
            echo "Artículo: " . $registro['ARTÍCULO'] . "<br>";
            echo "Fecha: " . $registro['FECHA'] . "<br>";
            echo "Origen: " . $registro['ORIGEN'] . "<br>";
            echo "Precio: " . $registro['PRECIO'] . "<br><hr>";
        }

    } catch (Exception $e) {
        echo $e->getMessage() . "<br>";
        echo "Línea de error: " . $e->getLine();
    }

    ///////////////////////////PAGINACION///////////////////////////

    for($i=1;$i<=$total_paginas;$i++){
        echo "<a href='?pagina=" . $i . "'>" .$i. "</a>  ";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>