<!--div class="container-fluid">
    <div class="row">
        <div class="col-md-12"--> 
                <!--nav class="navbar navbar-expand-lg navbar-light bg-light"-->
                <!--nav class="navbar navbar-expand-lg navbar-light m-0" style="background-color: #fff"-->
                <!--nav class="navbar navbar-expand-lg navbar-light m-0 sombra mb-4" style="background-color: #1F74AF"-->
                <nav class="navbar navbar-expand-lg navbar-light m-0 sombra" style="background-color: #1F74AF">
                  <!--a class="navbar-brand" href="#">Navbar</a-->
                  
                    <a class="navbar-brand text-white mt-0" href="#" data-toggle="modal" data-target="#exampleModalCenter">
                        <img class="img-fluid" src="<?php echo '' .base_url('/images').''?>/logo-ivic.png" width="107" height="60" alt="" />
                    </a>    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <!--h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5-->
                            <h1>
                                <img src="<?php echo '' .base_url('/images').''?>/logo-ivic.png" width="179" height="100" alt="" />
                            </h1>                
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                <b>IVIC</b> SISTEMA INTEGRAL 
                                <br><br>
                                ACTUALIZACIÓN N°<span class='badge badge-pill badge-info'>25</span>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!--button type="button" class="btn btn-primary">Save changes</button-->
                          </div>
                        </div>
                      </div>
                    </div>                  
                  
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <!--a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a-->
                          <a class="nav-link" href="<?=site_url('Login')?>">
                              <i class="align-middle fas fa-home color_5"></i>
                              <span class="color_5">Inicio</span>
                          </a>
                        </li>
                        <!--li class="nav-item">
                          <a class="nav-link" href="#">Link</a>
                        </li-->
                      
                        <?php 
                             //echo $this->session->userdata['username']; echo "*";
                            //echo "session *<pre>"; print_r($this->session->userdata); echo "</pre>*";
                        ?>                        
                        
                        <?php 
                        if($this->session->userdata['id_conf_roles_es_1'] == true){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs color_5"></i>
                                    <span class="color_5">Configuraci&oacute;n</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Bitacora/listar/limpiar')?>"><i class="fas fa-search-location color_7"></i> Bitácora</a>
                                    <a class="dropdown-item" href="<?=site_url('Conf_usuarios/listar/limpiar')?>"><i class="fa fa-users color_7"></i> Usuarios</a>  
                                </div>
                            </li><?php
                        } 
                        
                        if($this->session->userdata['id_conf_roles_es_2'] == true){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-people-group color_5"></i>
                                    <span class="color_5">Gestión Humana</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Cargos/listar/limpiar')?>"><i class="fas fa-user-tie color_7"></i> Cargos</a>
                                    <?php /* //ESTOS MENU DEBEN DE ESTAR COMENTADO HASTA AJUSTAR ESTOS CRUD
                                    <a class="dropdown-item" href="<?=site_url('Gerencias/listar/limpiar')?>"><i class="fas fa-sitemap color_7"></i> Centro</a>
                                    <a class="dropdown-item" href="<?=site_url('Departamento/listar/limpiar')?>"><i class="fas fa-sitemap color_7"></i> Coordinación / Unidad</a>
                                     * */ ?>
                                    <a class="dropdown-item" href="<?=site_url('Gerencias/listar/limpiar')?>"><i class="fas fa-sitemap color_7"></i> Centro</a>
                                    <a class="dropdown-item" href="<?=site_url('Departamento/listar/limpiar')?>"><i class="fas fa-sitemap color_7"></i> Coordinación / Unidad</a>
                                    
                                    <a class="dropdown-item" href="<?=site_url('Personal_ivic/listar/limpiar')?>"><i class="fas fa-users color_7"></i> Personal Ivic</a>
                                    <a class="dropdown-item" href="<?=site_url('Personal_visitante/listar/limpiar')?>"><i class="fas fa-users color_7"></i> Personal Externo</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/reporte_form')?>"><i class="fas fa-file-pdf color_7"></i> Reporte comensal</a>
                                </div>
                            </li><?php
                        }

                        if($this->session->userdata['id_conf_roles_es_6'] == true){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-people-group color_5"></i>
                                    <span class="color_5">C.E.A</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Personal_ivic/listar/limpiar')?>"><i class="fas fa-users color_7"></i> Personal Ivic</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/reporte_form')?>"><i class="fas fa-file-pdf color_7"></i> Reporte comensal</a>
                                </div>
                            </li><?php
                        }                        
                        
                        if($this->session->userdata['id_conf_roles_es_3'] == true){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-tie color_5"></i>
                                    <span class="color_5">Administrador de comedor</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Personal_visitante/listar/limpiar')?>"><i class="fas fa-users color_7"></i> Personal Externo</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/listar_programados')?>"><i class="fas fa-calendar-day color_7"></i> Programación de Comensales</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/agregar')?>"><i class="fas fa-user-check color_7"></i> Administrar comensal</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/listar')?>"><i class="fas fa-people-line color_7"></i> Administrar comensal lista</a>
                                    <a class="dropdown-item" href="<?=site_url('Comensal/reporte_form')?>"><i class="fas fa-file-pdf color_7"></i> Reporte comensal</a>
                                </div>
                            </li><?php
                        }
                        
                        if($this->session->userdata['id_conf_roles_es_4'] == true){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-tie color_5"></i>
                                    <span class="color_5">Comedor Cajero</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Comensal/agregar')?>"><i class="fas fa-user-check color_7"></i> Administrar comensal</a>
                                </div>
                            </li><?php
                        }                        
                        
                        ?>
                        <?php
                        //if($id_conf_roles_es_1 == true or $id_conf_roles_es_4 == true){
                            /*
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-users color_5"></i>
                                    <span class="color_5">Usuarios</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=site_url('Conf_usuarios/listar/limpiar')?>"><i class="fa fa-users color_5"></i> Usuarios</a>  
                                    <a class="dropdown-item" href="<?=site_url('Menues/menu_profesores')?>"><i class="fas fa-chalkboard-teacher color_5"></i> Profesores</a>
                                    <a class="dropdown-item" href="<?=site_url('Estudiante_ficha/listar/limpiar')?>"><i class="fas fa-user-graduate color_5"></i> Estudiantes</a>                                    
                                </div>
                            </li>                            
                            <?php
                            */
                        //} ?>
                        
                    </ul>
                    <!--form class="form-inline my-2 my-lg-0">
                      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form-->
                    
                    <span class="navbar-text">
                        <?php
                        $icono                  = "fa fa-user";
                        $tipo_de_usuario        = "Sr.(a):";
                        ?>


                        <?php /*
                        if(isset($usuario_mensaje)){}else{ $usuario_mensaje = ""; }
                        if(strlen($usuario_mensaje) > 0){ ?>
                            <span class="<?php echo $usuario_mensaje_color; ?> mr-2" data-toggle="tooltip" data-placement="left" title="<?php echo $usuario_mensaje; ?>"><i class="fas fa-circle"></i></span><?php
                        } */?>                        
                            
                        <?php /*
                        <i class="<?php echo $icono; ?> la-2x color_5"></i>
                        <span class="color_5"><?php echo $tipo_de_usuario; ?> <?= $this->session->userdata['username']?> <?=$this->session->userdata['userapell']?></span>
                         * */ ?>

                  
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if(isset($usuario_mensaje)){}else{ $usuario_mensaje = ""; }
                                    if(strlen($usuario_mensaje) > 0){ ?>
                                        <span class="<?php echo $usuario_mensaje_color; ?> mr-2" data-toggle="tooltip" data-placement="left" title="<?php echo $usuario_mensaje; ?>"><i class="fas fa-circle"></i></span><?php
                                    } ?>                                    
                                    <i class="<?php echo $icono; ?> la-2x color_5"></i>
                                    <span class="color_5"><?php echo $tipo_de_usuario; ?> <?= $this->session->userdata['username']?> <?=$this->session->userdata['userapell']?></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php /*
                                    <a class="dropdown-item" href="<?=site_url('Conf_usuarios/ver/menu_usuarios')?>"><i class="fa fa-user color_5"></i> Mis datos (En construcción)</a>  
                                     * */ ?>
                                    <a class="dropdown-item" href="<?=site_url('Conf_usu_pass/editar_contrasena_como_usuario/NULL')?>"><i class="fas fa-key color_7"></i> Cambiar contrase&ntilde;a</a>  
                                </div>
                            </li>                         
                        </ul>
                        
                    </span>
                    <!--span class="navbar-text ml-4" style="color:#c40001"-->
                    <span class="navbar-text" style="color:#c40001">
                        <!--<a href="<? //=site_url('ifs_app/destroy/')?>" class="btn btn-outline-danger text-danger border-0"><i class="fa fa-power-off fa-2x"></i></a>-->
                        <!-- Button trigger modal -->
                        <!--button type="button" class="btn btn-outline-danger text-danger border-0" data-toggle="modal" data-target="#modal_loggout"><i class="fa fa-power-off fa-2x"></i></button-->
                        <button type="button" class="btn btn-outline-danger border-0" data-toggle="modal" data-target="#modal_loggout"><i class="fa fa-power-off fa-2x"></i></button>
                    </span>

                    <!-- Modal -->
                    <div class="modal fade" id="modal_loggout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cerrar Sesión</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ¿Desea salir del sistema?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <a href="<?=site_url('Login/destroy/')?>" class="btn btn-primary">Aceptar</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                </nav>            
        <!--/div>
    </div>
</div-->
