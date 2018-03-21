<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gas Natural Arhus Ingenieros Ltda</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="views/dist/css/skins/skin-yellow.min.css">
    <link rel="stylesheet" href="views/css/sweetalert.css">
    <link rel="stylesheet" href="views/css/style.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="views/js/sweetalert.min.js"></script>
    <!--favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="views/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="views/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="views/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="views/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="views/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="views/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="views/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="views/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="views/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="views/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="views/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="views/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="views/favicon/favicon-16x16.png">
    <link rel="manifest" href="views/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="views/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-yellow fixed">
            <!--Objecto para invocar internas -->
            <?php
            $modulos = new Enlaces();
            $modulos -> enlacesController();
            ?>
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>
<script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  //Script para las tablas//  
  $(function () {
    $('#tablas').DataTable()
    $('#tablas2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'responsive'  : true

    })
  })
</script>
<script src="views/js/perfiles.js"></script>

</body>
</html>
