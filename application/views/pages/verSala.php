
<div class="container">
    <div class="infor">
        <div  class="col-sm-5 well" >

             <img src="<?php echo base_url(); ?>assets/images/p<?php echo $sala->id ?>.jpg" >
        </div>
        <div  class="col-sm-5 well" >

            <div id="contSala">
                    
                    <h3><u>DATOS DE LA SALA</u></h3>
                    
                    NOMBRE: <?php echo $sala->nombre; ?><br>
                    CAPACIDAD: <?php echo $sala->capacidad; ?> personas<br>
                    DIRECCIÓN: <?php echo $sala->direccion; ?><br>
                    <hr>
                    PRECIO POR MEDIA HORA : $ <?php echo $sala->precio; ?>
                    <hr>
                    <a href="<?php echo base_url(); ?>controladorReservas/view/buscarSala"><h3>Ir a buscar salas</h3></a>    
            </div>  
        </div>
 
 </div>


</div>