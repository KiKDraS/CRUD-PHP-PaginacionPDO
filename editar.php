<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Documento sin título</title>
  <link rel="stylesheet" type="text/css" href="hoja.css">
</head>
<body>
  <h1>ACTUALIZAR</h1>
  <?php
    if(!isset($_POST['bot_actualizar'])){
      $id=$_GET['id'];
      $nombre=$_GET['nom'];
      $apellido=$_GET['ape'];
      $direccion=$_GET['dir'];
    }else{
      include_once('conexion.php');
      $id=intval($_POST['id']);
      $nombre=$_POST['nom'];
      $apellido=$_POST['ape'];
      $direccion=$_POST['dir'];
      $sql="update datos_usuarios set nombre= :nombre, apellido= :apellido, direccion= :direccion where id= :id";
      $resultado=$base->prepare($sql);
      $resultado->bindvalue(':id', $id, PDO::PARAM_INT);
      $resultado->bindvalue(':nombre', $nombre, PDO::PARAM_STR);
      $resultado->bindvalue(':apellido', $apellido, PDO::PARAM_STR);
      $resultado->bindvalue(':direccion',$direccion, PDO::PARAM_STR);
      $resultado->execute();
      header('location:index.php');
    }

  ?>
  <p>
  
  </p>
  <p>&nbsp;</p>
  <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
    <table width="25%" border="0" align="center">
      <tr>
        <td></td>
        <td><label for="id"></label>
        <input type="hidden" name="id" id="id" value="<?= $id;?>"></td>
      </tr>
      <tr>
        <td>Nombre</td>
        <td><label for="nom"></label>
        <input type="text" name="nom" id="nom" value="<?= $nombre;?>"></td>
      </tr>
      <tr>
        <td>Apellido</td>
        <td><label for="ape"></label>
        <input type="text" name="ape" id="ape" value="<?= $apellido;?>"></td>
      </tr>
      <tr>
        <td>Dirección</td>
        <td><label for="dir"></label>
        <input type="text" name="dir" id="dir" value="<?= $direccion;?>"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</body>
</html>