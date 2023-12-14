<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fa fa-user-plus fa-2x"></i>
                            <?php
                            //echo "nombre *".$nombre."*";
                            switch ($oper){
                                case 'agregar': ?>
                                        <span class="text-white">Agregar usuario</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                                case 'ver': ?>
                                        <span class="text-white">usuario</span><?php
                                        $oper_g = "";
                                break;
                                case 'editar_como_administrador': ?>
                                        <span class="text-white">Editar usuario</span><?php
                                        $oper_g = "editar_guardar_como_administrador";
                                break;
                            } ?>

                        </h4>
                    </div>
                
                    <div class="col-md-12 float-left text-right container-fluid mt-2">
                        <?php

                        if( strlen($this->session->userdata('conf_usuarios_mensaje_tipo')) > 0  ){ ?>
                                <div class="alert <?php echo $this->session->userdata('conf_usuarios_mensaje_tipo'); ?> text-center"><?php
                                    echo $this->session->userdata('conf_usuarios_mensaje_contenido'); ?>
                                </div><?php
                                $s_mensaje = array(
                                        'conf_usuarios_mensaje_tipo'         => '',
                                        'conf_usuarios_mensaje_contenido'    => ''
                                );
                                $this->session->set_userdata($s_mensaje);
                        } ?>
                    </div>                
                
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function valida(oper){
                                var ok = true;
                                var msg = "Verificar los Siguientes Campos:\n";

                                if(document.getElementById("ci_usu").value.length < 1)
                                {
                                    $("#ci_usu").addClass("border-danger");
                                    $('#error_ci_usu').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#ci_usu").removeClass("border-danger");
                                    $('#error_ci_usu').css('display', 'none');
                                };
                                
                                if(document.getElementById("nombre_usu").value.length < 1)
                                {
                                    $("#nombre_usu").addClass("border-danger");
                                    $('#error_nombre_usu').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#nombre_usu").removeClass("border-danger");
                                    $('#error_nombre_usu').css('display', 'none');
                                };

                                if(document.getElementById("apellido_usu").value.length < 1)
                                {
                                    $("#apellido_usu").addClass("border-danger");
                                    $('#error_apellido_usu').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#apellido_usu").removeClass("border-danger");
                                    $('#error_apellido_usu').css('display', 'none');
                                };
                                
                                k = document.form_principal.correo;
                                correo_valido = true;
                                if(k.value.length > 0){//para cuando el campo este vacio no valide
                                        txt=k.value; a2=txt.indexOf("@"); len=txt.length;
                                        if (a2<3){
                                                correo_valido = false;
                                        }
                                        a3=txt.lastIndexOf("."); chequear_ult=len-a3; 
                                        if (chequear_ult<3){
                                                correo_valido = false;
                                        }
                                        punto=txt.indexOf(".",a2); len1=punto-a2;
                                        if (len1<1){
                                                correo_valido = false;
                                        }
                                }
                                if(correo_valido == false){
                                        $("#correo").addClass("border-danger");
                                        $('#error_correo').css('display', 'block');
                                        ok = false;                                    
                                }else{
                                        $("#correo").removeClass("border-danger");
                                        $('#error_correo').css('display', 'none');                                    
                                }
/*
                                if(document.getElementById("correo").value.length < 1)
                                {
                                    $("#correo").addClass("border-danger");
                                    $('#error_correo_2').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#correo").removeClass("border-danger");
                                    $('#error_correo_2').css('display', 'none');
                                };  */

                                if(document.getElementById("usuario_usu").value.length < 1)
                                {
                                     $("#usuario_usu").addClass("border-danger");
                                    $('#error_usuario_usu').css('display', 'block');
                                    ok = false;
                                }else{
                                    $("#usuario_usu").removeClass("border-danger");
                                    $('#error_usuario_usu').css('display', 'none');
                                };        
                                
                                nombre_correo_conflicto = document.getElementById("nombre_correo_conflicto").value;
                                if(nombre_correo_conflicto == "true"){
                                    $("#correo").addClass("border-danger");
                                    ok = false;
                                }
                                
                                //valida_nombre_de_usuario(); //SE VALIDA NUEVAMENTE, PORQUE PUEDE QUE LA VARIABLE NO ESTE CARGADA
                                nombre_usuario_conflicto = document.getElementById("nombre_usuario_conflicto").value;
                                if(nombre_usuario_conflicto == "true"){
                                    $("#usuario_usu").addClass("border-danger");
                                    ok = false;
                                }                                

                                if(oper == 'agregar'){
                                    if(document.getElementById("pass_usu").value.length < 1)
                                    {
                                        $("#pass_usu").addClass("border-danger");
                                        $('#error_pass_usu').css('display', 'block');
                                        ok = false;
                                    }else{
                                        $("#pass_usu").removeClass("border-danger");
                                        $('#error_pass_usu').css('display', 'none');
                                    };                                    
                                }
                                
                                if(ok == false){
                                    $('.alert-error-campo').css('display', 'block');    //alert(msg);
                                    return ok;
                                }else{
                                    $('.alert-error-campo').css('display', 'none');
                                    return true;
                                }
                            };
                        </script>
                        <script languaje="javascript">
                            function valida_nombre_de_usuario(oper){
                                var baseurl = "<?php echo base_url(); ?>";
                                usuario_usu = document.getElementById("usuario_usu").value;

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Conf_usu_pass/get_conf_usu_pass_buscar_4",
                                    {
                                                usuario_usu: usuario_usu
                                    },
                                    function(data){
                                            //alert(data);
                                            var matriz_conf_usu_pass = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_conf_usu_pass == false){
                                                $("#usuario_usu").removeClass("border-danger");
                                                $('#error_usuario_usu_2').css('display', 'none');
                                                document.getElementById("nombre_usuario_conflicto").value = "false";
                                            }else{
                                                $("#usuario_usu").addClass("border-danger");
                                                $('#error_usuario_usu_2').css('display', 'block');
                                                document.getElementById("nombre_usuario_conflicto").value = "true";
                                            }
                                    });
                                }

                                if(  (oper == "editar") || (oper == "editar_como_administrador")  ){
                                    id_usuario  = document.getElementById("id_usuario").value;
                                    
                                    $.post(baseurl+"index.php/Conf_usu_pass/get_conf_usu_pass_buscar_3",
                                    {
                                                usuario_usu: usuario_usu
                                            ,   id_usuario: id_usuario
                                    },
                                    function(data){
                                            var matriz_conf_usu_pass = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_conf_usu_pass == false){
                                                $("#usuario_usu").removeClass("border-danger");
                                                $('#error_usuario_usu_2').css('display', 'none');
                                                document.getElementById("nombre_usuario_conflicto").value = "false";
                                            }else{
                                                $("#usuario_usu").addClass("border-danger");
                                                $('#error_usuario_usu_2').css('display', 'block');
                                                document.getElementById("nombre_usuario_conflicto").value = "true";
                                            }
                                    });
                                }
                            }
                            /*
                            //VALIDA QUE EL CORREO NO ESTE REPETIDO
                            function valida_correo_de_usuario(oper){
                                var baseurl = "<?php echo base_url(); ?>";
                                correo = document.getElementById("correo").value;

                                if(oper == "agregar"){
                                    $.post(baseurl+"index.php/Conf_usuarios/get_conf_usuarios_buscar_4",
                                    {
                                                correo: correo
                                    },
                                    function(data){
                                            //alert(data);
                                            var matriz_conf_usuarios = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_conf_usuarios == false){
                                                $("#correo").removeClass("border-danger");
                                                $('#error_correo_3').css('display', 'none');
                                                document.getElementById("nombre_correo_conflicto").value = "false";
                                            }else{
                                                $("#correo").addClass("border-danger");
                                                $('#error_correo_3').css('display', 'block');
                                                document.getElementById("nombre_correo_conflicto").value = "true";
                                            }
                                    });                                    
                                }
                                //alert("oper *"+oper+"*");
                                if(oper == "editar_como_administrador"){
                                    
                                    id_usuario  = document.getElementById("id_usuario").value;
                                    $.post(baseurl+"index.php/Conf_usuarios/get_conf_usuarios_buscar_5",
                                    {
                                                correo: correo
                                            ,   id_usuario: id_usuario
                                    },
                                    function(data){
                                            //alert(data);
                                            var matriz_conf_usuarios = JSON.parse(data); //convierto el valor devuelto a una matris

                                            if(matriz_conf_usuarios == false){
                                                $("#correo").removeClass("border-danger");
                                                $('#error_correo_3').css('display', 'none');
                                                document.getElementById("nombre_correo_conflicto").value = "false";
                                            }else{
                                                $("#correo").addClass("border-danger");
                                                $('#error_correo_3').css('display', 'block');
                                                document.getElementById("nombre_correo_conflicto").value = "true";
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
                        
                        <script languaje="javascript">
                            function guardar(){
                                    if(valida('<?php echo $oper; ?>') == true){
                                        document.form_principal.submit();
                                    }
                            }
                        </script>
                        <form action="<?php echo ''.base_url('').''?>index.php/Conf_usuarios/<?php echo $oper_g; ?>" name="form_principal" id="form_principal" method="post" enctype="multipart/form-data" target="_parent"><?php

                        if($oper == 'editar_como_administrador'){ ?>
                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php if( isset($conf_usuarios->id_usuario) ){ echo $conf_usuarios->id_usuario; } ?>" ><?php
                        }                        
                        ?>
                            
                        <input type="hidden" id="nombre_usuario_conflicto" name="nombre_usuario_conflicto" value="false">
                        <input type="hidden" id="nombre_correo_conflicto" name="nombre_correo_conflicto" value="false">

                        <div class="row">
                            <div class="col-md-12 container-fluid">
                                
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <label>C&eacute;dula <span style="color:#F00;">*</span></label>
                                        <br />
                                        <input class="form-control" id="ci_usu" name="ci_usu" type="text" placeholder="C&eacute;dula" value="<?php if( isset($conf_usuarios->ci_usu) ){ echo $conf_usuarios->ci_usu; } ?>" size="10" maxlength="10" <?php if($oper == 'ver' or $oper == 'editar_como_administrador'){ echo "readonly='true'"; } ?>>
                                        <span id="error_ci_usu" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>                                      
                                    </div>
                                    <div class="col-md-12 float-left mt-3">
                                        <label>Nombres <span style="color:#F00;">*</span></label>
                                        <br />
                                        <input class="form-control" id="nombre_usu" name="nombre_usu" type="text" placeholder="Nombres" value="<?php if( isset($conf_usuarios->nombre_usu) ){ echo $conf_usuarios->nombre_usu; } ?>" size="45" maxlength="45"  <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                        <span id="error_nombre_usu" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>

                                    <div class="col-md-12 float-left mt-3">
                                        <label>Apellidos <span style="color:#F00;">*</span></label>
                                        <br />
                                        <input class="form-control" id="apellido_usu" name="apellido_usu" type="text" placeholder="Apellidos" value="<?php if( isset($conf_usuarios->apellido_usu) ){ echo $conf_usuarios->apellido_usu; } ?>" size="45" maxlength="45" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                        <span id="error_apellido_usu" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                    </div>                                     
                                </div>                                
                                

                            </div>
                            <?php /*
                            <div class="col-md-6  text-center mt-3"><?php 
                                if($oper != 'agregar'){
                                    if( $conf_usuarios->imagen_nombre == "" ){ 
                                        $ruta = base_url("images/conf_usuario/")."sin_imagen.png";
                                    }else{ 
                                        $ruta = base_url("images/conf_usuario/").$conf_usuarios->imagen_nombre;                                     
                                    } ?>
                                    <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px"><?php
                                }
                                if($oper == 'editar_como_administrador'){ ?>
                                    <br /><br />
                                    <a href="<?=site_url('Conf_usuarios/subir_archivo/').$id."/".$oper; ?>">
                                        <button type="button" class="btn btn-outline-sigalsx4-purpple">cambiar imagen</button>
                                    </a><?php                                    
                                } ?>                                
                            </div>*/ ?>
                        </div>

                        <div class="row mt-3">
                           
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 float-left">
                                <label>Direcci&oacute;n</label>
                                <br />
                                <input class="form-control" id="direccion_usu" name="direccion_usu" type="text" placeholder="Direcci&oacute;n" value="<?php if( isset($conf_usuarios->direccion_usu) ){ echo $conf_usuarios->direccion_usu; } ?>" size="100" maxlength="100" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                <span id="error_direccion_usu" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Tel&eacute;fono 1</label>
                                <br />
                                <input class="form-control tlf" id="telefono_1" name="telefono_1" type="text" placeholder="Ejemplo: (0212) 12345678" value="<?php if( isset($conf_usuarios->telefono_1) ){ echo $conf_usuarios->telefono_1; } ?>" size="25" maxlength="25" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                <span id="error_telefono_1" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>
                            
                            <div class="col-md-6 float-left">
                                <label>Tel&eacute;fono 2</label>
                                <br />
                                <input class="form-control tlf" id="telefono_2" name="telefono_2" type="text" placeholder="Ejemplo: (0416) 12345678" value="<?php if( isset($conf_usuarios->telefono_2) ){ echo $conf_usuarios->telefono_2; } ?>" size="25" maxlength="25" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                <span id="error_telefono_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                            </div>                            
                        </div> 
                        
                       
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Correo </label>
                                <br />
                                <?php /*
                                <input class="form-control" id="correo" name="correo" type="text" placeholder="Ejemplo: micorreo@gmail.com" value="<?php if( isset($conf_usuarios->correo) ){ echo $conf_usuarios->correo; } ?>" size="100" maxlength="100" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?> onchange="valida_correo_de_usuario('<?php echo $oper; ?>')"> */ ?>
                                <input class="form-control" id="correo" name="correo" type="text" placeholder="Ejemplo: micorreo@gmail.com" value="<?php if( isset($conf_usuarios->correo) ){ echo $conf_usuarios->correo; } ?>" size="100" maxlength="100" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?> onchange="valida_correo_de_usuario('<?php echo $oper; ?>')">
                                <span id="error_correo" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Ingrese una dirección de correo v&aacute;lida
                                </span>
                                <span id="error_correo_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                                <span id="error_correo_3" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    La dirección de correo, ya se encuentra en uso
                                </span>                                
                                
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <label>Usuario <span style="color:#F00;">*</span></label>
                                <br />
                                <input class="form-control" id="usuario_usu" name="usuario_usu" type="text" placeholder="Usuario" value="<?php if( isset($conf_usu_pass->usuario_usu) ){ echo $conf_usu_pass->usuario_usu; } ?>" size="45" maxlength="45" onchange="valida_nombre_de_usuario('<?php echo $oper; ?>')" <?php if($oper == 'ver'){ echo "readonly='true'"; } ?>>
                                <span id="error_usuario_usu" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    Campo Vacio
                                </span>
                                <span id="error_usuario_usu_2" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                    El nombre de usuario, ya se encuentra en uso
                                </span>
                            </div>
                        </div>                        
                        
                        <div class="row mt-3">
                            <div class="col-md-6 float-left">
                                <?php                
                                if($oper == 'agregar'){ ?>
                                        <label>Contrase&ntilde;a <span style="color:#F00;">*</span></label>
                                        <br />                                
                                        <input class="form-control" id="pass_usu" name="pass_usu" type="password" placeholder="Contrase&ntilde;a" value="<?php if( isset($conf_usuarios->pass_usu) ){ echo $conf_usuarios->pass_usu; } ?>" size="45" maxlength="45">
                                        <span id="error_pass_usu" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                                        </span>
                                        <span id="error_pass_usu_2" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La clave debe se mayor a seis(6) dígitos
                                        </span>                                            
                                        <span id="error_pass_usu_3" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La clave debe contener al menos un caracter numerico
                                        </span>
                                        <span id="error_pass_usu_4" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            La clave debe contener al menos un especial (.*-%_)
                                        </span>                                            
                                        <?php
                                } ?>
                            </div>
                        </div>

                        <?php 
                        //if($conf_roles_id_es_1 == 1){
                        if($id_conf_roles_es_1 == 1){ ?>
                            <div class="row mt-3">
                                <div class="col-md-6 float-left">
                                    <label>Rol</label>
                                    <br />
                                    <input type="hidden" id="rol_actualizar" name="rol_actualizar" value="true" ><?php
                                    //echo "<pre> matriz_conf_usuarios_roles *"; print_r($matriz_conf_usuarios_roles); echo "*</pre>";

                                    for($i = 0; $i < count($matriz_conf_roles); $i++){ 
                                        $activa = false;
                                        if($matriz_conf_usuarios_roles != false){
                                            for($j = 0; $j < count($matriz_conf_usuarios_roles); $j++){ 
                                                if($matriz_conf_usuarios_roles[$j]->conf_roles_id == $matriz_conf_roles[$i]->id_rol){
                                                    $activa= true;
                                                }
                                            }
                                        } 
                                        //echo "<hr>";                                        
                                        $bloquea = false;
                                        if($oper == 'ver'){ $bloquea = true; }
                                        if($matriz_conf_roles[$i]->id_rol == 1){
                                            if($id_conf_roles_es_1 == false){ $bloquea = true; }
                                        } //echo "bloquea *".$bloquea."*";  
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" name="rol[]" id="rol_<?php echo $i; ?>" type="checkbox" value="<?php echo $matriz_conf_roles[$i]->id_rol; ?>" <?php if ($activa == true){ ?>checked="checked"<?php } ?> <?php if($bloquea == true){ echo "disabled"; } ?> />
                                            <label class="form-check-label" for="rol_<?php echo $i; ?>"><?php
                                                echo $matriz_conf_roles[$i]->nombre; ?>
                                            </label>
                                        </div>
                                    
                                        <?php
//                                        echo "&nbsp;";
//                                        echo $matriz_conf_roles[$i]->nombre; 
//                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 float-left">
                                        <?php /*
                                        <div class="alert alert-primary" role="alert">
                                            En este campo para <strong>Profesor o Estudiante</strong> se crea una ficha o deshabilita el estado de la misma.
                                        </div>                                    
                                        <div class="alert alert-primary" role="alert">
                                            El <strong>Rol Administrador</strong> se crea solo con un usuario administrador.
                                        </div>*/ ?>
                                </div>
                            </div><?php
                        } 
                        
                        if($id_conf_roles_es_1 == 1 or $id_conf_roles_es_4 == 1){ ?>
                                <div class="row mt-3">
                                    <div class="col-md-6 float-left">
                                        <label>Estado</label>
                                        <br />
                                        <?php if( isset($conf_usuarios->estado) ){ $estado = $conf_usuarios->estado; }else{ $estado = 1; } ?>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="estado" id="estado" value="1" <?php if( $estado == 1 ){ echo "checked"; } ?>>
                                          <label class="form-check-label" for="inlineRadio1">Habilitado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="estado" id="estado" value="2" <?php if( $estado == 2 ){ echo "checked"; } ?>>
                                          <label class="form-check-label" for="inlineRadio2">Deshabilitado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 float-left">
                                        <div class="alert alert-primary" role="alert">
                                            Si el campo Estado esta <strong>Deshabilitado</strong>, el usuario, no tendrá acceso para ingresar al sistema.
                                        </div>                                    
                                    </div>
                                </div><?php
                        }else{ ?>
                            <input type="hidden" id="estado" name="estado" value="1" ><?php
                        } ?>
                            
                        <?php 
                        if($oper != 'ver'){ ?>
                            <div class="row mt-4">
                                <div class="col-md-6 float-left">
                                    <!--input class="btn btn-outline-sigalsx4-purpple" type="submit" name="Guardar" value="Guardar"-->
                                    <a href="#" onclick="guardar('<?php echo $oper_g; ?>')">
                                        <button type="button" class="btn btn-outline-secondarye">Guardar</button>
                                    </a>                                
                                </div>
                            </div><?php
                        } ?>
                        <?php echo form_close(); ?>
                                
                    </div>
                    <?php
                    //echo "menu_origen *".$menu_origen."*";
                    
                    if(isset($menu_origen)){
                        /* 
                        if($menu_origen == "menu_usuarios"){ ?>
                                <a href="<?=site_url('Menues/menu_usuarios')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                        }                        
                        if($menu_origen == "menu_profesor"){ ?>
                                <a href="<?=site_url('Menues/menu_profesor_cuenta')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                        }
                        if($menu_origen == "menu_estudiante_cuenta"){ ?>
                                <a href="<?=site_url('Menues/menu_estudiante_cuenta')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                        } */ 
                        if($menu_origen == "Conf_usuarios_listar"){ ?>
                                <a href="<?=site_url('Conf_usuarios/listar/cargo_ultima_pagina')?>" id="btn_float" class="button button-circle button-flat-primary bg_color_3">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                        }                        
                    }
                    ?>
                    
                </div>

            <!--</div>-->
        </div>
    </div>
</div>