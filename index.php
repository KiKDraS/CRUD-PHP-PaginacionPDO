<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>CRUD</title>
  <link rel="stylesheet" type="text/css" href="hoja.css">
</head>
<body>
  <?php
    include_once('conexion.php');

    ////////////Paginaccion///////////////
    $cantidad=3; //Registros por página
        if(isset($_GET['pagina'])){
            if($_GET['pagina']==1){
                header('location:index.php');
            }else{
                $pagina=$_GET['pagina'];
            }
        }else {
            $pagina=1; //Página en la que carga la web
        }
        $empezar_desde=($pagina-1)*$cantidad;//Calculo de registro inicial 
        $sql_total="select * from datos_usuarios";
        $resultado=$base->prepare($sql_total);
        $resultado->execute();
        $num_filas=$resultado->rowCount();//Cantidad de registros devueltos
        $total_paginas=ceil($num_filas/$cantidad);
        $resultado->closeCursor();
    //////////////////////////////////////

    $conexion=$base->query("select * from datos_usuarios limit $empezar_desde, $cantidad");
    $registros=$conexion->fetchAll(PDO::FETCH_OBJ);//Crea un array de objetos

    //Lo mismo en una línea
    /* $registros=$base->query("select * from datos_usuarios")->fetchAll(PDO::FETCH_OBJ); */

    if(isset($_POST['cr'])){
      $nombre=$_POST['nom'];
      $apellido=$_POST['ape'];
      $direccion=$_POST['dir'];
      $sql="insert into datos_usuarios (nombre, apellido, direccion) values (:nombre, :apellido, :direccion)";
      $resultado=$base->prepare($sql);
      $resultado->bindvalue(':nombre', $nombre, PDO::PARAM_STR);
      $resultado->bindvalue(':apellido', $apellido, PDO::PARAM_STR);
      $resultado->bindvalue(':direccion',$direccion, PDO::PARAM_STR);
      $resultado->execute();
      header('location:index.php');
    }  
  ?>
  <h1>CRUD<span class="subtitulo">Create Read Update Delete</span></h1>
  <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
    <table width="50%" border="0" align="center">
      <tr >
        <td class="primera_fila">Id</td>
        <td class="primera_fila">Nombre</td>
        <td class="primera_fila">Apellido</td>
        <td class="primera_fila">Dirección</td>
        <td class="sin">&nbsp;</td>
        <td class="sin">&nbsp;</td>
        <td class="sin">&nbsp;</td>
      </tr> 
      <?php foreach($registros as $value) :?>
      <tr>
        <td><?= $value->id?></td>
        <td><?= $value->nombre?></td>
        <td><?= $value->apellido?></td>
        <td><?= $value->direccion?></td>
        <td class="bot"><a href="borrar.php?id= <?= $value->id?>"><input type='button' name='del' id='del' value='Borrar'></a></td>
        <td class='bot'><a href="editar.php?id= <?= $value->id?> & nom= <?= $value->nombre?> & ape= <?= $value->apellido?> & dir= <?= $value->direccion?>"><input type='button' name='up' id='up' value='Actualizar'></a></td>
      </tr>
      <?php endforeach; ?>       
      <tr>
        <td></td>
        <td><input type='text' name='nom' size='10' class='centrado'></td>
        <td><input type='text' name='ape' size='10' class='centrado'></td>
        <td><input type='text' name='dir' size='10' class='centrado'></td>
        <td class='bot'><input type='submit' name='cr' id='cr' value='Insertar'></td>
      </tr> 
      <tr>
        <td class='centrado'>
          <?php 
            ////////////Paginaccion///////////////
            for($i=1;$i<=$total_paginas;$i++){
              echo "<a href='?pagina=" . $i . "'>" .$i. "</a>  ";
            }
          ?>  
        </td>
      </tr>   
    </table>
  </form>
  <p>&nbsp;</p>
</body>
</html>