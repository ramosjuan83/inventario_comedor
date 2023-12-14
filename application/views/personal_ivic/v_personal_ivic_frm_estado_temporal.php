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
                                case 'agregar_estado_temporal': ?>
                                        <span class="text-white">Agregar estado temporal</span><?php
                                        $oper_g = "agregar_guardar_estado_temporal";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(f){
                                var ok = true;
                                var soloNumero= /^([0-9])+$/;
                                
                                //if(document.getElementById("b_fecha_desde").value.length < 1 || document.getElementById("b_fecha_hasta").value.length < 1)
                                
                                if(document.getElementById("b_fecha_desde").value == "" 
                                //or document.getElementById("b_fecha_hasta").value == ""
                                )
                                {
                                    $("#b_fecha_desde").addClass("border-danger");
                                    $("#b_fecha_hasta").addClass("border-danger");
                                    $('#error_fecha_desde_hasta').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#b_fecha_desde").removeClass("border-danger");
                                    $("#b_fecha_hasta").removeClass("border-danger");
                                    $('#error_fecha_desde_hasta').css('display', 'none');
                                }; 

                                if(document.getElementById("id_estados").value == 'null')
                                {
                                    $("#id_estados").addClass("border-danger");
                                    $('#error_id_estados').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_estados").removeClass("border-danger");
                                    $('#error_id_estados').css('display', 'none');
                                };

                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');
                                    return ok;
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                }
                            };
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
                        <?php echo form_open('Personal_ivic/'.$oper_g, $atributos2); ?>
                        
                        <input type="hidden" id="personal_ivic_id" name="personal_ivic_id" value="<?php echo $id; ?>">
                        
                        
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Estado <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg_color_3 text-white" id="id_estados" name="id_estados"><?php
                                    $valorSel  = "";//$fila_personal->estado;
                                    for($i = 0; $i < count($matriz_estados); $i++){
                                        $valor           = $matriz_estados[$i]->id;
                                        $valor_a_mostrar = $matriz_estados[$i]->nombre;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    } ?>
                                </select>
                                <span id="error_id_estados" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>                                
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <!--div class="form-group col-md-6"-->
                                <div class="shards-demo">
                                    <i class="fas fa-calendar-alt lisa_text_blue"></i>
                                    <label>FECHA <span style="color:#F00;">*</span></label>
                                    <br >                                        
                                    <div class="input-daterange input-group" id="datepicker-example"><?php
                                        $b_fecha_desde = "";
                                        $b_fecha_hasta = "";
                                        ?>
                                        <input type="text" class="input-sm form-control" name="b_fecha_desde" id="b_fecha_desde" placeholder="Desde" value="<?php echo $b_fecha_desde; ?>" readonly/>
                                        <input type="text" class="input-sm form-control" name="b_fecha_hasta" id="b_fecha_hasta" placeholder="Hasta" value="<?php echo $b_fecha_hasta; ?>" readonly/>
                                    </div>
                                </div>
                                <span id="error_fecha_desde_hasta" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
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

                    <a href="<?=site_url('Personal_ivic/editar/'.$id)?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>                
                </div>

            <!--</div>-->
        </div>
    </div>
</div>