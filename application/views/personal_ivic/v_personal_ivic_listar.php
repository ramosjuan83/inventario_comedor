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
                    <i class="color_7 fas fa-users fa-2x"></i>
                    <span class="color_7">Personal Ivic</span>
                </h4>
            </div>
            <div class="col-md-6 float-left text-right container-fluid mt-2">
                <?php

                if( strlen($this->session->userdata('personal_ivic_mensaje_tipo')) > 0  ){ ?>
                        <div class="alert <?php echo $this->session->userdata('personal_ivic_mensaje_tipo'); ?> text-center"><?php
                            echo $this->session->userdata('personal_ivic_mensaje_contenido'); ?>
                        </div><?php
                        $s_mensaje = array(
                                'personal_ivic_mensaje_tipo'         => '',
                                'personal_ivic_mensaje_contenido'    => ''
                        );
                        $this->session->set_userdata($s_mensaje);
                } ?>
            </div>
            <div class="col-md-2 float-left text-right estilo1 container-fluid mt-2">
                <?php /*
                <a href="<?php echo site_url('bitacora/agregar'); ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Agregar
                </a>*/ ?>
            </div>
        </div>
    </div>    

    <div class="row22">
        <div class="container-fluid22 mt-1">

            <script language="javascript">
                    function pulsar(e) { 
                            tecla = (document.all) ? e.keyCode :e.which; 
                            if (tecla==13){enviar();}
                            return (tecla!=13); 
                    }                 
                    function reajustar() {
                            document.form_busqueda.b_texto.value     = "";
                            document.form_busqueda.b_id_cargo.value     = "null";
                            document.form_busqueda.b_id_gerencia.value     = "null";
                            document.form_busqueda.b_estado.value     = "";
                            enviar();
                    }
                    function enviar() {
                            document.form_busqueda.submit();
                            //if ( validarForm() ){	document.form_busqueda.submit();	}
                    }
            </script>
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-md-6 mb-2 mt-2">
                        <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-filter"></i>
                            Filtrar por:
                        </a>
                    </div>
                    <div class="col-md-6 mb-2 mt-2 text-right">
                        <script type="text/javascript">
                            function ver_reporte(formato){
                                $b_texto            = document.form_busqueda.b_texto.value;
                                if($b_texto.length == 0){           $b_texto = "NULL";          }
                                
                                $b_id_cargo = document.form_busqueda.b_id_cargo.value;
                                if($b_id_cargo.value > 0){           $b_id_cargo = "NULL";          }
                                
                                $b_id_gerencia = document.form_busqueda.b_id_gerencia.value;
                                if($b_id_gerencia.value > 0){           $b_id_gerencia = "NULL";    }
                            
                                $b_estado            = document.form_busqueda.b_estado.value;
                                if($b_estado.length == 0){           $b_estado = "NULL";          }

                                if(formato == 'pdf'){
                                    window.open("<?php echo ''.base_url('').''?>index.php/Personal_ivic/ver_reporte/pdf/"+$b_texto+"/"+$b_id_cargo+"/"+$b_id_gerencia+"/"+$b_estado);    
                                }
                                if(formato == 'excel'){
                                    window.open("<?php echo ''.base_url('').''?>index.php/Personal_ivic/ver_reporte/excel/"+$b_texto+"/"+$b_id_cargo+"/"+$b_id_gerencia+"/"+$b_estado);    
                                }
                            }
                            function replaceAll( text, busca, reemplaza ){
                                while (text.toString().indexOf(busca) != -1)
                                    text = text.toString().replace(busca,reemplaza);
                                return text;
                            }                            
                        </script>
                        <span class="text-success" data-toggle="tooltip" data-placement="left" title="Ver reporte en formato PDF">
                            <a href="#" onclick="ver_reporte('pdf')" class="btn btn-outline-secondary">
                                <i class="fas fa-file-pdf  text-danger"></i>
                            </a>
                        </span>
                        <span class="text-success" data-toggle="tooltip" data-placement="left" title="Ver reporte en formato de Excel">
                            <a href="#" onclick="ver_reporte('excel')" class="btn btn-outline-secondary">
                                <i class="fas fa-file-excel  text-success"></i>
                            </a>
                        </span>

                        <a href="<?php echo site_url('personal_ivic/agregar'); ?>" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </a> 
                    </div>
                </div>
            </div> 
            
            <div class="row">
                <div class="col-md-12">
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <form class="" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                                <!--div class="container-fluid mb-1">
                                    <div class="row align-items-end"-->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <!--label>Buscar</label-->
                                                <input class="form-control mb-2 mr-sm-2 form-control" type="text" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="" maxlength="50">
                                        <!--/div> 
                                        <div class="col-md-6 mt-2"-->
                                            <!--div class="form-group col-md-12"-->

                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-secondary" onclick="enviar()">Buscar</button>
                                                <button type="button" class="btn btn-secondary mx-sm-1" onclick="reajustar()">Reajustar</button>                                                
                                            </div>
                                        </div>
                                            
                                        <div class="row">   
                                            <div class="col-md-6">                                        
                                                <label for="b_id_cargo" class="mr-sm-2">Cargo:</label>
                                                <select class="mb-2 mr-sm-2 selectpicker" id="b_id_cargo" name="b_id_cargo" data-show-subtext="true" data-live-search="true">
                                                    <?php
                                                    $valorSel  = $b_id_cargo;
                                                    ?><option value="null">Seleccione</option><?php
                                                    if($matriz_cargos != false){
                                                        for($i = 0; $i < count($matriz_cargos); $i++){
                                                            $valor_a_mostrar = $matriz_cargos[$i]->nombre;
                                                            $valor = $matriz_cargos[$i]->id;  ?>
                                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php                                                    
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">   
                                            <div class="col-md-6">                                        
                                                <label for="b_id_gerencia" class="mr-sm-2">Gerencia:</label>
                                                <select class="mb-2 mr-sm-2 selectpicker" id="b_id_gerencia" name="b_id_gerencia" data-show-subtext="true" data-live-search="true">
                                                    <?php
                                                    $valorSel  = $b_id_gerencia;
                                                    ?><option value="null">Seleccione</option><?php
                                                    if($matriz_gerencias != false){
                                                        for($i = 0; $i < count($matriz_gerencias); $i++){
                                                            $valor_a_mostrar = $matriz_gerencias[$i]->nombre;
                                                            $valor = $matriz_gerencias[$i]->id;  ?>
                                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php                                                    
                                                        }
                                                    } ?>
                                                </select>
                                            </div> 
                                            
                                            <div class="col-md-6">
                                            <!--/div>
                                            <div class="col-md-6 mt-2"-->
                                                <!--label>Estado</label-->
                                                <label for="b_estado" class="mr-sm-2">Estado:</label>
                                                <!--select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="b_estado" name="b_estado" data-show-subtext="true" data-live-search="true" onchange="enviar()"-->
                                                <select class="mb-2 mr-sm-2 selectpicker" id="b_estado" name="b_estado" data-show-subtext="true" data-live-search="true">
                                                    <?php
                                                    $valorSel  = $b_estado;
                                                    $valor = "";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Todos</option><?php
                                                    $valor = "1";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Activo</option><?php
                                                    $valor = "2";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>No Activo</option><?php
                                                    ?>
                                                </select>
                                            </div>                                            
                                            
                                        </div>                                        
                                    <!--/div>                                    
                                </div-->
                                <?php /*
                                <div class="container-fluid mt-2 mb-1">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-secondary" onclick="enviar()">Buscar</button>
                                            <button type="button" class="btn btn-secondary mx-sm-1" onclick="reajustar()">Reajustar</button>
                                        </div>
                                    </div>                                                                    
                                </div>
                              */ ?>
                                
                                <?php /*
                                <div class="form-group mx-sm-0 mb-2">
                                    <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                                </div>  */ ?>                              
                            </form>                
                        </div>
                    </div>
                </div>
            </div>            

            <?php /*
            <form class="form-inline" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                <div class="form-group mb-2">
                  <input class="form-control" type="text" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="20" maxlength="20">
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <label for="exampleFormControlSelect1">Estado</label>
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <select class="form-control" id="b_estado" name="b_estado" onchange="enviar()"><?php
                        $valorSel  = $b_estado;
                        $valor = "";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Todos</option><?php
                        $valor = "1";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>Activo</option><?php
                        $valor = "2";  ?><option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>>No Activo</option><?php
                        ?>
                    </select> 
                </div> 
                <div class="form-group mx-sm-1 mb-2">
                    <label for="exampleFormControlSelect1">Cargo</label>
                </div>                
                <div class="form-group mx-sm-1 mb-2">
                    <select class="form-control text-white selectpicker" id="b_id_cargo" name="b_id_cargo" data-show-subtext="true" data-live-search="true">
                        <?php
                        $valorSel  = ""; //$b_id_cargo;
                        ?><option value="null">Seleccione</option><?php
                        if($matriz_cargos != false){
                            for($i = 0; $i < count($matriz_cargos); $i++){
                                $valor_a_mostrar = $matriz_cargos[$i]->nombre;
                                $valor = $matriz_cargos[$i]->id;  ?>
                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                            }                            
                        }   ?>
                    </select>                
                </div>
                <div class="form-group mx-sm-1 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="enviar()">buscar</button>
                </div>
                <div class="form-group mx-sm-0 mb-2">
                    <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                </div>
            </form>*/ ?>
            <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <th scope="col">CARNET</th>
                            <th scope="col" class="text-left">CEDULA</th>
                            <th scope="col" class="text-left">NOMBRES</th>
                            <th scope="col" class="text-left">APELLIDOS</th>
                            <th scope="col" class="text-left">CARGO</th>
                            <th scope="col" class="text-left">GERENCIA</th>
                            <th scope="col" class="text-center">ESTADO</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white"><?php
                    if($dat_list != false){
                            foreach ($dat_list as $dat) {   ?>
                                <tr class="text-center">
                                    <th scope="row"><?=$dat->carnet_codigo?></th>
                                    <td class="text-left"><?=$dat->cedula?></td>
                                    <td class="text-left"><?=$dat->nombres?></td>
                                    <td class="text-left"><?=$dat->apellidos?></td>
                                    <td class="text-left"><?=$dat->cargos_nombre?></td>
                                    <td class="text-left"><?=$dat->gerencia_nombre?></td>
                                    <td class="text-center"><?php 
                                        //if($dat->estatus_fac == 1){ echo "<span style='color:#4D6185;'>Registrada</span>"; }
                                        if($dat->estado == 1){ ?>
                                            <span class="text-success mr-2" data-toggle="tooltip" data-placement="left" title="Activo"><i class="fas fa-circle"></i></span><?php
                                        }
                                        if($dat->estado != 1){  ?>
                                            <span class="text-danger mr-2" data-toggle="tooltip" data-placement="left" title="No Activo: <?php echo $dat->estado_nombre; ?>"><i class="fas fa-circle"></i></span><?php
                                        } ?>
                                    </td>
                                    <td>
                                        
                                        <a class="text_azul mr-2" href="<?=site_url('personal_ivic/editar/'.$dat->id)?>">
                                            <span data-toggle="tooltip" data-placement="left" title="Editar"><i class="far fa-edit"></i></span>
                                        </a>
                                        
                                        <?php
                                        
                                        if($dat->tiene_movimiento_en_comensales == true){ ?>
                                            <span class="text-secondary mr-2" data-toggle="tooltip" data-placement="left" title="Eliminar (No puede eliminar, tiene registro como Comensal)"><i class="fas fa-trash-alt"></i></span><?php
                                        }else{ ?>
                                            <a class="text-danger mr-2" href="#" data-toggle="modal" data-target="#exampleModal<?php echo $dat->id; ?>">
                                                <span data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fas fa-trash-alt"></i></span>
                                            </a><?php
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
                                                <a href="<?php echo site_url('personal_ivic/eliminar/'.$dat->id); ?>">
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
                                    <td colspan="8">
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