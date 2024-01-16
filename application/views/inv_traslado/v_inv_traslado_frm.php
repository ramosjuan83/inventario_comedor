<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-arrows-left-right fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Traslado</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Traslado</span><?php
                                        $oper_g = "editar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;
                                var soloNumero= /^\d{1,18}(\.\d{1,2})?$/

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

                                if(document.getElementById("id_almacen_origen").value == 'null')
                                {
                                    $("#id_almacen_origen").addClass("border-danger");
                                    $('#error_id_almacen_origen').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_almacen_origen").removeClass("border-danger");
                                    $('#error_id_almacen_origen').css('display', 'none');
                                };

                                if(document.getElementById("id_almacen_destino").value == 'null')
                                {
                                    $("#id_almacen_destino").addClass("border-danger");
                                    $('#error_id_almacen_destino').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_almacen_destino").removeClass("border-danger");
                                    $('#error_id_almacen_destino').css('display', 'none');
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
                                //     $.post(baseurl+"index.php/Inv_traslado/get_inv_traslado_buscar_6",
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
                                //     $.post(baseurl+"index.php/Inv_traslado/get_inv_traslado_buscar_5",
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


                            function valida_saldo(oper){

                    

                                var baseurl = "<?php echo base_url(); ?>";
                                cantidad  = document.getElementById("cantidad").value;
                                cantidadAux  = document.getElementById("cantidadAux").value;
                                almacenOrigen = document.getElementById("id_almacen_origen").value;
                                articulo = document.getElementById("id_articulo").value;
                                //disponibilidadDestino2=document.getElementById("disponibilidad_destino").value;

                                        

                                        switch(oper){
                                            case 'agregar':
                                            case 'editar':    
                                                    $.post(baseurl+"index.php/Inv_inventario/get_inv_movimiento_saldo_actual",
                                                    {
                                                                almacen: almacenOrigen,articulo:articulo
                                                    },
                                                    function(data){ //alert(data);
                                                            var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                                            let disponibilidad=0;
                                                            //let disponibilidadDestino=0;
                                                            if(resultado){
                                                                    disponibilidad=parseFloat(resultado[0].saldo_final);
                                                                    //disponibilidadDestino=parseFloat(document.getElementById("capacidad_almacen").value)-parseFloat(resultado[0].saldo_final);
                                                                    //console.log("disponibilidadDEstino",document.getElementById("capacidad_almacen").value);
                                                            } 

                                                            // if(oper=='editar'){
                                                            //     cantidad=cantidad-cantidadAux;
                                                            // }

                                                            if(parseFloat(cantidad) > parseFloat(disponibilidad))
                                                            {
                                                                $("#cantidad").addClass("border-danger");
                                                                $('#error_cantidad2').css('display', 'block');
                                                                ok = false;
                                                            }else{

                                                              
                                                                // if(parseFloat(cantidad) > parseFloat(disponibilidadDestino2))
                                                                //     {
                                                                //         $("#cantidad").addClass("border-danger");
                                                                //         $('#error_cantidad_5').css('display', 'block');
                                                                //         ok = false;
                                                                //     }else{

                                                                //         $("#cantidad").removeClass("border-danger");
                                                                //         $('#error_cantidad_5').css('display', 'none');
                                                                //     };

                                                                $("#cantidad").removeClass("border-danger");
                                                                $('#error_cantidad2').css('display', 'none');
                                                            };
                                                    });
                                                break; 
                                        }
                                    

                            } 


                            function disponibilidadOrigen(oper){ 

                                var baseurl = "<?php echo base_url(); ?>";
                                cantidad  = document.getElementById("cantidad").value;
                                almacen = document.getElementById("id_almacen_origen_aux").value;
                                articulo = document.getElementById("id_articulo_aux").value;
                                document.querySelector("#id_almacen_origen").value=document.querySelector("#id_almacen_origen_aux").value;


                                        if(oper == "agregar" || oper == "editar"){
                                            $.post(baseurl+"index.php/Inv_inventario/get_inv_movimiento_saldo_actual",
                                            {
                                                        almacen: almacen,articulo:articulo
                                            },
                                            function(data){ //alert(data);
                                                    var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                                    if(resultado){
                                                        document.getElementById("disponibilidad_origen").value= parseFloat(resultado[0].saldo_final);
                                                    }else{
                                                        document.getElementById("disponibilidad_origen").value=0;
                                                    }
                                                    
                                            })
                                        }        
                            }; 

                            function disponibilidadDestino(oper){

                                // var baseurl = "<?php echo base_url(); ?>";
                                // cantidad  = document.getElementById("cantidad").value;
                                // almacen = document.getElementById("id_almacen_destino_aux").value;
                                // articulo = document.getElementById("id_articulo_aux").value;
                                // //var capacidad = document.getElementById("capacidad_almacen").value; 


                                //         if(oper == "agregar" || oper =="editar"){
                                //             $.post(baseurl+"index.php/Inv_inventario/get_inv_movimiento_saldo_actual",
                                //             {
                                //                         almacen: almacen,articulo:articulo
                                //             },
                                //             function(data){ //alert(data);
                                //                     var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                //                     if(resultado){
    
                                //                         document.getElementById("disponibilidad_destino").value= (parseFloat(capacidad) - parseFloat(resultado[0].saldo_final)).toFixed(2);
                                //                     }else{
                                //                         document.getElementById("disponibilidad_destino").value=capacidad;
                                //                     }
                                                    
                                //             })
                                //         }        


                            }  

                            function mostrar_unidad(valor){

                                var $select = $("#id_articulo_aux").change(function() {
                                // obtengo el value
                                var value = $(this).val();
                                // obtengo el texto segun el value
                                var text = $select.find('option[value=' + value + ']').text();
                                // imprime el seleccionado
                                let arr=text.split('-');
                                document.getElementById("disponibilidadOrigenLabel").innerHTML= `Disponibilidad Origen (${arr[1]})`;

                                });


                            }   
                            
                            function valida_almacen(oper){

                                var baseurl = "<?php echo base_url(); ?>";
                                cantidad  = document.getElementById("cantidad").value;
                                almacen = document.getElementById("id_almacen_destino_aux").value;
                                articulo = document.getElementById("id_articulo_aux").value;
                                document.querySelector("#id_almacen_destino").value=document.querySelector("#id_almacen_destino_aux").value;


                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Inv_recepcion/get_inv_recepcion_buscar_capacidad",
                                    {
                                                almacen: almacen,articulo:articulo
                                    },
                                    function(data){ //alert(data);

                                            
                                            // var resultado = JSON.parse(data); //convierto el valor devuelto a una matris
                                            // if(resultado){
                                            //     document.getElementById("capacidad_almacen").value = resultado[0].capacidad_almacen;
                                            // }else{
                                            //     document.getElementById("capacidad_almacen").value = 'No Posee';
                                            // }

                                           // disponibilidadDestino(oper);
                                        
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

                            function filtrarSelectDestino(IdSelected){
                                
                                let select=document.querySelector('#id_almacen_origen_aux');
                                let selectDestino=document.querySelector('#id_almacen_destino_aux');
                                let almacen_origen = document.getElementById("id_almacen_origen_aux").value;
                                
                                let arrDestino=[];

                                $("#id_almacen_destino_aux").empty();
                                const option = document.createElement('option');
                                option.value = null;
                                option.text = 'Seleccione';
                                selectDestino.appendChild(option);

                                for(let i=0; i < select.length; i++){
                                    if(select[i].value!='null' && select[i].value!=almacen_origen){
                                        const option2 = document.createElement('option');
                                        option2.value = select[i].value;
                                        option2.text = select[i].text;
                                        option2.selected = IdSelected!=null?select[i].value==IdSelected?true:false:false;
                                        selectDestino.appendChild(option2);
                                    }
 
                                }
                               
                            }

                            function asignarArticulo(){
                                document.querySelector("#id_articulo").value=document.querySelector("#id_articulo_aux").value;
                            }
                            
                            
                            
                                setTimeout(() => {
                                    let oper=document.querySelector("#operacion").value;
                                    let idAlmacenDestino=document.querySelector("#id_almacen_destino").value;
                                    if(oper=="editar"){
                                        
                                        filtrarSelectDestino(idAlmacenDestino);
                                    }
                                }, 1000);
                             
                            
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
                        <?php echo form_open('Inv_traslado/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                           
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="nombre_conflicto" name="cedula_conflicto" value="false">
                        <input type="hidden" id="operacion" value="<?php echo $oper;?>">


                        <div class="row">
                            <div class="col-md-6 float-left text-right container-fluid mt-2">
                                <?php

                                if( strlen($this->session->userdata('inv_traslado_mensaje_tipo')) > 0  ){ ?>
                                        <div class="alert <?php echo $this->session->userdata('inv_traslado_mensaje_tipo'); ?> text-center"><?php
                                            echo $this->session->userdata('inv_traslado_mensaje_contenido'); ?>
                                        </div><?php
                                        $s_mensaje = array(
                                                'inv_traslado_mensaje_tipo'         => '',
                                                'inv_traslado_mensaje_contenido'    => ''
                                        );
                                        $this->session->set_userdata($s_mensaje);
                                } ?>
                            </div>   
                        </div> 
                        <div class="row">
                            <div class="col-md-6 float-left">
                                <label>Artículo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_articulo_aux" name="id_articulo_aux" data-show-subtext="true" data-live-search="true" <?php if($oper=="agregar"){ echo ""; }else{ echo "disabled";} ?> onchange="mostrar_unidad();asignarArticulo();"><?php
                                    $valorSel  = $fila_registro->id_articulo;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_articulos); $j++){
                                        $valor_a_mostrar = $matriz_articulos[$j]->nombre;
                                        $valor = $matriz_articulos[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <input type="hidden" id="id_articulo" name="id_articulo" value="<?php if(isset($fila_registro->id_articulo )){ echo $fila_registro->id_articulo; } ?>">
                                <span id="error_id_articulo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                            <div class="col-md-6">
                                            <label for="fecha">Fecha de Traslado <span style="color:#F00;">*</span></label>
                                            <input class="form-control" type="text" id="fecha" name="fecha" value='<?php if( isset($fila_registro->fecha_traslado) ){ echo $fila_registro->fecha_traslado; }else{ echo date('d/m/Y'); } ?>' size="10" >
                                            <span id="error_fecha_de_ingreso" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i> 
                                                Seleccionar Fecha
                                            </span>
                                            <!-- <input type="hidden" name="fecha" id="fecha" value='<?php if( isset($fila_registro->fecha_traslado) ){ echo $fila_registro->fecha_traslado; }else{ echo date('d-m-Y'); } ?>'> -->
                            </div>
                            <div class="col-md-6 float-left">
                                <label>Almacén Origen<span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen_origen_aux" name="id_almacen_origen_aux" data-show-subtext="true" data-live-search="true" <?php if($oper=="agregar"){ echo ""; }else{ echo "disabled";} ?>  onchange="filtrarSelectDestino(null);disponibilidadOrigen('<?php echo $oper; ?>')"><?php
                                    $valorSel  = $fila_registro->id_almacen_origen;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_almacenes); $j++){
                                        $valor_a_mostrar = $matriz_almacenes[$j]->nombre;
                                        $valor = $matriz_almacenes[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <input type="hidden" id="id_almacen_origen" name="id_almacen_origen" value="<?php if(isset($fila_registro->id_almacen_origen )){ echo $fila_registro->id_almacen_origen; } ?>">
                                <span id="error_id_almacen_origen" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div> 
                            <div class="col-md-6 float-left">
                                <label>Almacén Destino<span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control" id="id_almacen_destino_aux" name="id_almacen_destino_aux" data-show-subtext="true" data-live-search="true" <?php if($oper=="agregar"){ echo ""; }else{ echo "disabled";} ?>  onchange="valida_almacen('<?php echo $oper; ?>');"><?php
                                    $valorSel  = $fila_registro->id_almacen_destino;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_almacenes); $j++){
                                        $valor_a_mostrar = $matriz_almacenes[$j]->nombre;
                                        $valor = $matriz_almacenes[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <input type="hidden" id="id_almacen_destino" name="id_almacen_destino" value="<?php if(isset($fila_registro->id_almacen_destino )){ echo $fila_registro->id_almacen_destino; } ?>">
                                <span id="error_id_almacen_destino" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div> 
                            <div class="col-md-6 container-fluid">
                                        <label id="disponibilidadOrigenLabel">Disponibilidad Origen<span style="color:#F00;"></span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="disponibilidad_origen" name="disponibilidad_origen" type="text" size="255" maxlength="255" readonly=true  value="<?php if( isset($fila_registro->disponibilidad_origen) ){ echo $fila_registro->disponibilidad_origen; } ?>">
                            </div>
                            <!-- <div class="col-md-6 container-fluid">
                                        <label>Capacidad Max  Destino<span style="color:#F00;"></span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="disponibilidad_destino" name="disponibilidad_destino" type="text" size="255" maxlength="255" readonly=true  value="<?php if( isset($fila_registro->disponibilidad_destino) ){ echo $fila_registro->disponibilidad_destino; } ?>">
                                        <input class="form-control" id="capacidad_almacen" name="capacidad_almacen" type="hidden" size="255" maxlength="255" readonly=true  value="<?php if( isset($fila_registro->capacidad_almacen) ){ echo $fila_registro->capacidad_almacen; } ?>">
                                    </div>   -->
                            <div class="col-md-6">
                                        <label>Cantidad <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input type="hidden" id="cantidadAux" name="cantidadAux" value="<?php if( isset($fila_registro->cantidad) ){ echo $fila_registro->cantidad; } ?>">
                                        <input class="form-control" id="cantidad" name="cantidad" type="text" placeholder="cantidad" value="<?php if( isset($fila_registro->cantidad) ){ echo $fila_registro->cantidad; } ?>" size="255" maxlength="255" onchange="valida_saldo('<?php echo $oper; ?>')">
                                        <span id="error_cantidad" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <span id="error_cantidad2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad excede la disponibilidad Almacen Origen
                                        </span>  
                                        <span id="error_cantidad_3" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad debe ser númerico
                                        </span> 
                                        <span id="error_cantidad_4" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad debe ser mayor a cero (0)
                                        </span>  
                                        <span id="error_cantidad_5" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cantidad excede la capacidad de almacen destino
                                        </span> 
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

                    <a href="<?php echo site_url('Inv_traslado/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>