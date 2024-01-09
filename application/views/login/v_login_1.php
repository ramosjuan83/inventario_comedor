<!--<div class="container-fluid">
    <div id="login_sigalsx4" class="card card-login mx-auto bg-light pt-3 pl-1 pr-1" style="display: block; border:1px solid #7349b7">
        <div class="row">
            <div class="col-12 text-center">
                img src="<?php echo '' .base_url('/images').''?>/logo_sigalsx4.png" width="370" height="150" alt="" /
		<img class="img-fluid" src="<?php echo '' .base_url('/images').''?>/logo_sigalsx4.png" width="322" height="180" alt="" />
                h2 class="text_sigalsx4_purpple">Univesidad</h2
            </div>
        </div>
        <?php
        if (isset($error_pass)){
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            Usuario y Contraseña no coinciden
        </div>
        <?php
        }
        ?>
        <div class="card-body bg-light">
        <?php
        //$atributos2 = array('name' => 'login_user', 'id' => 'login_user_form', 'onsubmit' => 'return valida(this)', 'role' => 'login');
        $atributos2 = array('name' => 'login_user', 'id' => 'login_user_form', 'role' => 'login');
        ?>
        <?php //echo form_open('sigalsx4/sigalsx4_login',$atributos2);
        //echo form_open('Login/sigalsx4_login',$atributos2);?>
          <div class="form-group">
            <label for="exampleInputEmail1">Usuario</label>
            <input class="form-control" id="user_intra" name="user_intra" type="text" placeholder="Usuario">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input class="form-control" id="pass_intra" name="pass_intra" type="password" placeholder="Contraseña">
          </div>

          <button type="submit" name="ingresar" value="Iniciar" class="btn btn-outline-sigalsx4-purpple">Ingresar</button>
          <a class="btn btn-primary btn-block" href="index.html">Login</a>
        <?php //echo form_close(); ?>
        </div>
                <div class="card-footer border-0 bg-light">
            <a id="cambiar_pass" href="#" class="text_sigalsx4_purpple">¿Olvido su contraseña?</a>
        </div>
    </div>
</div>-->

<div class="container-fluid">
  <div class="row no-gutter">
        <!--div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"-->
        <?php /*
        <div class="d-none d-md-flex col-md-4 col-lg-6">
            
            <div class="login d-flex align-items-center py-5 col-lg-12">
                <div class="container  .d-none .d-lg-block .d-xl-none">
                    <div class="text-center">
                        <img src="<?php echo ''.base_url('').''?>/images/logo_2.jpeg" class="rounded" width="200px" alt="">
                        <br /><br />
                        <h3>Instituto Venezolano de Investigaciones Científicas <br> IVIC</h3>
                        <br /><br />
                        <!--img src="../../images/logo_sigalsx4_mini.png" class="rounded" width="30%" alt=""-->
                        <!--img src="<?php //echo ''.base_url('').''?>/images/logo_sigalsx4_mini.png" class="rounded" width="180px" alt=""-->
                    </div>
                </div>
            </div>
            

        </div> */ ?>
    
        <style type="text/css">
        <!--
        .bg_login {
            background-image: url("<?php echo ''.base_url('').''?>/images/login-bg.png");
            background-size: cover;
            /*background-repeat: no-repeat; */
            background-position: center top;            
        }
        -->
        </style>        
        
        <!--div class="col-md-8 col-lg-6 bg-sigalsx4-purpple_dar bg_login"-->
        <div class="col-md-12 col-lg-12 bg-sigalsx4-purpple_dar bg_login">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                
                <div class="col-md-9 col-lg-12 mx-auto">
                    <div class="text-center color_6">
                            <?php /*
                            <img src="<?php echo ''.base_url('').''?>/images/logo-ivic.png" class="rounded" width="200px" alt="">
                            <br /><br />*/ ?>
                            <!--h3>Instituto Venezolano de Investigaciones Científicas</h3-->
                            
                    </div>
                </div>
                <div class="col-md-9 col-lg-4 mx-auto">
                    
                    <div class="d-lg-none">
                        <div class="text-center" style="color: #FFFFFF;">
                            <!--img src="<?php //echo ''.base_url('').''?>/conf_empresa/logo/logo_invertido.png" class="rounded" width="250px" alt=""-->
                            <!--h3  style="color: #FFFFFF;">Instituto Universitario de Relaciones Públicas <br> IUDERP</h3-->
                        </div>
                    </div>
                    
                    <div class="text-center color_6">
                        <h3>Sistema Integral</h3>
                        <br />
                    </div>                    
                    
                    <?php
                    if (isset($usuario_desabilitado)){
                        if ($usuario_desabilitado == true){ ?>
                            <div class="alert alert-danger m-2" role="alert">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                Su usuario se encuentra deshabilitado, consulte con su administrador de sistemas
                            </div><?php
                        }                    
                    }

                    if (isset($error_pass)){ ?>
                        <div class="alert alert-danger m-2" role="alert">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                            Usuario o Contraseña no coinciden
                        </div><?php 
                    } ?>
                  <!--<h3 class="login-heading mb-4 text-white">Bienvenidos al Turpial Académico</h3>-->
    <!--              <form>-->
                    <?php
                            //$atributos2 = array('name' => 'login_user', 'id' => 'login_user_form', 'onsubmit' => 'return valida(this)', 'role' => 'login');
                            $atributos2 = array('name' => 'login_user', 'id' => 'login_user_form', 'role' => 'login');
                            ?>
                    <?php //echo form_open('sigalsx4/sigalsx4_login',$atributos2);
                    echo form_open('Login/autenticar',$atributos2);?>
                    <div class="form-label-group">
                      <input type="text" id="inputEmail" name="user_intra" class="form-control" placeholder="Usuario" required autofocus>
                      <label for="inputEmail">Usuario</label>
                    </div>

                    <div class="form-label-group">
                      <input type="password" id="inputPassword" name="pass_intra"  class="form-control" placeholder="Contraseña" required>
                      <label for="inputPassword">Contraseña</label>
                    </div>

    <!--                <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Remember password</label>
                    </div>-->
                    <button class="btn btn-lg color_4 btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" name="ingresar" value="Iniciar">Ingresar</button>

                    <?php /*
                    <div class="text-center">
                      <a href="<?php echo ''.base_url('').''?>index.php/Login/recuperar_contrasena" class="small" style="color: #FFFFFF;">Restablecer Contraseña (En contrucción)</a>
                    </div> */?>
                    
                    <?php
                    if( strlen($this->session->userdata('login_mensaje_tipo')) > 0  ){ ?>
                            <div class="alert <?php echo $this->session->userdata('login_mensaje_tipo'); ?> text-center"><?php
                                echo $this->session->userdata('login_mensaje_contenido'); ?>
                            </div><?php
                            $s_mensaje = array(
                                    'login_mensaje_tipo'         => '',
                                    'login_mensaje_contenido'    => ''
                            );
                            $this->session->set_userdata($s_mensaje);
                    } ?>                

                    <?php echo form_close(); ?>
                  <!--</form>-->
                </div>


              </div>
            </div>
          </div>

        </div>
        <div class="col-md-12 col-lg-12 footer">
                <p class="text-center ">
                    Copyright © 2023 IVIC.
                    <br />
                    Sistema Integrado de Gestión para Entes del Sector Público Adaptado por: Oficina de Tecnología de la Información y Comunicación (OTIC) - Coordinación de Desarrollo de Sistemas
                </p>                        
        </div>
      
        
        

                
        
  </div>
</div>
<?php /*
<div class="jumbotron text-center" style="margin-bottom:0">
  <p>Copyright © 2021 IVIC.

Sistema Integrado de Gestión para Entes del Sector Público Adaptado por: Oficina de Tecnología de la Información y Comunicación (OTIC) - Coordinación de Desarrollo de Sistemas</p>
</div>
*/ ?>
<style type="text/css">
        <!--
        .footer2{
        }
        .footer{
            color: #FFF;
            background: #1F74AF;
            font-size: small;
            /*position: fixed;*/
            left:0px;
            /*bottom:0px;*/
            /*height:40px; */
            width:100%;
            z-index: 0; /*Esto es la posicion normal, sin estar detras o alante */
        }
        /*.footer_letra {color: #9B9B9B} */

        .footer_1{
            /*background: #43C3D5;
            position:fixed;
            left:0px;
            bottom:0px;
            height:40px;
            width:100%;
            z-index: -1;
            text-align:center; */
        } 
        -->
</style>
<?php /*
<footer class="footer_1 card-shadow">
    <br/>
</footer>*/ ?>
<?php /*
<footer class="footer" id="footer">
    <div class="container-fluid" align="left">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                    Copyright © 2021 IVIC.
                    Sistema Integrado de Gestión para Entes del Sector Público Adaptado por: Oficina de Tecnología de la Información y Comunicación (OTIC) - Coordinación de Desarrollo de Sistemas
                </p>                
            </div>
        </div>        
 
        <!--br /><br /><br /><br /-->
        <!--br /><br /><br /><br /><br /><br /><br /><br /><br /><br /-->
    </div>
</footer>
 * */ ?>
