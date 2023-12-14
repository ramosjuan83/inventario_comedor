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
                                case 'subir_archivo': ?>
                                        <span class="text-white">Cambiar imagen</span><?php
                                        $oper_g = "agregar_guardar";
                                break;
                            } ?>

                        </h4>
                    </div>
                
                    <div class="col-md-12 float-left text-right container-fluid mt-2"><?php
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
                
                    <!--div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-center alert-error-campo" style="display: none">
                                <i class="fa fa-exclamation-triangle"></i>
                                Verificar los siguientes campos...!!!
                            </div>
                        </div>
                    </div-->  

                    <script languaje="javascript">
                        function valida(f, oper){
                            var ok = true;
                            var msg = "Verificar los Siguientes Campos:\n";

                            if(ok == false){
                                $('.alert-error-campo').css('display', 'block');    //alert(msg);
                                return ok;
                            }else{
                                $('.alert-error-campo').css('display', 'none');
                                return true;
                            }
                        };
                    </script>                    
                
                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger text-center alert-error-campo" style="display: none">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    Verificar los siguientes campos...!!!
                                </div>
                            </div>
                        </div>
                        <script languaje="javascript">
                            function subirArchivos(){
                                if(validar_control_file() == true){
                                        var baseurl = "<?php echo base_url(); ?>";
                                        id_usuario = document.getElementById("id_usuario").value;
                                        $("#archivo").upload(baseurl+"index.php/Conf_usuarios/get_subir_archivo",
                                        {
                                            id_usuario: id_usuario
                                        },
                                        function(respuesta){
                                            $("#barra_de_progreso").val(0);
                                            //mostrarRespuesta(respuesta, true);
                                            if (respuesta === 1){
                                                $("#barra_de_progreso").val(100);
                                                mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                                            } else {
                                                mostrarRespuesta('El archivo NO se ha podido subir.', false);
                                            }
                                            mostrarArchivos();
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
                        <form action="<?php echo ''.base_url('').''?>index.php/Conf_usuarios/<?php echo $oper_g; ?>" name="form_principal" id="form_principal" method="post" enctype="multipart/form-data" target="_parent">

                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php if( isset($id_usuario) ){ echo $id_usuario; } ?>" >
                            <input type="hidden" id="nombre_usuario_conflicto" name="nombre_usuario_conflicto" value="false">
                            <input type="hidden" id="nombre_correo_conflicto" name="nombre_correo_conflicto" value="false">

                            <div class="row">
                                <div class="col-md-4 float-left">
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
                            <div class="row mt-4">
                                <div class="col-md-4 float-left">
                                    <!--input class="btn btn-outline-sigalsx4-purpple" type="submit" name="Guardar" value="Guardar"-->
                                    <a href="#" onclick="subirArchivos()">
                                        <button type="button" class="btn btn-outline-sigalsx4-purpple">Subir</button>
                                    </a>                                
                                </div>
                                <div class="col-md-6 float-left">
                                    <progress id="barra_de_progreso" value="0" max="100"></progress>                               
                                </div>                                
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-2 float-left">
                                    <div id="archivos_subidos"></div>                        
                                </div>
                            </div>
                            
                        <?php echo form_close(); ?>
                                
                    </div>
                    <script languaje="javascript">
                        //mostrarArchivos();
                    </script>
                        
                    <?php
                    if($menu_origen == 'editar_como_administrador'){ ?>
                        <a href="<?=site_url('Conf_usuarios/editar_como_administrador/'.$id)?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                            <i class="fas fa-arrow-circle-left fa-5x"></i>
                        </a><?php
                    }
                    ?>
                
                    <?php /*
                    
                        if($id_conf_roles_es_2 == true){ ?>
                            <a href="<?=site_url('Menues/menu_profesor')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                <i class="fas fa-arrow-circle-left fa-5x"></i>
                            </a><?php
                        }else{
                            if( $oper == 'ver' ){ ?>
                                <a href="javascript:history.back(1)" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                            }
                            if($oper == 'editar_como_administrador' or $oper == 'agregar'){ ?>
                                <a href="<?=site_url('Conf_usuarios/listar/cargo_ultima_pagina')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
                                    <i class="fas fa-arrow-circle-left fa-5x"></i>
                                </a><?php
                            }                            
                        } */
                    ?>
                    
                </div>

            <!--</div>-->
        </div>
    </div>
</div>