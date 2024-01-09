<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fas fa-key fa-2x"></i>
                            <?php
                            //echo "nombre *".$nombre."*";
                            
                            //echo "<pre>"; print_r($conf_usuarios); echo "</pre>";
                            
                            switch ($oper){
                                case 'editar_contrasena_como_administrador': ?>
                                        <span class="text-white">Editar usuario <?php echo "(".$conf_usuarios->ci_usu.") ".$conf_usuarios->nombre_usu;?></span><?php
                                        $oper_g = "editar_guardar_contrasena_como_administrador";
                                break;
                                case 'editar_contrasena_como_usuario': ?>
                                        <span class="text-white">Cambiar Contraseña</span><?php
                                        $oper_g = "editar_guardar_contrasena_como_usuario";
                                break;                            
                            } ?>

                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida() {
                                var ok = true;

                                if(document.getElementById("pass_usu").value.length < 1)
                                {
                                    $("#pass_usu").addClass("border-danger");
                                    $('#error_pass_usu').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#pass_usu").removeClass("border-danger");
                                    $('#error_pass_usu').css('display', 'none');
                                };
                                
                                if(document.getElementById("pass_usu").value.length < 10)
                                {
                                    $("#pass_usu").addClass("border-danger");
                                    $('#error_pass_usu_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#pass_usu").removeClass("border-danger");
                                    $('#error_pass_usu_2').css('display', 'none');
                                };                                
                        
                                if(document.getElementById("pass_usu_repetido").value.length < 1)
                                {
                                    $("#pass_usu_repetido").addClass("border-danger");
                                    $('#error_pass_usu_repetido').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#pass_usu_repetido").removeClass("border-danger");
                                    $('#error_pass_usu_repetido').css('display', 'none');
                                };                                
                        
                                if(document.getElementById("pass_usu").value != document.getElementById("pass_usu_repetido").value)
                                {
                                    $("#pass_usu_repetido_2").addClass("border-danger");
                                    $('#error_pass_usu_repetido_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#pass_usu_repetido_2").removeClass("border-danger");
                                    $('#error_pass_usu_repetido_2').css('display', 'none');
                                };

                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');    //alert(msg);
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
                            'onsubmit' => "return valida(this)",
                            'role' => 'form'
                            //'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php echo form_open('Conf_usu_pass/'.$oper_g, $atributos2); ?>
                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php if( isset($conf_usuarios->id_usuario) ){ echo $conf_usuarios->id_usuario; } ?>" >
                        <input type="hidden" id="menu_origen" name="menu_origen" value="<?php if( isset($menu_origen) ){ echo $menu_origen; } ?>" >
                            
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Contrase&ntilde;a nueva <span style="color:#F00;">*</span></label>
                                <br />
                                <input class="form-control" id="pass_usu" name="pass_usu" type="password" placeholder="Contrase&ntilde;a" value="" size="45" maxlength="45">
                                <span id="error_pass_usu" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                                <span id="error_pass_usu_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    La contrase&ntilde;a debe de ser mayor a 10 caracteres
                                </span>                                
                            </div>
                        </div>
                            
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Repita Contrase&ntilde;a nueva <span style="color:#F00;">*</span></label>
                                <br />
                                <input class="form-control" id="pass_usu_repetido" name="pass_usu_repetido" type="password" placeholder="Contrase&ntilde;a" value="" size="45" maxlength="45">
                                <span id="error_pass_usu_repetido" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                                <span id="error_pass_usu_repetido_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Lo valores de las contraseñas no coinciden, verifiquelas y anotelas de nuevo
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
                    <?php /*
                    <a href="javascript:history.back(1)" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                    <!--a href="<//?=site_url('Conf_usuarios/listar')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple"-->
                        <i class="fas fa-arrow-circle-left fa-5x"></i>
                    </a>*/ ?> 
                
                    <?php
                    switch ($menu_origen) {
                        case "listar": ?>
                            <a href="<?php echo site_url('Conf_usuarios/listar/cargo_ultima_pagina'); ?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                                <i class="fas fa-arrow-circle-left fa-5x"></i>
                            </a><?php
                        break;
                        case 1:
                            echo "i es igual a 1";
                        break;
                    } ?>                
                
                </div>

            <!--</div>-->
        </div>
    </div>
</div>