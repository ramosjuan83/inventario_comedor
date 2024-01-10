<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-list-ul fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Artículo</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Artículo</span><?php
                                        $oper_g = "editar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;

                                if(document.getElementById("nombre").value.length < 1)
                                {
                                    $("#nombre").addClass("border-danger");
                                    $('#error_nombre').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#nombre").removeClass("border-danger");
                                    $('#error_nombre').css('display', 'none');
                                };

                                // if(document.getElementById("codigo").value.length < 1)
                                // {
                                //     $("#codigo").addClass("border-danger");
                                //     $('#error_codigo').css('display', 'block');
                                //     ok = false;
                                // }else{
                                //     $("#codigo").removeClass("border-danger");
                                //     $('#error_codigo').css('display', 'none');
                                // };

                                if(document.getElementById("id_unidad_medida").value == 'null')
                                {
                                    $("#id_unidad_medida").addClass("border-danger");
                                    $('#error_id_unidad_medida').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_unidad_medida").removeClass("border-danger");
                                    $('#error_id_unidad_medida').css('display', 'none');
                                };

                                
                                if(document.getElementById("id_tipo_articulo").value == 'null')
                                {
                                    $("#id_tipo_articulo").addClass("border-danger");
                                    $('#error_id_tipo_articulo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_tipo_articulo").removeClass("border-danger");
                                    $('#error_id_tipo_articulo').css('display', 'none');
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
                                if(ok == true){
                                    codigo_conflicto = document.getElementById("codigo_conflicto").value;
                                    if(codigo_conflicto == "true"){
                                        $("#codigo").addClass("border-danger");
                                        ok = false;
                                    }else{
                                        $('#error_codigo_2').css('display', 'none');
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

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Inv_articulo/get_inv_articulo_buscar_6",
                                    {
                                                nombre: nombre
                                    },
                                    function(data){ //alert(data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_personal == false){
                                                $("#nombre").removeClass("border-danger");
                                                $('#error_nombre_2').css('display', 'none');
                                                document.getElementById("nombre_conflicto").value = "false";
                                            }else{
                                                $("#nombre").addClass("border-danger");
                                                $('#error_nombre_2').css('display', 'block');
                                                document.getElementById("nombre_conflicto").value = "true";
                                            }
                                    });
                                }

                                if(oper == "editar"){
                                    
                                    id = document.getElementById("id").value;
                                    $.post(baseurl+"index.php/Inv_articulo/get_inv_articulo_buscar_5",
                                    {
                                                nombre: nombre
                                            ,   id: id
                                    },
                                    function(data){ //alert(data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris
                                            if(matriz_personal == false){
                                                $("#nombre").removeClass("border-danger");
                                                $('#error_nombre_2').css('display', 'none');
                                                document.getElementById("nombre_conflicto").value = "false";
                                            }else{
                                                $("#nombre").addClass("border-danger");
                                                $('#error_nombre_2').css('display', 'block');
                                                document.getElementById("nombre_conflicto").value = "true";
                                            }
                                    });                                    
                                }
                            }

                            function valida_codigo(oper){

                                var baseurl = "<?php echo base_url(); ?>";
                                codigo  = document.getElementById("codigo").value;
                                codigo = codigo.trim();

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Inv_articulo/get_inv_articulo_buscar_7",
                                    {
                                                codigo: codigo
                                    },
                                    function(data){ //alert(data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_personal == false){
                                                $("#codigo").removeClass("border-danger");
                                                $('#error_codigo_2').css('display', 'none');
                                                document.getElementById("codigo_conflicto").value = "false";
                                            }else{
                                                $("#codigo").addClass("border-danger");
                                                $('#error_codigo_2').css('display', 'block');
                                                document.getElementById("codigo_conflicto").value = "true";
                                            }
                                    });
                                }

                                if(oper == "editar"){
                                    
                                    id = document.getElementById("id").value;
                                    $.post(baseurl+"index.php/Inv_articulo/get_inv_articulo_buscar_8",
                                    {
                                                codigo: codigo
                                            ,   id: id
                                    },
                                    function(data){
                                            console.log("data",data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris
                                            if(matriz_personal == false){
                                                $("#codigo").removeClass("border-danger");
                                                $('#error_codigo_2').css('display', 'none');
                                                document.getElementById("codigo_conflicto").value = "false";
                                            }else{
                                                $("#codigo").addClass("border-danger");
                                                $('#error_codigo_2').css('display', 'block');
                                                document.getElementById("codigo_conflicto").value = "true";
                                            }
                                    });                                    
                                }
                            }

                            function subirArchivos(){
                                if(validar_control_file() == true){
                                        var baseurl = "<?php echo base_url(); ?>";
                                        id = document.getElementById("id").value;
                                        $("#archivo").upload(baseurl+"index.php/Inv_articulo/get_subir_archivo",
                                        {
                                            id: id
                                        },
                                        function(respuesta){
                                            $("#barra_de_progreso").val(0);
                                            //mostrarRespuesta(respuesta, true);
                                            //alert("respuesta *"+respuesta+"*");
                                            if (respuesta === 1){
                                                $("#barra_de_progreso").val(100);
                                                mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                                            } else {
                                                mostrarRespuesta('El archivo NO se ha podido subir.', false);
                                            }
////mostrarArchivos();
                                        }, function(progreso, valor){
                                            valor = valor - 5;
                                            $("#barra_de_progreso").val(valor);
                                        });                                    
                                }
                            }

                            function mostrarRespuesta(mensaje, ok){
                                $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
                                if(ok){
                                    $("#respuesta").addClass('alert-success');
                                }else{
                                    $("#respuesta").addClass('alert-danger');
                                }
                            }


                            function validar_control_file(){
                                f = document.getElementById("archivo");
                                var extenciones_permitidas = ['jpg','jpeg','png'];
                                valido = true;
                                valido = control_file_validar_tipo_de_archivo(f, extenciones_permitidas);   //alert("valido *"+valido+"*");
                                if(valido == true){
                                    $("#archivo").removeClass("border-danger");
                                    $('#error_archivo').css('display', 'none');                                                            
                                }else{
                                    $("#archivo").addClass("border-danger");
                                    $('#error_archivo').css('display', 'block');
                                };
                                if(valido == true){
                                    valido = control_file_validar_tamano(f);    
                                    if(valido == true){
                                        $("#archivo").removeClass("border-danger");
                                        $('#error_archivo_2').css('display', 'none');                                                            
                                    }else{
                                        $("#archivo").addClass("border-danger");
                                        $('#error_archivo_2').css('display', 'block');
                                    };
                                }
                                //if(valido==false){f.value='';}
                                return valido;
                            }

                            //extenciones_permitidas = ['gif','jpg','jpeg','png','bmp'];
                            function control_file_validar_tipo_de_archivo(f, extenciones_permitidas){
                                    var v=f.value.split('.').pop().toLowerCase();
                                    for(var i=0,n;n=extenciones_permitidas[i];i++){
                                        if(n.toLowerCase()==v)
                                            return true
                                    }
                                    var t=f.cloneNode(true);
                                    t.value='';
                                    f.parentNode.replaceChild(t,f);
                                    return false;
                            }
                            //el tamano_maximo_permitido se carga con el valor colocado en la propiedad size del control
                            function control_file_validar_tamano(f){
                                    var sizeByte = f.files[0].size;
                                    var siezekiloByte = parseInt(sizeByte / 1024);
                                    var tamano_maximo_permitido = f.size;
                                    if( siezekiloByte > tamano_maximo_permitido ){ return false; }
                                    else{ return true; }
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
                            'role' => 'form',
                            'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php echo form_open('Inv_articulo/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } else { ?>
                        
                            <input type="hidden" id="id" name="id" value="5" ><?php
                        }
                        ?>
                        <input type="hidden" id="nombre_conflicto" name="cedula_conflicto" value="false">
                        <input type="hidden" id="codigo_conflicto" name="codigo_conflicto" value="false">
                        <!-- <input type="hidden" id="id" name="id" value="<?php if( isset($id) ){ echo $id; } ?>" > -->
                        <!-- <input type="hidden" id="id" name="id" value="14662" > -->

                        
                        <div class="row">
                            <?php if($oper == 'editar'){ ?>
                            <div class="col-md-12 container-fluid">
                                        <label>Código</label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="codigo" name="codigo" type="text" readonly=true placeholder="Código" value="<?php if( isset($fila_registro->codigo) ){ echo $fila_registro->codigo; } ?>" size="255" maxlength="255" onchange="valida_codigo('<?php echo $oper; ?>')">
                                        <span id="error_codigo" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <span id="error_codigo_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            El valor del campo, ya existe
                                        </span>
                            </div>
                            <?php } ?>    
                            <div class="col-md-12 container-fluid">
                                        <label>Nombre <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_registro); echo "*";
                                        ?>
                                        <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre" value="<?php if( isset($fila_registro->nombre) ){ echo $fila_registro->nombre; } ?>" size="255" maxlength="255" onchange="valida_nombre('<?php echo $oper; ?>')">
                                        <span id="error_nombre" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <span id="error_nombre_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            El valor del campo, ya existe
                                        </span>
                            </div>
                            <div class="col-md-6 float-left">
                                <label>Tipo de Artículo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control" id="id_tipo_articulo" name="id_tipo_articulo" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_registro->id_tipo_articulo;
                                    ?>
                                <option value="null">Seleccione</option><?php
                                for($j = 0; $j < count($matriz_tipo_articulos); $j++){
                                        $valor_a_mostrar = $matriz_tipo_articulos[$j]->nombre;
                                        $valor = $matriz_tipo_articulos[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                }?>
                                </select>
                                <span id="error_id_tipo_articulo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                            <div class="col-md-6 float-left">
                                <label>Unidad Medida <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control" id="id_unidad_medida" name="id_unidad_medida" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_registro->id_unidad_medida;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_unidades); $j++){
                                        $valor_a_mostrar = $matriz_unidades[$j]->nombre;
                                        $valor = $matriz_unidades[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_unidad_medida" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                            <!-- <div class="col-md-6 float-left">
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
                                <span id="error_id_unidad_medida" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div> -->
                            <div class="col-md-12 container-fluid">
                                <label>Observación</label>
                                <br />
                                <textarea class="form-control"  id="observacion" name="observacion" size="255" maxlength="255"> <?php if( isset($fila_registro->observacion) ){ echo $fila_registro->observacion; } ?> </textarea>

                            </div>

                            <div class="col-md-12 container-fluid">
                                    <label>Subir imagen <span style="color:#F00;">*</span></label>
                                    <br />
                                    <input type="file" name="archivo" id="archivo"  size="3000" onchange="validar_control_file()" />
                                    <span style='font-size:smaller'>Formatos aceptados.: jpg, jpeg, png.</span>
                                    <span id="error_archivo" style="display: none" class="text-danger error-camp">
                                        <i class="fa fa-exclamation-circle fa-2x"></i>
                                        El formato no es válido
                                    </span>
                                    <span id="error_archivo_2" style="display: none" class="text-danger error-camp">
                                        <i class="fa fa-exclamation-circle fa-2x"></i>
                                        El peso del archivo supera el limite permitido
                                    </span>
                                </div>
                                <div class="col-md-8 float-left">
                                    <div id="respuesta" class="alert"></div>
                                </div>
                            </div>   
                            
                            <!-- <div class="col-md-12 container-fluid">
                                <div class="col-md-4 float-left">
                                    <!--input class="btn btn-outline-sigalsx4-purpple" type="submit" name="Guardar" value="Guardar"-->
                                    <!-- <a href="#" onclick="subirArchivos()">
                                        <button type="button" class="btn btn-outline-sigalsx4-purpple">Subir</button>
                                    </a>                             
                                </div>
                                <div class="col-md-6 float-left">
                                    <progress id="barra_de_progreso" value="0" max="100"></progress>                               
                                </div>                                 -->
                            <!-- </div> -->
                            <div class="row mt-4">
                                <div class="col-md-2 float-left">
                                    <div id="archivos_subidos"></div>                        
                                </div>
                            </div>
                            
                            <div class="col-md-6  text-center mt-3"><?php  
                                if($oper != 'agregar'){

                                } 
                                if($oper == 'editar'){
                                    if( $fila_registro->imagen_articulo == "" ){ 
                                        $ruta = base_url("images/articulo/")."sin_imagen.png";
                                    }else{ 
                                        $ruta = base_url("images/articulo/").$fila_registro->imagen_articulo;                                     
                                    } ?>
                                    <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px">                                
                                    <br /><br />
                                    <!-- <a href="<?=site_url('Inv_articulo/subir_archivo/').$fila_registro->id; ?>">
                                        <button type="button" class="btn btn-outline-secondary">Cambiar Imagen</button>
                                    </a> -->
                                    <?php                                    
                                } ?>
                            </div>
                        </div>                            
                            
                        <div class="col-md-12 container-fluid">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                        <div class="col-md-12 container-fluid"></div>    
                        
                        <?php echo form_close(); ?>
                    </div>

                    <a href="<?php echo site_url('Inv_articulo/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>