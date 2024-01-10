<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-arrow-left fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Recepción</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Recepción</span><?php
                                        $oper_g = "editar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                    
                            

                            function valida(f){


                                var ok = true;
                                //var soloNumero= /^([0-9])+$/;
                                var soloNumero= /^\d{1,18}(\.\d{1,2})?$/
 
                                // if(valida_saldo2())
                                //     {
                                //         alert("TRUE");
                                //         $("#cantidad").addClass("border-danger");
                                //         $('#error_cantidad2').css('display', 'block');
                                //         ok = false;
                                //     }else{
                                //         alert("FALSE");
                                //         $("#cantidad").removeClass("border-danger");
                                //         $('#error_cantidad2').css('display', 'none');
                                //     };
                                   
                                
                                if(document.getElementById("nombre").value.length < 1)
                                {
                                    $("#nombre").addClass("border-danger");
                                    $('#error_nombre').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#nombre").removeClass("border-danger");
                                    $('#error_nombre').css('display', 'none');
                                };

                                if(document.getElementById("id_articulo").value == 'null')
                                {
                                    $("#id_articulo").addClass("border-danger");
                                    $('#error_id_articulo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_articulo").removeClass("border-danger");
                                    $('#error_id_articulo').css('display', 'none');
                                };

                                if(document.getElementById("fecha").value.length < 1)
                                {
                                    $("#fecha").addClass("border-danger");
                                    $('#error_fecha_de_ingreso').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#fecha").removeClass("border-danger");
                                    $('#error_fecha_de_ingreso').css('display', 'none');
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

                                if(document.getElementById("capacidad_almacen").value == 'No Posee')
                                {
                                    $("#id_almacen").addClass("border-danger");
                                    $('#error_id_almacen2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_almacen").removeClass("border-danger");
                                    $('#error_id_almacen2').css('display', 'none');
                                };
                                

                                if(document.getElementById("cantidad").value.length < 1)
                                {
                                    $("#cantidad").addClass("border-danger");
                                    $('#error_cantidad').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#cantidad").removeClass("border-danger");
                                    $('#error_cantidad').css('display', 'none');

                                    if(soloNumero.test(document.getElementById("cantidad").value) ) {
                                        $("#cantidad").removeClass("border-danger");
                                        $('#error_cantidad_3').css('display', 'none');

                                            if(document.getElementById("cantidad").value == 0)
                                            {
                                                $("#cantidad").addClass("border-danger");
                                                $('#error_cantidad_4').css('display', 'block');
                                                ok = false;
                                            }else{
                                                $("#cantidad").removeClass("border-danger");
                                                $('#error_cantidad_4').css('display', 'none');
                                            }
                                    }else{
                                        $("#cantidad").addClass("border-danger");
                                        $('#error_cantidad_3').css('display', 'block');
                                        ok = false;
                                    }
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
                                //     $.post(baseurl+"index.php/Inv_recepcion/get_inv_recepcion_buscar_6",
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
                                //     $.post(baseurl+"index.php/Inv_recepcion/get_inv_recepcion_buscar_5",
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

                            function valida_almacen(oper){

                                var baseurl = "<?php echo base_url(); ?>";
                                cantidad  = document.getElementById("cantidad").value;
                                almacen = document.getElementById("id_almacen").value;
                                articulo = document.getElementById("id_articulo").value;


                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Inv_recepcion/get_inv_recepcion_buscar_capacidad",
                                    {
                                                almacen: almacen,articulo:articulo
                                    },
                                    function(data){ //alert(data);

                                            
                                            var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                 
                                            if(resultado){
                                                document.getElementById("capacidad_almacen").value = resultado[0].capacidad_almacen;
                                            }else{
                                                document.getElementById("capacidad_almacen").value = 'No Posee';
                                            }

                                            disponibilidad(oper);
                                        
                                    });
                                }

                                // if(oper == "editar"){
                                    
                                //     id = document.getElementById("id").value;
                                //     $.post(baseurl+"index.php/Inv_recepcion/get_inv_recepcion_buscar_5",
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

            function disponibilidad(oper){

                var baseurl = "<?php echo base_url(); ?>";
                cantidad  = document.getElementById("cantidad").value;
                almacen = document.getElementById("id_almacen").value;
                articulo = document.getElementById("id_articulo").value;
                var capacidad = document.getElementById("capacidad_almacen").value; 


                        if(oper == "agregar"){
                            $.post(baseurl+"index.php/Inv_inventario/get_inv_movimiento_saldo_actual",
                            {
                                        almacen: almacen,articulo:articulo
                            },
                            function(data){ //alert(data);
                                    var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                    if(resultado){
                                        document.getElementById("disponibilidad").value= (parseFloat(capacidad) - parseFloat(resultado[0].saldo_final)).toFixed(2);

                                    }else{
                                        document.getElementById("disponibilidad").value=capacidad;
                                    }
                                    
                            })
                        }        

                
            }                

            function valida_saldo(oper){

                var baseurl = "<?php echo base_url(); ?>";
                cantidad  = document.getElementById("cantidad").value;
                cantidadAux  = document.getElementById("cantidadAux").value;
                almacen = document.getElementById("id_almacen").value;
                articulo = document.getElementById("id_articulo").value;


                        switch(oper){
                            case 'agregar':
                            case 'editar':    
                                    $.post(baseurl+"index.php/Inv_inventario/get_inv_movimiento_saldo_actual",
                                    {
                                                almacen: almacen,articulo:articulo
                                    },
                                    function(data){ //alert(data);
                                            var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                            let disponibilidad=0;
                                            if(resultado){
                                                    disponibilidad=parseFloat(document.getElementById("capacidad_almacen").value)-parseFloat(resultado[0].saldo_final);
                                            }else{
                                                    disponibilidad=parseFloat(document.getElementById("capacidad_almacen").value)
                                            }   

                                            if(oper=='editar'){
                                                cantidad=cantidad-cantidadAux;
                                            }

                                            if(parseFloat(cantidad) > parseFloat(disponibilidad))
                                            {
                                                $("#cantidad").addClass("border-danger");
                                                $('#error_cantidad2').css('display', 'block');
                                                ok = false;
                                            }else{
                                                $("#cantidad").removeClass("border-danger");
                                                $('#error_cantidad2').css('display', 'none');
                                            };
                                    });
                                break; 
                        }
                       

            }     
            
            function limpiarAlmacen(){
                console.log("limpiar");
                document.getElementById('id_almacen').value=null;
            }


            
            
            setTimeout(() => {    
                if (document.readyState === 'complete') {
                    $('#fecha_vencimiento').datepicker({
                                    format: 'dd/mm/yyyy',
                                    todayHighlight: true,
                                    pick12HourFormat: true,
                                    language: "es"
                                }); 
                }
            }, 100);

        </script>
                        <div class="row">
                            <div class="col-md-6 float-left text-right container-fluid mt-2">
                                <?php

                                if( strlen($this->session->userdata('inv_recepcion_mensaje_tipo')) > 0  ){ ?>
                                        <div class="alert <?php echo $this->session->userdata('inv_recepcion_mensaje_tipo'); ?> text-center"><?php
                                            echo $this->session->userdata('inv_recepcion_mensaje_contenido'); ?>
                                        </div><?php
                                        $s_mensaje = array(
                                                'inv_recepcion_mensaje_tipo'         => '',
                                                'inv_recepcion_mensaje_contenido'    => ''
                                        );
                                        $this->session->set_userdata($s_mensaje);
                                } ?>
                            </div>   
                        </div> 
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
                            'onsubmit' => "return valida(this)",
                            'role' => 'form'
                            //'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php echo form_open('Inv_recepcion/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="nombre_conflicto" name="cedula_conflicto" value="false">
                        <input type="hidden" id="swCantidad" name="swCantidad" value=false>

                        <div class="row">
                            <div class="col-md-6 float-left">
                                <label>Artículo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_articulo" name="id_articulo" data-show-subtext="true" data-live-search="true" onchange="limpiarAlmacen();"><?php
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
                            <div class="col-md-6 container-fluid mt-6">
                                            <label for="fecha">Fecha de Ingreso <span style="color:#F00;">*</span></label>
                                            <input class="form-control" type="text" id="fecha" name="fecha" value='<?php if( isset($fila_registro->fecha_ingreso) ){ echo $fila_registro->fecha_ingreso; }else{ echo date ('d/m/Y'); } ?>' size="10" >
                                            <span id="error_fecha_de_ingreso" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i> 
                                                Seleccionar Fecha
                                            </span>
                                            <input type="hidden" name="fecha2" id="fecha2" value='<?php if( isset($fila_registro->fecha_ingreso) ){ echo $fila_registro->fecha_ingreso; }else{ echo date ('d-m-Y'); } ?>'>
                            </div>  
                            <div class="col-md-6 float-left">
                                <label>Almacén <span style="color:#F00;">*</span></label>
                                <br />
                                <!-- <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen" name="id_almacen" data-show-subtext="true" data-live-search="true" onchange="valida_almacen('<?php echo $oper; ?>')"> -->
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen" name="id_almacen" data-show-subtext="true" data-live-search="true">   
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
                                <span id="error_id_almacen2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    el artículo y el almacén seleccionado no tiene capacidad registrada en inventario 
                                </span>
                            </div> 
    
                            <!-- <div class="col-md-6 container-fluid">
                                        <label>Capacidad Almacén <span style="color:#F00;"></span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="capacidad_almacen" name="capacidad_almacen" type="text" size="255" maxlength="255" readonly=true  value="<?php if( isset($fila_registro->capacidad_almacen) ){ echo $fila_registro->capacidad_almacen; } ?>">
                            </div>
                            <div class="col-md-6 container-fluid">
                                        <label>Disponibilidad <span style="color:#F00;"></span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="disponibilidad" name="disponibilidad" type="text" size="255" maxlength="255" readonly=true  value="<?php if( isset($fila_registro->disponibilidad) ){ echo $fila_registro->disponibilidad; } ?>">
                            </div> -->
                            <div class="col-md-6 container-fluid">
                                        <label>Cantidad <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <!-- <input class="form-control" id="cantidad" name="cantidad" type="text" placeholder="" value="<?php if( isset($fila_registro->cantidad) ){ echo $fila_registro->cantidad; } ?>" size="255" maxlength="255" onchange="valida_saldo('<?php echo $oper; ?>')"> -->
                                        <input class="form-control" id="cantidad" name="cantidad" type="text" placeholder="" value="<?php if( isset($fila_registro->cantidad) ){ echo $fila_registro->cantidad; } ?>" size="255" maxlength="255">
                                        <input type="hidden" id="cantidadAux" name="cantidadAux" value="<?php if( isset($fila_registro->cantidad) ){ echo $fila_registro->cantidad; } ?>">
                                        <span id="error_cantidad" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <span id="error_cantidad2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad excede la disponibilidad
                                        </span>  
                                        <span id="error_cantidad_3" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad debe ser númerico
                                        </span> 
                                        <span id="error_cantidad_4" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad debe ser mayor a cero (0)
                                        </span> 
                            </div>
                            <!-- <div class="cold-md-3 container-fluid">
                                <div class="shards-demo">
                                                <div class="input-daterange input-group" id="datepicker-example">
                                                    <input type="text" class="input-sm form-control" name="b_fecha_vencimiento" id="b_fecha_vencimiento" placeholder="Fecha vencimiento" value="<?php if(isset($fila_registro->fecha_vencimiento)) { echo $fila_registro->fecha_vencimiento; } ?>"/>
                                                    <input type="text" class="input-sm form-control" name="b_fecha_vencimiento_2" id="b_fecha_vencimiento_2" placeholder="Fecha vencimiento" value="<?php if(isset($fila_registro->fecha_vencimiento)) { echo $fila_registro->fecha_vencimiento; } ?>"/>
                                                </div>
                                                <span id="error_b_fecha_desde_hasta" style="display: none" class="text-danger error-camp">
                                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                                    Seleccione los campos de Fecha
                                                </span>                                            
                                </div>
                            </div>      -->
                            <div class="col-md-12 container-fluid mt-6">
                                            <label for="fecha_vencimiento">Fecha de Vencimiento <span style="color:#F00;">*</span></label>
                                            <input class="form-control"  type="text" id="fecha_vencimiento" name="fecha_vencimiento" value='<?php if( isset($fila_registro->fecha_vencimiento) ){ echo $fila_registro->fecha_vencimiento; } ?>' size="10" >
                                            <span id="error_fecha_de_ingreso" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i> 
                                                Seleccionar Fecha
                                            </span>
                                            <!-- <input type="hidden" name="fecha2" id="fecha2" value='<?php if( isset($fila_registro->fecha_ingreso) ){ echo $fila_registro->fecha_ingreso; } ?>'> -->
                            </div> 
                            <div class="col-md-12 container-fluid">
                                        <label>Observación <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <textarea class="form-control" id="nombre" name="nombre" size="255" maxlength="255" onchange="valida_nombre('<?php echo $oper; ?>')"><?php if( isset($fila_registro->observacion) ){ echo $fila_registro->observacion; } ?></textarea>
                                        <span id="error_nombre" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <!-- <span id="error_nombre_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            El valor del campo, ya existe
                                        </span> -->
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

                    <a href="<?php echo site_url('Inv_recepcion/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>