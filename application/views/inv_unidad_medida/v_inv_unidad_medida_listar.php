<div class="container-fluid">
    <div class="row">
        <div class="container-fluid mt-0">
            <style type="text/css">
                .estilo1 {
                  padding: 0.75rem;
                  border-bottom: none;
                }
            </style>
            <div class="col-md-4 float-left estilo1">
                <h4>
                    <i class="color_7 fas fa-weight fa-2x"></i>
                    <span class="color_7">Unidad de Medida</span>
                </h4>
            </div>
            <?php
            //alert-danger
            //alert-warning
            //alert-info
            //alert-success
            ?>
            <div class="col-md-6 float-left text-right container-fluid mt-2">
                <?php

                if( strlen($this->session->userdata('inv_unidad_medida_mensaje_tipo')) > 0  ){ ?>
                        <div class="alert <?php echo $this->session->userdata('inv_unidad_medida_mensaje_tipo'); ?> text-center"><?php
                            echo $this->session->userdata('inv_unidad_medida_mensaje_contenido'); ?>
                        </div><?php
                        $s_mensaje = array(
                                'inv_unidad_medida_mensaje_tipo'         => '',
                                'inv_unidad_medida_mensaje_contenido'    => ''
                        );
                        $this->session->set_userdata($s_mensaje);
                } ?>
            </div>
            <div class="col-md-2 float-left text-right estilo1 container-fluid mt-2">
                <a href="<?php echo site_url('Inv_unidad_medida/agregar'); ?>" class="btn btn-primary">
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
                            
                            enviar();
                    }
                    function enviar() {
                            document.form_busqueda.submit();
                            //if ( validarForm() ){	document.form_busqueda.submit();	}
                    }
            </script>
            <!--form action="gerencias/listar" method="post" name="form_busqueda" target="_self"-->
            <?php /*
            $atributos2 = array('name' => 'form_busqueda', 'id' => 'form_busqueda', 'enctype' => 'multipart/form-data');
            echo form_open('gerencias/listar', $atributos2); ?>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <!--input name="b_texto" id="b_texto" type="text" value="<?php //echo $b_texto; ?>" onkeypress="return pulsar(event)" size="25" maxlength="25" /-->
                        <input class="form-control" type="text" value="<?php echo $b_texto; ?>" placeholder="texto a buscar" onkeypress="return pulsar(event)" size="25" maxlength="25">
                        <button type="button" class="btn btn-secondary" onclick="enviar()">buscar</button>
                        <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                    </td>
                </tr>
            </table><?php
            echo form_close(); */ ?>
            
            <form class="form-inline" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                <div class="form-group mb-2">
                  <input class="form-control" type="text" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="20" maxlength="20">
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="enviar()">buscar</button>
                </div>
                <div class="form-group mx-sm-0 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col" class="text-left">NOMBRE</th>
                            <th scope="col" class="text-left">OBSERVACIÓN</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white"><?php
                    if($dat_list != false){
                            foreach ($dat_list as $dat) {   ?>
                                <tr class="text-center">
                                    <!-- <th scope="row"><?=$dat->id?></th> -->
                                    <td class="text-left"><?=$dat->nombre?></td>
                                    <td class="text-left"><?=$dat->observacion?></td>
                                    <td>
                                        
                                    <?php if ($dat->id_status !=2) { ?>
                                        <a class="text_azul mr-2" href="<?=site_url('Inv_unidad_medida/editar/'.$dat->id)?>">
                                            <span data-toggle="tooltip" data-placement="left" title="Editar"><i class="far fa-edit"></i></span>
                                        </a>
                                    <?php } ?>    
                                        
                                        <?php
                                        if($dat->esta_asociado_en_personal_ivic == true){ ?>
                                            <span class="text-secondary mr-2" data-toggle="tooltip" data-placement="left" title="Eliminar (No puede eliminar, se encuentra asociado con un personal del IVIC)"><i class="fas fa-trash-alt"></i></span><?php
                                        }else{ ?>
                                                <?php if ($dat->id_status !=2) { ?>
                                                    <a class="text-danger mr-2" href="#" data-toggle="modal" data-target="#exampleModal<?php echo $dat->id; ?>">
                                                            <span data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fas fa-trash-alt"></i></span>
                                                    </span>
                                                    </a><?php
                                                    }else{ ?>
                                                
                                                        <div id="mensaje_eliminado" class="text-danger error-camp">
                                                        <i class="fa fa-exclamation-circle fa-2x"></i>
                                                        Eliminado   </div>
                                                <?php  
                                                    }
                                        } ?>
                                            
                                        <div class="modal fade" id="exampleModal<?php echo $dat->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <a href="<?php echo site_url('Inv_unidad_medida/eliminar/'.$dat->id); ?>">
                                                    <button type="button" class="btn btn-primary">Aceptar</button>
                                                </a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                    </td>
                                </tr><?php
                            }
                    }else{ ?>
                                <tr class="text-center">
                                    <td colspan="5">
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
    <a href="<?=site_url('Menues/menu_administrar_pensum')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
        <i class="fas fa-arrow-circle-left fa-5x"></i>
    </a>*/ ?>

</div>