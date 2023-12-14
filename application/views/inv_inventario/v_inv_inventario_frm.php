<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-cart-flatbed fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Inventario</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Inventario</span><?php
                                        $oper_g = "editar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;



                                if(document.getElementById("id_articulo").value == 'null')
                                {
                                    $("#id_articulo").addClass("border-danger");
                                    $('#error_id_articulo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_articulo").removeClass("border-danger");
                                    $('#error_id_articulo').css('display', 'none');
                                };


                                if(document.getElementById("id_almacen").value == 'null')
                                {
                                    $("#id_almacen").addClass("border-danger");
                                    $('#error_id_almacen').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_almacen").removeClass("border-danger");
                                    $('#error_id_almacen').css('display', 'none');
                                };
                                

                                if(document.getElementById("capacidad_almacen").value.length < 1)
                                {
                                    $("#capacidad_almacen").addClass("border-danger");
                                    $('#error_capacidad_almacen').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#capacidad_almacen").removeClass("border-danger");
                                    $('#error_capacidad_almacen').css('display', 'none');
                                };

        
                                /*
                                if(ok == true){
                                    $("#nombre").removeClass("border-danger");
                                    $('#error_nombre_2').css('display', 'none');
                                    if(document.getElementById("nombre").value.length < 1){
                                    }else{
                                        if(soloNumero.test(document.getElementById("cedula").value) ) {
                                        }else{
                                            $("#nombre").addClass("border-danger");
                                            $('#error_nombre_2').css('display', 'block');
                                            ok = false;
                                        }

                                    };                                    
                                } */

                                if(ok == true){
                                    nombre_conflicto = document.getElementById("nombre_conflicto").value;
                                    if(nombre_conflicto == "true"){
                                        $("#nombre").addClass("border-danger");
                                        ok = false;
                                    }else{
                                        $('#error_nombre_2').css('display', 'none');
                                    }
                                }
/*                                
                                if(document.getElementById("nombres").value.length < 1)
                                {
                                    $("#nombres").addClass("border-danger");
                                    $('#error_nombres').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#nombres").removeClass("border-danger");
                                    $('#error_nombres').css('display', 'none');
                                };
                             

*/
                                
                               

                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');
                                    return ok;
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                }
                            };

                            function valida_nombre(oper){

                                var baseurl = "<?php echo base_url(); ?>";
                                nombre  = document.getElementById("nombre").value;
                                nombre = nombre.trim();

                                // if(oper == "agregar"){
                                //     $.post(baseurl+"index.php/Inv_inventario/get_inv_inventario_buscar_6",
                                //     {
                                //                 nombre: nombre
                                //     },
                                //     function(data){ //alert(data);
                                //             var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris

                                //             if(matriz_personal == false){
                                //                 $("#nombre").removeClass("border-danger");
                                //                 $('#error_nombre_2').css('display', 'none');
                                //                 document.getElementById("nombre_conflicto").value = "false";
                                //             }else{
                                //                 $("#nombre").addClass("border-danger");
                                //                 $('#error_nombre_2').css('display', 'block');
                                //                 document.getElementById("nombre_conflicto").value = "true";
                                //             }
                                //     });
                                // }

                                // if(oper == "editar"){
                                    
                                //     id = document.getElementById("id").value;
                                //     $.post(baseurl+"index.php/Inv_inventario/get_inv_inventario_buscar_5",
                                //     {
                                //                 nombre: nombre
                                //             ,   id: id
                                //     },
                                //     function(data){ //alert(data);
                                //             var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris
                                //             if(matriz_personal == false){
                                //                 $("#nombre").removeClass("border-danger");
                                //                 $('#error_nombre_2').css('display', 'none');
                                //                 document.getElementById("nombre_conflicto").value = "false";
                                //             }else{
                                //                 $("#nombre").addClass("border-danger");
                                //                 $('#error_nombre_2').css('display', 'block');
                                //                 document.getElementById("nombre_conflicto").value = "true";
                                //             }
                                //     });                                    
                                // }
                            }
                            
                        </script>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger text-center alert-error-campo" style="display: none">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    Verificar los siguientes campos...!!!
                                </div>
                            </div>
                        </div>
                        <?php
                        $atributos2 = array(
                            'name' => 'form_principal',
                            'id' => 'form_principal',
                            'onsubmit' => 'return valida(this)',
                            'role' => 'form'
                            //'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php echo form_open('Inv_inventario/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="nombre_conflicto" name="cedula_conflicto" value="false">

                        <div class="row">
                            <div class="col-md-6 float-left">
                                <label>Artículo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_articulo" name="id_articulo" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_registro->id_articulo;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_articulos); $j++){
                                        $valor_a_mostrar = $matriz_articulos[$j]->nombre;
                                        $valor = $matriz_articulos[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_articulo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                            <div class="col-md-6 float-left">
                                <label>Almacén <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen" name="id_almacen" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_registro->id_almacen;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_almacenes); $j++){
                                        $valor_a_mostrar = $matriz_almacenes[$j]->nombre;
                                        $valor = $matriz_almacenes[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_almacen" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div> 
                            <div class="col-md-12 container-fluid">
                                        <label>Capacidad de almacén <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="capacidad_almacen" name="capacidad_almacen" type="text" placeholder="capacidad_almacen" value="<?php if( isset($fila_registro->capacidad_almacen) ){ echo $fila_registro->capacidad_almacen; } ?>" size="255" maxlength="255">
                                        <span id="error_capacidad_almacen" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                            </div>
                            <div class="col-md-6  text-center mt-3"><?php  
                                if($oper != 'agregar'){

                                } 
                                /*
                                if($oper == 'editar'){
                                    if( $fila_registro->imagen_nombre == "" ){ 
                                        $ruta = base_url("images/personal_visitante/")."sin_imagen.png";
                                    }else{ 
                                        $ruta = base_url("images/personal_visitante/").$fila_registro->imagen_nombre;                                     
                                    } ?>
                                    <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px">                                
                                    <br /><br />
                                    <a href="<?=site_url('Gerencias/subir_archivo/').$fila_registro->id; ?>">
                                        <button type="button" class="btn btn-outline-sigalsx4-purpple">cambiar imagen</button>
                                    </a><?php                                    
                                } */?>
                            </div>
                        </div>                            
                            
                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>

                    <a href="<?php echo site_url('Inv_inventario/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>