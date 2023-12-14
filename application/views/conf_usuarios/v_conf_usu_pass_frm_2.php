<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <i class="text-white fas fa-key fa-2x"></i>
                            <span class="text-white">Cambiar contraseña</span>


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

                        <div class="row mt-4">
                            <div class="col-md-6 float-left">
                                <!--input class="btn btn-outline-sigalsx4-purpple" type="submit" name="Guardar" value="Guardar"-->
                                <?php
                                $ruta = "";
                                if($menu_origen == "menu_estudiante"){
                                    $ruta = 'Menues/menu_estudiante_cuenta';
                                }
                                if($menu_origen == "menu_profesor"){
                                    $ruta = 'Menues/menu_profesor_cuenta';
                                }                                
                                ?>
                                <a href="<?=site_url($ruta)?>">
                                    <button type="button" class="btn btn-outline-secondary">Continuar</button>
                                </a>                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>

            <!--</div>-->
        </div>
    </div>
</div>