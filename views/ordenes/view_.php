<div class="container-fluid">
    <?php 
        foreach ($response_envia as $response_envia) {
                      foreach ($response_envia as $key => $value) {
                          $numero_envio= $value['numero_envio'];
                          $codigo_encaminamiento= $value['codigo_encaminamiento'];
                      }      
                  }
    ?>
    <?php $array=array()?>
    <?php foreach ($model as $model) { 
                  foreach ($model as $key => $value) {                      
                      $array['nombre_producto']=$value['line_items'][0]['name'];
                      $array['cantidad']=$value['number'];                      
                      $array['Total']=$value['total_price'];
                  }
                  ?>
    <?php } ?>
        <h1 class="mt-4"></h1>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>                
                <th scope="col">Total</th>
                <th scope="col">Numero de Envio</th>
                <th scope="col">Codigo encaminamiento</th>
              </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td><?=$array['nombre_producto']?></td>
                    <td><?=$array['cantidad']?></td>                    
                    <td><?=$array['Total']?></td>
                    <td><?=$numero_envio?></td>
                    <td><?=$codigo_encaminamiento?></td>
                </tr>  
            </tbody>
        </table>
</div>
<?php
                  
//print $response_envia[0]['numero_envio'];
//echo print_r($response_envia);
?>
