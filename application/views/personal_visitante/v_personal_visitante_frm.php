<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fa fas fa-users fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Personal</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Personal</span><?php
                                        $oper_g = "editar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;
                                var soloNumero= /^([0-9])+$/;

                                if(document.getElementById("cedula").value.length < 1)
                                {
                                    $("#cedula").addClass("border-danger");
                                    $('#error_cedula').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#cedula").removeClass("border-danger");
                                    $('#error_cedula').css('display', 'none');
                                };
                                
                                /*VALIDA QUE CEDULA SEA SOLO NUMERO*/
                                $("#cedula").removeClass("border-danger");
                                $('#error_cedula_3').css('display', 'none');
                                if(document.getElementById("cedula").value.length < 1){
                                }else{
                                    if(soloNumero.test(document.getElementById("cedula").value) ) {
                                    }else{
                                        $("#cedula").addClass("border-danger");
                                        $('#error_cedula_3').css('display', 'block');
                                        ok = false;
                                    }

                                };                                
                                
                                cedula_conflicto = document.getElementById("cedula_conflicto").value;
                                if(cedula_conflicto == "true"){
                                    $("#cedula").addClass("border-danger");
                                    ok = false;
                                }                                
                                
                                if(document.getElementById("nombres").value.length < 1)
                                {
                                    $("#nombres").addClass("border-danger");
                                    $('#error_nombres').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#nombres").removeClass("border-danger");
                                    $('#error_nombres').css('display', 'none');
                                };
                             
                                if(document.getElementById("id_personal_visitante_tipo").value == 'null')
                                {
                                    $("#id_personal_visitante_tipo").addClass("border-danger");
                                    $('#error_personal_visitante_tipo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_personal_visitante_tipo").removeClass("border-danger");
                                    $('#error_personal_visitante_tipo').css('display', 'none');
                                };                             

                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');
                                    return ok;
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                }
                            };
                            
                            function valida_cedula(){
                                var baseurl = "<?php echo base_url(); ?>";
                                cedula = document.getElementById("cedula").value;                                
                                
                                 
                                
                                /*VALIDA QUE CEDULA NO SE REPITA*/
                                $.post(baseurl+"index.php/Personal_visitante/get_personal_visitante_buscar_4",
                                {
                                        cedula: cedula
                                },
                                function(data){ //alert(data);
                                        var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris
                                        if(matriz_personal == false){
                                            $("#cedula").removeClass("border-danger");
                                            $('#error_cedula_2').css('display', 'none');
                                            document.getElementById("cedula_conflicto").value = "false";
                                        }else{
                                            $("#cedula").addClass("border-danger");
                                            $('#error_cedula_2').css('display', 'block');
                                            document.getElementById("cedula_conflicto").value = "true";
                                        }
                                });
                            }
                            function valida_carnet_codigo(oper){
                                var baseurl = "<?php echo base_url(); ?>";
                                carnet_codigo  = document.getElementById("carnet_codigo").value;
                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Personal_visitante/get_personal_visitante_buscar_6",
                                    {
                                                carnet_codigo: carnet_codigo
                                    },
                                    function(data){ //alert(data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_personal == false){
                                                $("#carnet_codigo").removeClass("border-danger");
                                                $('#error_carnet_codigo').css('display', 'none');
                                                document.getElementById("carnet_codigo_conflicto").value = "false";
                                            }else{
                                                $("#carnet_codigo").addClass("border-danger");
                                                $('#error_carnet_codigo').css('display', 'block');
                                                document.getElementById("carnet_codigo_conflicto").value = "true";
                                            }
                                    });
                                }

                                if(oper == "editar"){
                                    id = document.getElementById("id").value;
                                    $.post(baseurl+"index.php/Personal_visitante/get_personal_buscar_5",
                                    {
                                                carnet_codigo: carnet_codigo
                                            ,   id: id
                                    },
                                    function(data){ //alert(data);
                                            var matriz_personal = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_personal == false){
                                                $("#carnet_codigo").removeClass("border-danger");
                                                $('#error_carnet_codigo').css('display', 'none');
                                                document.getElementById("carnet_codigo_conflicto").value = "false";
                                            }else{
                                                $("#carnet_codigo").addClass("border-danger");
                                                $('#error_carnet_codigo').css('display', 'block');
                                                document.getElementById("carnet_codigo_conflicto").value = "true";
                                            }
                                    });                                    
                                }
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
                        <?php echo form_open('Personal_visitante/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_personal->id) ){ echo $fila_personal->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="cedula_conflicto" name="cedula_conflicto" value="false">
                        <input type="hidden" id="carnet_codigo_conflicto" name="carnet_codigo_conflicto" value="false">

                        <div class="row">
                            <div class="col-md-6 container-fluid">
                                
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <label>C&eacute;dula <span style="color:#F00;">*</span></label>
                                        <br />
                                        <?php
                                        //echo "fila_personal *"; print_r($fila_personal); echo "*";
                                        ?>
                                        <input class="form-control" id="cedula" name="cedula" type="text" placeholder="C&eacute;dula" value="<?php if( isset($fila_personal->cedula) ){ echo $fila_personal->cedula; } ?>" size="10" maxlength="10" <?php if($oper == 'ver' or $oper == 'editar'){ echo "readonly='true'"; } ?> onchange="valida_cedula()">
                                        <span id="error_cedula" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>  
                                        <span id="error_cedula_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La cédula, ya se encuentra en uso
                                        </span>
                                        <span id="error_cedula_3" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            El valor del campo debe ser sólo Número
                                        </span>                                        
                                    </div>
                                    <div class="col-md-12 float-left mt-3">
                                        <label>Nombres <span style="color:#F00;">*</span></label>
                                        <br />
                                        <input class="form-control" id="nombres" name="nombres" type="text" placeholder="Nombres" value="<?php if( isset($fila_personal->nombres) ){ echo $fila_personal->nombres; } ?>" size="45" maxlength="45"  <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                        <span id="error_nombres" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>

                                    <div class="col-md-12 float-left mt-3">
                                        <label>Apellidos</label>
                                        <br />
                                        <input class="form-control" id="apellidos" name="apellidos" type="text" placeholder="Apellidos" value="<?php if( isset($fila_personal->apellidos) ){ echo $fila_personal->apellidos; } ?>" size="45" maxlength="45" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                    </div>
                                    
                                </div>                                
                                

                            </div>
                            <div class="col-md-6  text-center mt-3"><?php  
                                if($oper == 'editar'){
                                    if( $fila_personal->imagen_nombre == "" ){ 
                                        $ruta = base_url("images/personal_visitante/")."sin_imagen.png";
                                    }else{ 
                                        $ruta = base_url("images/personal_visitante/").$fila_personal->imagen_nombre;                                     
                                    } ?>
                                    <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px">                                
                                    <br /><br />
                                    <a href="<?=site_url('Personal_visitante/subir_archivo/').$fila_personal->id; ?>">
                                        <button type="button" class="btn btn-outline-secondary">Cambiar Imagen</button>
                                    </a>
                                    <?php                                    
                                } ?>
                            </div>
                        </div>                            
                            
                        <?php /*
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Cargo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white" id="id_cargo" name="id_cargo"><?php
                                    $valorSel  = $fila_personal->id_cargo;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_cargos); $j++){
                                        $valor_a_mostrar = $matriz_cargos[$j]->nombre;
                                        $valor = $matriz_cargos[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_cargo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>                            
                         
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Gerencia <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white" id="id_gerencia" name="id_gerencia"><?php
                                    $valorSel  = $fila_personal->id_gerencia;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_gerencias); $j++){
                                        $valor_a_mostrar = $matriz_gerencias[$j]->nombre;
                                        $valor = $matriz_gerencias[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_gerencia" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>
                         * 
                         */ ?>

                        <?php /*
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Tipo de Personal </label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white" id="tipo_personal" name="tipo_personal"><?php
                                    $valorSel  = $fila_personal->tipo_personal;
                                    
                                    $valor_a_mostrar = "Personal del visitante";
                                    $valor = 1;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                    <?php
                                    $valor_a_mostrar = "Visitante";
                                    $valor = 2;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                </select>                                
                            </div>
                        </div> */ ?>
                            
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Tipo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg_color_3 text-white" id="id_personal_visitante_tipo" name="id_personal_visitante_tipo"><?php
                                    $valorSel  = $fila_personal->id_personal_visitante_tipo;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_personal_visitante_tipo); $j++){
                                        $valor_a_mostrar = $matriz_personal_visitante_tipo[$j]->nombre;
                                        $valor = $matriz_personal_visitante_tipo[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_personal_visitante_tipo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>                         
                        
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Estado </label>
                                <br />
                                <select class="form-control bg_color_3 text-white" id="estado" name="estado"><?php
                                    $valorSel  = $fila_personal->estado;
                                    
                                    $valor_a_mostrar = "Activo";
                                    $valor = 1;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                    <?php
                                    $valor_a_mostrar = "No Activo";
                                    $valor = 2;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                </select>                                
                            </div>
                        </div>                            
                            
                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>

                    <a href="<?php echo site_url('Personal_visitante/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>