<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-sitemap fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar Centro</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'editar': ?>
                                        <span class="text-white">Editar Centro</span><?php
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

                                if(document.getElementById("id_gerencia_2").value == 'null')
                                {
                                    $("#id_gerencia_2").addClass("border-danger");
                                    $('#error_id_gerencia_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_gerencia_2").removeClass("border-danger");
                                    $('#error_id_gerencia_2').css('display', 'none');
                                };

                                if(ok == true){
                                    nombre_conflicto = document.getElementById("nombre_conflicto").value;
                                    if(nombre_conflicto == "true"){
                                        $("#nombre").addClass("border-danger");
                                        ok = false;
                                    }else{
                                        $('#error_nombre_2').css('display', 'none');
                                    }
                                } 

                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                }
                                return ok;
                            };

                            function valida_nombre(oper){

                                var baseurl = "<?php echo base_url(); ?>";
                                nombre  = document.getElementById("nombre").value;
                                nombre = nombre.trim();

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Gerencias/get_gerencias_buscar_6",
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
                                    $.post(baseurl+"index.php/Gerencias/get_gerencias_buscar_5",
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
                        <?php echo form_open('Gerencias/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="nombre_conflicto" name="nombre_conflicto" value="false">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="comedor_comida_tipo_id_2">Gerencia <span style="color:#F00;">*</span></label>
                                <select class="form-control selectpicker" id="id_gerencia_2" name="id_gerencia_2" data-show-subtext="true" data-live-search="true"><?php
                                    if(isset($fila_registro->id_gerencia_2)){ $valorSel  = $fila_registro->id_gerencia_2; }else{ $valorSel = ""; }
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_gerencias_2); $j++){
                                        $valor_a_mostrar = $matriz_gerencias_2[$j]->nombre;
                                        $valor = $matriz_gerencias_2[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }
                                    ?>
                                </select>
                                <span id="error_id_gerencia_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i> 
                                    Seleccione el campo
                                </span>
                            </div>                                                    
                        </div>

                        
                        <div class="row mt-3">
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
                        </div>                            
                            
                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>

                    <a href="<?php echo site_url('Gerencias/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>