<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 60rem">
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
                                
                                if(document.getElementById("carnet_codigo").value.length < 1)
                                {
                                    $("#carnet_codigo").addClass("border-danger");
                                    $('#error_carnet_codigo_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#carnet_codigo").removeClass("border-danger");
                                    $('#error_carnet_codigo_2').css('display', 'none');
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
                                

                                if(document.getElementById("id_cargo").value == 'null')
                                {
                                    $("#id_cargo").addClass("border-danger");
                                    $('#error_cargo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_cargo").removeClass("border-danger");
                                    $('#error_cargo').css('display', 'none');
                                };

                                if(document.getElementById("id_categoria").value == 'null')
                                {
                                    $("#id_categoria").addClass("border-danger");
                                    $('#error_id_categoria').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_categoria").removeClass("border-danger");
                                    $('#error_id_categoria').css('display', 'none');
                                };

                                if(document.getElementById("id_gerencia").value == 'null')
                                {
                                    $("#id_gerencia").addClass("border-danger");
                                    $('#error_gerencia').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_gerencia").removeClass("border-danger");
                                    $('#error_gerencia').css('display', 'none');
                                };
                                
                                if(document.getElementById("id_gerencia_2").value == 'null')
                                {
                                    $("#id_gerencia_2").addClass("border-danger");
                                    $('#error_gerencia_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_gerencia_2").removeClass("border-danger");
                                    $('#error_gerencia_2').css('display', 'none');
                                };

                                if(document.getElementById("id_tipo").value == 'null')
                                {
                                    $("#id_tipo").addClass("border-danger");
                                    $('#error_id_tipo').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_tipo").removeClass("border-danger");
                                    $('#error_id_tipo').css('display', 'none');
                                };
                                
                                if(document.getElementById("id_condicion").value == 'null')
                                {
                                    $("#id_condicion").addClass("border-danger");
                                    $('#error_id_condicion').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_condicion").removeClass("border-danger");
                                    $('#error_id_condicion').css('display', 'none');
                                };

                                if(document.getElementById("id_departamento").value == 'null')
                                {
                                    $("#id_departamento").addClass("border-danger");
                                    $('#error_id_departamento').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#id_departamento").removeClass("border-danger");
                                    $('#error_id_departamento').css('display', 'none');
                                };
                                
                                
                                carnet_codigo_conflicto = document.getElementById("carnet_codigo_conflicto").value;
                                if(carnet_codigo_conflicto == "true"){
                                    $("#carnet_codigo").addClass("border-danger");
                                    ok = false;
                                }                                

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
                                $.post(baseurl+"index.php/Personal_ivic/get_personal_ivic_buscar_4",
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
                                    $.post(baseurl+"index.php/Personal_ivic/get_personal_ivic_buscar_6",
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
                                    $.post(baseurl+"index.php/Personal_ivic/get_personal_buscar_5",
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
                            
                            function carga_id_gerencia(){
                                id_gerencia_2 = document.getElementById("id_gerencia_2").value;
                                
                                if(id_gerencia_2 == "null"){
                                    $('#id_gerencia').html('');
                                    $('#id_departamento').html('');
                                }

                                var baseurl = "<?php echo base_url(); ?>";
                                $.post(baseurl+"index.php/Gerencias/get_gerencias_buscar_7",
                                {
                                        id_gerencia_2: id_gerencia_2
                                },
                                function(data){ //alert(data); //[{"id":"1","id_gerencia_2":"1","nombre":"AUDITORIA INTERNA"},{"id":"2","id_gerencia_2":"1","nombre":"DIRECCI\u00d3N"},{"id":"3","id_gerencia_2":"1","nombre":"OFICINA DE ATENCI\u00d3N AL CIUDADANO"}]
                                        var matriz_gerencia = JSON.parse(data); //convierto el valor devuelto a una matris
                                        $('#id_gerencia').html('');
                                        //alert("PASO2");
                                        $('#id_gerencia').append('<option value="null">Seleccione</option>');
                                        $.each(matriz_gerencia, function(i, item){
                                                $('#id_gerencia').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                                        });
                                }); 
                                
                                carga_id_departamento();
                                //carga_los_periodos();

                            }   
                            function carga_id_departamento(){
                                id_gerencia = document.getElementById("id_gerencia").value;

                                var baseurl = "<?php echo base_url(); ?>";
                                $.post(baseurl+"index.php/Departamento/get_departamento_buscar_7",
                                {
                                        id_gerencia: id_gerencia
                                },
                                function(data){ //alert(data); //[{"id":"23","id_gerencia":"6","nombre":"CONSULTOR\u00cdA JUR\u00cdDICA"},{"id":"24","id_gerencia":"6","nombre":"COORDINACI\u00d3N DE ASUNTOS JUDICIALES"},{"id":"25","id_gerencia":"6","nombre":"COORDINACI\u00d3N DE DICT\u00c1MENES Y OPINIONES"},{"id":"26","id_gerencia":"6","nombre":"COORDINACI\u00d3N DE ASUNTOS NORMATIVOS, CONTRATOS Y CONVENIOS"}]
                                        //if(data != "false"){
                                            var matriz_departamento = JSON.parse(data); //convierto el valor devuelto a una matris
                                            $('#id_departamento').html('');
                                            //alert("PASO2");
                                            $('#id_departamento').append('<option value="null">Seleccione</option>');
                                            $.each(matriz_departamento, function(i, item){
                                                    $('#id_departamento').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                                            });
                                        //}

                                }); 
                                
                                //carga_asignaturas_ofertadas();
                                //carga_los_periodos();

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
                        <?php echo form_open('Personal_ivic/'.$oper_g, $atributos2);

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
                                    
                                    <div class="col-md-6 float-left mt-3">
                                        <label>Código del Carnet <span style="color:#F00;">*</span></label>
                                        <br />
                                        <input class="form-control" id="carnet_codigo" name="carnet_codigo" type="text" placeholder="" value="<?php if( isset($fila_personal->carnet_codigo) ){ echo $fila_personal->carnet_codigo; } ?>" size="6" maxlength="6" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?> onchange="valida_carnet_codigo('<?php echo $oper; ?>')">
                                        <span id="error_carnet_codigo" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            El código del carnet, ya se encuentra en uso
                                        </span>
                                        <span id="error_carnet_codigo_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>
                                    <div class="col-md-6 container-fluid mt-3">
                                            <label for="fecha">Fecha de Ingreso <span style="color:#F00;">*</span></label>
                                            <input class="form-control" type="text" id="fecha" name="fecha_de_ingreso" value='<?php if( isset($fila_personal->fecha_ingreso) ){ echo $fila_personal->fecha_ingreso; } ?>' readonly="readonly" size="10" >
                                            <span id="error_fecha_de_ingreso" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i> 
                                                Seleccionar Fecha
                                            </span>
                                    </div>                                    
                                </div>                                
                                

                            </div>
                            <div class="col-md-6  text-center mt-3"><?php  
                                if($oper != 'agregar'){

                                } 
                                if($oper == 'editar'){
                                    if( $fila_personal->imagen_nombre == "" ){ 
                                        $ruta = base_url("images/personal_ivic/")."sin_imagen.png";
                                    }else{ 
                                        $ruta = base_url("images/personal_ivic/").$fila_personal->imagen_nombre;                                     
                                    } ?>
                                    <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px">                                
                                    <br /><br />
                                    <a href="<?=site_url('Personal_ivic/subir_archivo/').$fila_personal->id; ?>">
                                        <button type="button" class="btn btn-outline-secondary">Cambiar Imagen</button>
                                    </a>
                                    <?php                                    
                                } ?>
                            </div>
                        </div>                            
                            
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Cargo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_cargo" name="id_cargo" data-show-subtext="true" data-live-search="true"><?php
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
                            <div class="col-md-6 float-left">
                                <label>Categoria <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_categoria" name="id_categoria" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_personal->id_categoria;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_categoria); $j++){
                                        $valor_a_mostrar = $matriz_categoria[$j]->nombre;
                                        $valor = $matriz_categoria[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_categoria" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>
                         
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Tipo <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_tipo" name="id_tipo" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_personal->id_tipo;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_conf_tipo); $j++){
                                        $valor_a_mostrar = $matriz_conf_tipo[$j]->nombre;
                                        $valor = $matriz_conf_tipo[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_tipo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>

                            <div class="col-md-6 float-left">
                                <label>Condición <span style="color:#F00;">*</span></label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_condicion" name="id_condicion" data-show-subtext="true" data-live-search="true"><?php
                                    $valorSel  = $fila_personal->id_condicion;
                                    ?><option value="null">Seleccione</option><?php
                                    for($j = 0; $j < count($matriz_condicion); $j++){
                                        $valor_a_mostrar = $matriz_condicion[$j]->nombre;
                                        $valor = $matriz_condicion[$j]->id;  ?>
                                        <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                    }?>
                                </select>
                                <span id="error_id_condicion" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-4 float-left">
                                        <label>Gerencia <span style="color:#F00;">*</span></label>
                                        <br />
                                        <select class="form-control" id="id_gerencia_2" name="id_gerencia_2" data-show-subtext="true" data-live-search="true"  onChange="carga_id_gerencia()"><?php
                                            $valorSel  = $fila_personal->id_gerencia_2;
                                            ?><option value="null">Seleccione</option><?php
                                            for($j = 0; $j < count($matriz_gerencias_2); $j++){
                                                $valor_a_mostrar = strtoupper($matriz_gerencias_2[$j]->nombre);
                                                $valor = $matriz_gerencias_2[$j]->id;  ?>
                                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                            }?>
                                        </select>
                                        <span id="error_gerencia_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>                            

                                    <div class="col-md-4 float-left">
                                        <label>Centro <span style="color:#F00;">*</span></label>
                                        <select class="form-control" id="id_gerencia" name="id_gerencia" data-show-subtext="true" data-live-search="true" onchange="carga_id_departamento()">
                                            <?php
                                            $valorSel  = $fila_personal->id_gerencia;
                                            ?><option value="null">Seleccione</option><?php
                                            for($j = 0; $j < count($matriz_gerencias); $j++){
                                                $valor_a_mostrar = strtoupper($matriz_gerencias[$j]->nombre);
                                                $valor = $matriz_gerencias[$j]->id;  ?>
                                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                            } ?>
                                        </select>
                                        <span id="error_gerencia" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>

                                    <div class="col-md-4 float-left">
                                        <label>Coordinación / Unidad <span style="color:#F00;">*</span></label>
                                        <select class="form-control" id="id_departamento" name="id_departamento" data-show-subtext="true" data-live-search="true">
                                            <?php
                                            $valorSel  = $fila_personal->id_departamento;
                                            ?><option value="null">Seleccione</option><?php
                                            for($j = 0; $j < count($matriz_departamento); $j++){
                                                $valor_a_mostrar = $matriz_departamento[$j]->nombre;
                                                $valor = $matriz_departamento[$j]->id;  ?>
                                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                            } ?>
                                        </select>
                                        <span id="error_id_departamento" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>
                                    
                                    <?php /*
                                    <div class="col-md-4 float-left">
                                        <label>Coordinación / Unidad <span style="color:#F00;">*</span></label>
                                        <br />
                                        <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_departamento" name="id_departamento" data-show-subtext="true" data-live-search="true"><?php
                                            $valorSel  = $fila_personal->id_departamento;
                                            ?><option value="null">Seleccione</option><?php
                                            for($j = 0; $j < count($matriz_departamento); $j++){
                                                $valor_a_mostrar = $matriz_departamento[$j]->nombre;
                                                $valor = $matriz_departamento[$j]->id;  ?>
                                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                            }?>
                                        </select>
                                        <span id="error_id_departamento" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div> */ ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php /*
                        <div class="row mt-3">
                            <div class="col-md-8 float-left">
                                <label>Tipo de Personal </label>
                                <br />
                                <select class="form-control bg-sigalsx4-purpple_dark text-white" id="tipo_personal" name="tipo_personal"><?php
                                    $valorSel  = $fila_personal->tipo_personal;
                                    
                                    $valor_a_mostrar = "Personal del Ivic";
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
                            <div class="col-md-6 float-left">
                                <label>Estado </label>
                                <br />
                                <select class="form-control bg_color_3 text-white" id="estado" name="estado"><?php
                                    $valorSel  = $fila_personal->estado;
                                    
                                    $valor_a_mostrar = "Activo";
                                    $valor = 1;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                    <?php
                                    $valor_a_mostrar = "Egresado";
                                    $valor = 2;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                    <?php /*
                                    $valor_a_mostrar = "Vacaciones";
                                    $valor = 3;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                    <?php
                                    $valor_a_mostrar = "Reposo";
                                    $valor = 4;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>*/ ?>
                                    <?php 
                                    $valor_a_mostrar = "Suspendido";
                                    $valor = 5;  ?>
                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option>
                                </select>                                
                            </div>
                        </div>

                        <?php
                        if($oper == 'editar'){ ?>
                            <div class="row mt-3">
                                <div class="col-md-6 float-left">
                                    <label>Estados Temporales</label>
                                    <a href="<?php echo site_url('personal_ivic/agregar_estado_temporal/').$fila_personal->id; ?>" class="btn btn-outline-primary btn-sm"  title="Agregar">
                                        <span data-toggle="tooltip" data-placement="left" title="Agregar Estado Temporal"><i class="fa fa-plus"></i></span>
                                    </a> 
                                    
                                    <table class="table table-bordered table-sm">
                                      <thead>
                                        <tr>
                                          <th>Tipo de estado</th>
                                          <th>Desde</th>
                                          <th>Hasta</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        if($matriz_estados_temporales == false){ ?>
                                            <tr>
                                                <td colspan="4" class="text-center">no posee registros</td>
                                            </tr>
                                            <?php
                                        }
                                        if($matriz_estados_temporales != false){ 
                                            for($i = 0; $i < count($matriz_estados_temporales); $i++){
                                                ?>
                                                <tr>
                                                  <td><?php echo $matriz_estados_temporales[$i]->estados_nombre; ?></td>
                                                  <td><?php echo $matriz_estados_temporales[$i]->estados_temporales_fecha_desde; ?></td>
                                                  <td><?php echo $matriz_estados_temporales[$i]->estados_temporales_fecha_hasta; ?></td>
                                                  <td class="text-center">

                                                        <a class="text-danger mr-2" href="#" data-toggle="modal" data-target="#exampleModal<?php echo $matriz_estados_temporales[$i]->estados_temporales_id; ?>">
                                                            <span data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fas fa-trash-alt"></i></span>
                                                        </a>
                                                        <div class="modal fade" id="exampleModal<?php echo $matriz_estados_temporales[$i]->estados_temporales_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">&iquest;Desea eliminar este registro?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                              </div>
                                                              <!--div class="modal-body">
                                                                ...
                                                              </div-->
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                <a href="<?php echo site_url('personal_ivic/eliminar_estado_temporal/'.$fila_personal->id.'/'.$matriz_estados_temporales[$i]->estados_temporales_id); ?>">
                                                                    <button type="button" class="btn btn-primary">Aceptar</button>
                                                                </a>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>                                                  
                                                  </td>
                                                </tr>                                      
                                                <?php                                            
                                            }
                                        }
                                        ?>

                                        <?php /*
                                        <tr>
                                          <td>John</td>
                                          <td>Doe</td>
                                          <td>john@example.com</td>
                                        </tr>
                                        <tr>
                                          <td>Mary</td>
                                          <td>Moe</td>
                                          <td>mary@example.com</td>
                                        </tr>
                                        <tr>
                                          <td>July</td>
                                          <td>Dooley</td>
                                          <td>july@example.com</td>
                                        </tr>*/ ?>
                                      </tbody>
                                    </table>
                                </div>
                            </div><?php                            
                        } ?>

                        
                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <input class="btn btn-secondary" type="submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>

                    <a href="<?php echo site_url('Personal_ivic/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>
                </div>

            <!--</div>-->
        </div>
    </div>
</div>