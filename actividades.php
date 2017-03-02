<?php
/*
    Template Name: Actividades
*/
    get_header();
    get_template_part('inc/nav2');
    
    /* Conexion con la base de datos */
    
    $database = "pruebas";
    $usuario = "user";
    $contraseña = "clave";
    $host = "127.0.0.1";
    
    $link = mysql_connect($host, $usuario, $contraseña)
        or die('No se pudo conectar: ' . mysql_error());
    //echo 'Connected successfully';
    mysql_select_db($database, $link) or die('No se pudo seleccionar la base de datos');
?>    
<div class="imagen_post" style="background-image: url('')">
    <br><br>
    <center>
        <span class='tituloPostDestacado'>Actividades</span>
    </center>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-xs-8 col-sm-8 col-md-8">
            <?php
                $query = "Select * from actividad";
                $ress = mysql_query($query, $link);
                if (!$ress) {
                    echo "Error de BD, no se pudo consultar la base de datos\n";
                    echo "Error MySQL: " . mysql_error();
                    exit;
                }
                while ($actividad = mysql_fetch_array($ress, MYSQL_ASSOC)) {
                    //echo $actividad['id'] . '<br>';
                    $idProfesor = $actividad['idprofesor'];
                    $idGrupo = $actividad['idgrupo'];
                    $queryPro = "Select * from profesor where id = " . $idProfesor;
                    $queryGru = "Select * from grupo where id = " . $idGrupo;
                    $ressPro = mysql_query($queryPro, $link);
                    $ressGru = mysql_query($queryGru, $link);
                    $profesor = mysql_fetch_array($ressPro, MYSQL_ASSOC);
                    $grupo = mysql_fetch_array($ressGru, MYSQL_ASSOC);
                    ?>
                        <div class="card">
                            <span class="tituloPost"><?php echo $actividad['descripcionCorta']; ?></span>
                            <br>
                           <li class="inline">
                               <span class="fa fa-map-marker"></span>&nbsp;<?php echo $actividad['lugar'] ?>
                           </li>
                           <li class="inline">
                               <span class="fa fa-calendar"></span>&nbsp;<?php echo $actividad['fecha'] ?>
                           </li>
                           <li class="inline">
                               <span class="fa fa-hourglass-start"></span>&nbsp;<?php echo $actividad['horaInicial'] ?>
                           </li>
                           <li class="inline">
                               <span class="fa fa-hourglass-end"></span>&nbsp;<?php echo $actividad['horaFin'] ?>
                           </li>
                           <li class="inline">
                               <span class="fa fa-user"></span>&nbsp;<?php echo $profesor['nombre'] ?>
                           </li>
                           <li class="inline">
                               <span class="fa fa-users"></span>&nbsp;<?php echo $grupo['nombre'] ?>
                           </li>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
                                    <img class="img-responsive" src="<?php echo $actividad['fotoExcursion']; ?>">
                                    
                                </div>
                                <div class="col-lg-8 col-xs-8 col-sm-8 col-md-8">
                                    <?php
                                    echo $actividad['descripcionLarga'] . '<br>';
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                    <?php
                }
                mysql_free_result($ress);
            ?>
        </div>
        <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
            <?php get_sidebar('actividades');?>
        </div>
    </div>    
</div>    
<div class="separador"></div>    
<?php    
    get_footer();
?>