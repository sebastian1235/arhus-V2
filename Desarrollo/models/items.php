<?php


require_once "conexion.php";



class ItemsModel
{

    #registro de medio de pago.
    public function registroItems($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_item, codigo_item, tipo_item, und_item, precio_item, costo_item, marca_item, cod_marca_item, detalle_item) VALUES (:nombre_item, :codigo_item, :tipo_item, :und_item, :precio_item, :costo_item, :marca_item, :cod_marca_item, :detalle_item)");
        $stmt->bindParam(":nombre_item", $datosModel["nombre_item"], PDO::PARAM_STR);
        $stmt->bindParam(":codigo_item", $datosModel["codigo_item"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_item", $datosModel["tipo_item"], PDO::PARAM_STR);
        $stmt->bindParam(":und_item", $datosModel["und_item"], PDO::PARAM_STR);
        $stmt->bindParam(":precio_item", $datosModel["precio_item"], PDO::PARAM_STR);
        $stmt->bindParam(":costo_item", $datosModel["costo_item"], PDO::PARAM_STR);
        $stmt->bindParam(":marca_item", $datosModel["marca_item"], PDO::PARAM_STR);
        $stmt->bindParam(":cod_marca_item", $datosModel["cod_marca_item"], PDO::PARAM_STR);
        $stmt->bindParam(":detalle_item", $datosModel["detalle_item"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
    }

    #Vista de medio de pago.s

    #public function vistaMedioPago($tabla)
    #{
     #   $stmt = Conexion::conectar()->prepare("SELECT Id_medio_pago, nombre_medio_pago, activo_medio_pago FROM $tabla");
      #  $stmt->execute();
       # return $stmt->fetchAll();
       # $stmt->close();
   # }

    #public function actualizarMedioPago($datosModel, $tabla)
    #{
     #   $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_medio_pago = :nombre_medio_pago, activo_medio_pago = :activo_medio_pago WHERE Id_medio_pago = :Id_medio_pago");
      #  $stmt->bindParam(":nombre_medio_pago", $datosModel["modoPago"], PDO::PARAM_STR);
       # $stmt->bindParam(":activo_medio_pago", $datosModel["activo"], PDO::PARAM_STR);
        #$stmt->bindParam(":Id_medio_pago", $datosModel["Id_medio_pago"], PDO::PARAM_STR);

        #if($stmt->execute()){

          #  return "ok";
        #}

        #else{

         #   return "error";
        #}

        #$stmt->close();


    #}
}