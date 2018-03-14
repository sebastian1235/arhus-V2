<<<<<<< HEAD
<?php
=======
    <?php
>>>>>>> f52bc1abe767abed983793d722210ca321bb43ac
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

}
<<<<<<< HEAD
include"views/modules/header.php";
include"views/modules/navegacion.php";
?>
=======
     include"views/modules/header.php";
 include"views/modules/navegacion.php"; 
 $user="root";
$pass="mysql";
$server="localhost";
$bd="arhus";

$con = mysqli_connect($server,$user,$pass,$bd);

$result = mysqli_query($con,"SELECT * FROM siax_ciudad");

$resul_localidad = mysqli_query($con,"SELECT * FROM siax_localidad");?>
>>>>>>> f52bc1abe767abed983793d722210ca321bb43ac


<div class="row">
    <div class="col-md-6">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Ciudades</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST"  action="insertCiudad">
                <div class="box-body">
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" id="nombre_ciu" name="nombre_ciu" placeholder="Ciudad">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"  name="submit" value="Agregar" action="registro_ciudad">registrar</button>
                </div>
            </form>
        </div>

    </div>
<div class="col-md-6">
        <div class="box">
        <div class="box-header">
            <h3 class="box-title">Ciudades</h3>

            <div class="box-tools">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
                             <?php
                              
                              $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
                              
                              if($mysqli->connect_error){
                                
                                die('Error en la conexion' . $mysqli->connect_error);
                                
                              }

                                      $_pagi_sql=("SELECT * FROM `siax_ciudad`"); 

                                    $query=mysqli_query($mysqli,$_pagi_sql);

                            ?>
        <div class="box-body no-padding">
          <table class="table table-striped" ">
          <thead>
            <tr>
              <th>Tipo de asignacion</th>
              <th>Comision por obra</th>
              <th>Nombre por gasodomestico</th>
              <th>Nombre fija</th>
              
              <th></th>
              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo['id_ciu'];?> </td>
            <td><?php echo $arreglo['nombre_ciu'];?></td>
         
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
        </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar localidades</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="insertLocalidad">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre localidad</label>
                        <input type="text" class="form-control" id="nombre_loc" name="nombre_loc" placeholder="Localidad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Codigo </label>
                        <input type="text" class="form-control" id="cod_loc" name="cod_loc" placeholder="Codigo">
                    </div>
                     <div class="form-group"> 
                    <label for="">Ciudad:</label>         
            <select class="form-control" id="idciudad_loc" required="" name="idciudad_loc">
              <option value="">seleccionar ciudad</option>
            <option value=""><?php while ($row = mysqli_fetch_array($result)){

                    echo '<option value="'.$row['id_ciu'].'">'.$row['nombre_ciu'].'</option>';

                } ?></option>
            </select>
        </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"  name="submit" value="Agregar" action="registro_ciudad">registrar</button>
                </div>
            </form>
        </div>

    </div>

  <div class="col-md-6">
        <div class="box">
        <div class="box-header">
            <h3 class="box-title">Ciudades</h3>

            <div class="box-tools">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
                  <?php
  
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }

          $_pagi_sql=("SELECT * FROM `siax_localidad`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <div class="box-body no-padding">
                <table class="table table-striped" ">
          <thead>
            <tr>
              <th>Tipo de asignacion</th>
              <th>Comision por obra</th>
              <th>Nombre por gasodomestico</th>
              <th>Nombre fija</th>
              
              <th></th>
              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo['id_loc'];?> </td>
            <td><?php echo $arreglo['nombre_loc'];?></td>
            <td><?php echo $arreglo['cod_loc'];?></td>
         
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
           
        </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar sector</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="insertSector">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ciudad</label>
                        <input type="text" class="form-control" id="nombre_sec" name="nombre_sec" placeholder="Ciudad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Codigo</label>
                        <input type="text" class="form-control" id="cod_sec" name="cod_sec" placeholder="Ciudad">
                    </div>
                     <div class="form-group"> 
                    <label for="">Localidad:</label>         
                   <select class="form-control" id="localidad" required="" name="localidad">
              <option value="">seleccionar ciudad</option>
            <option value=""><?php while ($row = mysqli_fetch_array($resul_localidad)){

                    echo '<option value="'.$row['id_loc'].'">'.$row['nombre_loc'].'</option>';

                } ?></option>
            </select>
        </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"  name="submit" value="Agregar" action="registro_ciudad">registrar</button>
                </div>
            </form>
        </div>

    </div>

    <div class="col-md-6">
        <div class="box">
        <div class="box-header">
            <h3 class="box-title">Sectores</h3>

            <div class="box-tools">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
                  <?php
  
  $mysqli = new mysqli('localhost', 'root', 'mysql', 'arhus');
  
  if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
  }

          $_pagi_sql=("SELECT * FROM `siax_sectores`"); 

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <div class="box-body no-padding">
            <table class="table table-striped" ">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Sector</th>
              <th>Localidad</th>
             
              
              <th></th>
              <th></th>
            </tr>
          </thead>
          <?php 
      $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){
      ?>
          <tbody>
             <tr>
            <td><?php echo $arreglo['cod_sec'];?> </td>
            <td><?php echo $arreglo['nombre_sec'];?></td>
            <td><?php echo $arreglo['localidad'];?></td>
         
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
        </tr>
          </tbody>
          <?php  } ?>
        </table>
          
        </div>
        </div>

    </div>
</div>




