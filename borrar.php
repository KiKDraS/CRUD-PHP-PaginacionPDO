<?php
    include_once('conexion.php');
    $id=$_GET['id'];
    $base->query("delete from datos_usuarios where id= $id");
    header("location:index.php");