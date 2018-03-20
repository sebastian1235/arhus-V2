<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>

<script type="text/javascript">
    $("document").ready(function(){
        $("#localidad_sol").load("include/localidad.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#barrio_sol").load("include/getbarrio.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#asesor_sol").load("include/tercero.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#forma_pagogn_sol").load("include/forma_pago.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#estado_sol").load("include/estado.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#pais_empresamodal").load("include/sel_pais.php");
    })
</script>
<script type="text/javascript">
    $("document").ready(function(){
        $("#ciudad_empresa").load("include/sel_ciudad.php");
    })
</script>


<section class="content container-fluid">

      <div class="row">
      
    
      
      <div class="col-md-2">
        <a href="FregistroSol" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <div class="col-md-2">
        <a href="subirArchivo" class="btn btn-primary">Nuevo Registro</a>
      </div>
      <div class="row table-responsive">
      	  </div>
      <br>
      <h1>Solicitudes</h1>
      <div >
         <?php
          
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }
          $_pagi_sql=("SELECT id_sol, poliza_sol, nombre_tercero, tipo_asignacion, nombre_sol, servicio_sol, nombre_estado_preventa, fecha_prevista_sol, fecha_visita_comerc_sol, nombre_Sec, nombre_loc FROM `ap_solicitud` left join ap_terceros on ap_solicitud.asesor_sol=ap_terceros.Id_tercero left JOIN ap_asignacion on ap_solicitud.asignacion_sol=ap_asignacion.id_asignacion LEFT join ap_estado_preventa on ap_solicitud.estado_sol=ap_estado_preventa.id_estado_preventa left join siax_sectores on ap_solicitud.barrio_sol=siax_sectores.cod_sec left join siax_localidad on ap_solicitud.localidad_sol=siax_localidad.id_loc"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Poliza</th>
              <th>Asignacion</th>
              <th>Nombre asesor</th>
              <th>Nombre de solicitud</th>
              <th>Servicio</th>
              <th>Estado</th>
              <th>Fecha prevista</th>
              <th>Fecha visita</th>
              <th>Barrio</th>
              <th>Localidad</th>
              <th>modificar</th>
              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo['id_sol'];?> </td>
            <td><?php echo $arreglo['poliza_sol'];?></td>
            <td><?php echo $arreglo['tipo_asignacion'];?></td>
            <td><?php echo $arreglo['nombre_tercero'];?> </td>
            <td><?php echo $arreglo['nombre_sol'];?></td>
            <td><?php echo $arreglo['servicio_sol'];?></td>
            <td><?php echo $arreglo['nombre_estado_preventa'];?> </td>
            <td><?php echo $arreglo['fecha_prevista_sol'];?></td>
            <td><?php echo $arreglo['fecha_visita_comerc_sol'];?></td>
            <td><?php echo $arreglo['nombre_Sec'];?></td>
            <td><?php echo $arreglo['nombre_loc'];?></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id_sol'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="confirm-delete?id=<?php echo $arreglo['id_sol'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
          </div>
          
          <div class="modal-body">
            ¿Desea eliminar este registro?
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger btn-ok">Delete</a>
          </div>
        </div>
      </div>
    </div>
    
    <script>
      $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
      });
    </script>

    </section>

<?php

include "views/modules/footer.php";

?>
    