
<?php
session_start();

if(!$_SESSION["validar"]){

    header("location:ingreso");

    exit();

} 
include "views/modules/navegacion.php";
include "views/modules/header.php";
?>
<meta charset="utf-8" />
<title>Subir Ficheros con excel</title>
<script type="text/javascript">
	function cargarHojaExcel()
	{
		if(document.frmcargararchivo1.excel.value=="")
		{
			alert("Suba un archivo");
			document.frmcargararchivo1.excel.focus();
			return false;
		}		

		document.frmcargararchivo1.action = "procesar";
		document.frmcargararchivo1.submit();
	}

</script>



<body>

    
<article>

	
      <br>

		<br>	
	<div class="col-md-3">
		<form div  style="

    width: 400px;
    /* Para ver el borde del formulario */
    padding: 3em;
    border: 1px solid #CCC;
    border-radius: 1em;	" name="frmcargararchivo1" method="post" enctype="multipart/form-data">
		  <h3>1.Subir inventario</h3>
		  <p><input type="file" name="excel"  id="excel" /></p>
		  <p><input type="button" class="btn btn-primary" value="Subir" onclick="cargarHojaExcel();" /></p>

                  </div>
		</form>

  

 
 



</article>
<br>


</body>
</html>