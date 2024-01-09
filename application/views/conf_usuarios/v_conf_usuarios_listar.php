<div class="container-fluid">
    <div class="row">
        <div class="container-fluid mt-0">
            <style type="text/css">
                .estilo1 {
                  padding: 0.75rem;
                  border-bottom: none;
                }
            </style>            
            <div class="col-md-2 float-left estilo1">
                <h4>
                    <i class="color_7 fa fa-users fa-2x"></i>
                    <span class="color_7">Usuarios</span>
                </h4>
            </div>
            <?php
            //alert-danger
            //alert-warning
            //alert-info
            //alert-success
            ?>
            <div class="col-md-8 float-left text-right container-fluid mt-2">
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
            <div class="col-md-2 float-left text-right estilo1 container-fluid mt-2">
                <a href="<?=site_url('Conf_usuarios/agregar')?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Agregar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid mt-1">

            <script language="javascript">
                    function pulsar(e) { 
                            tecla = (document.all) ? e.keyCode :e.which; 
                            if (tecla==13){enviar();}
                            return (tecla!=13); 
                    }                 
                    function reajustar() {
                            document.form_busqueda.b_texto.value     = "";
                            if(document.form_busqueda.b_estado){
                                document.form_busqueda.b_estado.value     = "";    
                            }
                            document.form_busqueda.b_campo_ordenar.value        = "conf_usuarios.ci_usu";
                            document.form_busqueda.b_orden.value                = "ASC";                            
                            enviar();
                    }
                    function enviar() {
                            document.form_busqueda.submit();
                            //if ( validarForm() ){	document.form_busqueda.submit();	}
                    }                
            </script>

            <form class="form-inline" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                <div class="form-group mb-2">
                  <input class="form-control" type="text" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="20" maxlength="20">
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="enviar()">buscar</button>
                </div>
                
                <div class="form-group mx-sm-1 mb-2">
                    <label for="exampleFormControlSelect1">Estado</label>
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <select class="form-control" id="b_estado" name="b_estado" onchange="enviar()"><?php
                        $valorSel  = $b_estado;
                        $valor = "";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Todos</option><?php
                        $valor = "1";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Habilitado</option><?php
                        $valor = "2";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Deshabilitado</option><?php
                        ?>
                    </select> 
                </div>
                
                <div class="form-group mx-sm-1 mb-2">
                    <label for="exampleFormControlSelect1">Ordenar Por</label>
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <select class="form-control" id="b_campo_ordenar" name="b_campo_ordenar" onchange="enviar()"><?php
                        $valorSel  = $b_campo_ordenar;
                        $valor = "conf_usuarios.ci_usu";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>C&eacute;dula</option><?php
                        $valor = "conf_usuarios.apellido_usu";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Apellidos</option><?php
                        $valor = "conf_usuarios.nombre_usu";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Nombres</option><?php
                        ?>
                    </select> 
                </div>  
                <div class="form-group mx-sm-1 mb-2">
                    <div class="form-check"><?php
                        $valorSel = $b_orden;
                        $valor = "ASC"; ?><input class="form-check-input" type="radio" name="b_orden" id="exampleRadios1" value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "checked";} ?> onchange="enviar()">
                        <label class="form-check-label" for="exampleRadios1">
                            Ascendente
                        </label>
                    </div>
                    <div class="form-check  mx-sm-1"><?php
                        $valor = "DESC"; ?><input class="form-check-input" type="radio" name="b_orden" id="exampleRadios2" value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "checked";} ?> onchange="enviar()">
                        <label class="form-check-label" for="exampleRadios2">
                            Descendente
                        </label>
                    </div>
                </div>                
                
                <div class="form-group mx-sm-0 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <!--th scope="col">#</th-->
                            <th scope="col" class="text-left">C&eacute;dula</th>
                            <th scope="col" class="text-left">Apellidos</th>
                            <th scope="col" class="text-left">Nombres</th>
                            <th scope="col" align="center">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white"><?php
                    if($dat_list != false){
                            foreach ($dat_list as $dat) {   ?>
                                <tr class="text-center">
                                    <!--th scope="row"><?//=$dat->id_usuario?></th-->
                                    <td class="text-left"><?php
                                        //echo number_format($dat->ci_usu,0,",","."); 
                                        echo "<strong>".$dat->ci_usu."</strong>";
                                        ?>
                                    </td>
                                    <td class="text-left"><?=$dat->apellido_usu?></td>
                                    <td class="text-left"><?=$dat->nombre_usu?></td>
                                    <td><?php 
                                        //if($dat->estatus_fac == 1){ echo "<span style='color:#4D6185;'>Registrada</span>"; }
                                        if($dat->estado == 1){ //echo "Habilitado"; ?>
                                            <span class="text-success mr-2" data-toggle="tooltip" data-placement="left" title="Habilitado"><i class="fas fa-circle"></i></span><?php
                                        }
                                        if($dat->estado == 2){ //echo "<span style='color:#DC3545;'>Deshabilitado</span>"; ?>
                                            <span class="text-danger mr-2" data-toggle="tooltip" data-placement="left" title="Deshabilitado"><i class="fas fa-circle"></i></span><?php
                                        } ?>
                                    </td>
                                    <td>

                                        <a class="text_azul mr-2" href="<?=site_url('Conf_usuarios/editar_como_administrador/'.$dat->id_usuario)?>">
                                            <span data-toggle="tooltip" data-placement="left" title="Editar"><i class="far fa-edit"></i></span>
                                        </a>
                                        
                                        <?php
                                        //if($id_conf_roles_es_1 == true){ ?>
                                            <a class="text_azul mr-2" href="<?=site_url('Conf_usu_pass/editar_contrasena_como_administrador/'.$dat->id_usuario."/listar")?>">
                                                <span data-toggle="tooltip" data-placement="left" title="Editar contrase&ntilde;a"><i class="fas fa-key"></i></span>
                                            </a><?php
                                            /*
                                        }else{ ?>
                                            <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Editar contrase&ntilde;a (solo administrador)"><i class="fas fa-key"></i></span><?php
                                        } */
                                        
                                        if($dat->tiene_movimiento == 0){ ?>

                                                <a class="text-danger mr-2" href="#" data-toggle="modal" data-target="#exampleModal<?php echo $dat->id_usuario; ?>">
                                                    <span data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fas fa-trash-alt"></i></span>
                                                </a>
                                        
		                                <div class="modal fade" id="exampleModal<?php echo $dat->id_usuario; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		                                        <a href="<?=site_url('Conf_usuarios/eliminar/'.$dat->id_usuario)?>">
		                                            <button type="button" class="btn btn-primary">Aceptar</button>
		                                        </a>
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div>                                    

                                            <?php
                                        }else{
                                            if($dat->estado == 1){ ?>
                                                <a class="text-danger mr-2" href="#" data-toggle="modal" data-target="#exampleModal<?php echo $dat->id_usuario; ?>">
                                                    <span data-toggle="tooltip" data-placement="left" title="Deshabilitar"><i class="fas fa-ban"></i></span>
                                                </a>

		                                <div class="modal fade" id="exampleModal<?php echo $dat->id_usuario; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		                                  <div class="modal-dialog" role="document">
		                                    <div class="modal-content">
		                                      <div class="modal-header">
		                                        <h5 class="modal-title" id="exampleModalLabel">&iquest;Desea deshabilitar este registro?</h5>
		                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                                          <span aria-hidden="true">&times;</span>
		                                        </button>
		                                      </div>
		                                      <!--div class="modal-body">
		                                        ...
		                                      </div-->
		                                      <div class="modal-footer">
		                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		                                        <a href="<?=site_url('Conf_usuarios/deshabilitar/'.$dat->id_usuario)?>">
		                                            <button type="button" class="btn btn-primary">Aceptar</button>
		                                        </a>
		                                      </div>
		                                    </div>
		                                  </div>
		                                </div><?php                                                
                                            }else{ ?>
                                                <span class="mr-2" data-toggle="tooltip" data-placement="left" title="Deshabilitar"><i class="fas fa-ban"></i></span><?php
                                            }
                                        } ?>
                                    </td>
                                </tr><?php
                            }
                    }else{ ?>
                                <tr class="text-center">
                                    <td colspan="6">
                                        No hay registro para mostrar
                                    </td>
                                </tr>
                        <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 float-left">
            <ul class="pagination"><?php
                echo $this->pagination->create_links(); ?>
            </ul>            
        </div>
        <div class="col-md-3 float-left">
            <label class="estilo_para_paginacion"><?php echo $pag_desde; ?> - <?php echo $pag_hasta; ?> de <?php echo $pag_totales; ?></label>
        </div>
    </div>  
    
    <?php /*
    <a href="<?=site_url('Menues/menu_usuarios')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
        <i class="fas fa-arrow-circle-left fa-5x"></i>
    </a>    */ ?>

</div>