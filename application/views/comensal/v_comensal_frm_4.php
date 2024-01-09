<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-calendar-day fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Programación de Comensales</span><?php
                                        $oper_g = "agregar_3";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;

                            
                                if(document.getElementById("fecha").value.length < 1)
                                {
                                    $("#fecha").addClass("border-danger");
                                    $('#error_fecha').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#fecha").removeClass("border-danger");
                                    $('#error_fecha').css('display', 'none');
                                };     

                                if(document.getElementById("comedor_comida_tipo_id").value == 'null')
                                {
                                    $("#comedor_comida_tipo_id").addClass("border-danger");
                                    $('#error_comedor_comida_tipo_id').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#comedor_comida_tipo_id").removeClass("border-danger");
                                    $('#error_comedor_comida_tipo_id').css('display', 'none');
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
                                    return ok;
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                }
                            };

                            /*
                            function valida_nombre(oper){

                                var baseurl = "<?php //echo base_url(); ?>";
                                nombre  = document.getElementById("nombre").value;
                                nombre = nombre.trim();

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Cargos/get_cargos_buscar_6",
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
                                    $.post(baseurl+"index.php/Cargos/get_cargos_buscar_5",
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
                            } */
                            
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
                        <?php echo form_open('Comensal/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_registro->id) ){ echo $fila_registro->id; } ?>" ><?php
                        } ?>
                        <input type="hidden" id="nombre_conflicto" name="cedula_conflicto" value="false">

                        <div class="row">
                            <div class="col-md-6 container-fluid">
                                    <label for="fecha">FECHA</label>
                                    <input class="form-control" type="text" id="fecha" name="fecha" value='<?php if( isset($fecha) ){ echo $fecha; } ?>' readonly="readonly" size="10" >
                                    <span id="error_fecha" style="display: none" class="text-danger error-camp">
                                        <i class="fa fa-exclamation-circle fa-2x"></i> 
                                        Seleccionar Fecha
                                    </span>
                            </div>
                            <div class="col-md-6 container-fluid">
                                    <label for="comedor_comida_tipo_id">TIPO</label>
                                    <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="comedor_comida_tipo_id" name="comedor_comida_tipo_id" data-show-subtext="true" data-live-search="true"><?php
                                        $valorSel  = $comedor_comida_tipo_id;
                                        ?><option value="null">Seleccione</option><?php
                                        for($j = 0; $j < count($matriz_comedor_comida_tipo); $j++){
                                            $valor_a_mostrar = $matriz_comedor_comida_tipo[$j]->nombre;
                                            $valor = $matriz_comedor_comida_tipo[$j]->id;  ?>
                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                        }
                                        ?>
                                    </select>
                                    <span id="error_comedor_comida_tipo_id" style="display: none" class="text-danger error-camp">
                                        <i class="fa fa-exclamation-circle fa-2x"></i> 
                                        Seleccionar Tipo
                                    </span>                                
                            </div>
                        </div>                            
                            
                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Continuar" value="Continuar">
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>

                        <a href="<?php echo site_url('Comensal/listar_programados/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>