    <?php include"views/modules/header.php";
 include"views/modules/navegacion.php"; ?>


<div class="row">
    <div class="col-md-6">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Ciudades</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ciudad</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ciudad">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">registrar</button>
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
            <table class="table">
                <tr>
                    <th style="width: 10px">Asignación</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                </tr>
                <tr>
      <?php   $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){ ?>
                     <td><?php echo $arreglo['id_ciu'];?> </td>
            <td><?php echo $arreglo['nombre_ciu'];?></td>

            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>
            </table>
            <?php  } ?>
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
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre localidad</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ciudad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Codigo </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ciudad">
                    </div>
                     <div class="form-group"> 
                    <label for="">Ciudad:</label>         
                    <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
                    <option value="">seleccionar ciudad</option>
                    </select>
        </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">registrar</button>
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

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <div class="box-body no-padding">
            <table class="table">
                <tr>
                    <th style="width: 10px">Asignación</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                </tr>
                <tr>
      <?php   $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){ ?>
                     <td><?php echo $arreglo['id_ciu'];?> </td>
            <td><?php echo $arreglo['nombre_ciu'];?></td>

            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>
            </table>
            <?php  } ?>
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
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ciudad</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ciudad">
                    </div>
                     <div class="form-group"> 
                    <label for="">Localidad:</label>         
                    <select class="form-control" id="localidad_sol" required="" name="localidad_sol">
                    <option value="">seleccionar localidad</option>
                    </select>
        </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">registrar</button>
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

        $query=mysqli_query($mysqli,$_pagi_sql);?>
        <div class="box-body no-padding">
            <table class="table">
                <tr>
                    <th style="width: 10px">Asignación</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                    <th>Ciudad</th>
                </tr>
                <tr>
      <?php   $numero=mysqli_num_rows($query);
      while($arreglo=mysqli_fetch_array($query)){ ?>
                     <td><?php echo $arreglo['id_ciu'];?> </td>
            <td><?php echo $arreglo['nombre_ciu'];?></td>

            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
            <td><a href="modificar.php?id=<?php echo $arreglo['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>
            </table>
            <?php  } ?>
        </div>
        </div>

    </div>
</div>




