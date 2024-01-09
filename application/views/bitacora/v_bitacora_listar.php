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
                    <i class="color_7 fas fa-search-location fa-2x"></i>
                    <span class="color_7">Bitacora</span>
                </h4>
            </div>
            <div class="col-md-8 float-left text-right container-fluid mt-2">
                <?php

                if( strlen($this->session->userdata('bitacora_mensaje_tipo')) > 0  ){ ?>
                        <div class="alert <?php echo $this->session->userdata('bitacora_mensaje_tipo'); ?> text-center"><?php
                            echo $this->session->userdata('bitacora_mensaje_contenido'); ?>
                        </div><?php
                        $s_mensaje = array(
                                'bitacora_mensaje_tipo'         => '',
                                'bitacora_mensaje_contenido'    => ''
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

    <div class="row2">
        <div class="container-fluid22 mt-1">

            <script language="javascript">
                    function pulsar(e) { 
                            tecla = (document.all) ? e.keyCode :e.which; 
                            if (tecla==13){enviar();}
                            return (tecla!=13); 
                    }                 
                    function reajustar() {
                            document.form_busqueda.b_id_usuario.value   = "null";
                            document.form_busqueda.b_fecha_desde.value  = "";
                            document.form_busqueda.b_fecha_hasta.value  = "";
                            document.form_busqueda.b_texto.value        = "";
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
                        <?php /*
                        <script type="text/javascript">
                            function ver_reporte(){
                                $b_fecha_desde            = document.form_busqueda.b_fecha_desde.value;
                                if($b_fecha_desde.length == 0){           $b_fecha_desde = "NULL";          }
                                else{ $b_fecha_desde = replaceAll($b_fecha_desde, "/", "-" ); }
                                
                                $b_fecha_hasta            = document.form_busqueda.b_fecha_hasta.value;
                                if($b_fecha_hasta.length == 0){           $b_fecha_hasta = "NULL";          }
                                else{ $b_fecha_hasta = replaceAll($b_fecha_hasta, "/", "-" ); }

                                $b_id_usuario            = document.form_busqueda.b_id_usuario.value;
                                if($b_id_usuario.length == 0){           $b_id_usuario = "NULL";          }

                                $b_texto            = document.form_busqueda.b_texto.value;
                                if($b_texto.length == 0){           $b_texto = "NULL";          }

                                window.open("<?php echo ''.base_url('').''?>index.php/Bitacora/ver_pdf_lista/"+$b_fecha_desde+"/"+$b_fecha_hasta+"/"+$b_id_usuario+"/"+$b_texto);
                            }
                            function replaceAll( text, busca, reemplaza ){
                                while (text.toString().indexOf(busca) != -1)
                                    text = text.toString().replace(busca,reemplaza);
                                return text;
                            }                            
                        </script>
                        
                        <a href="#" onclick="ver_reporte()" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf  text-danger"></i>
                            ver reporte
                        </a>*/ ?>
                        
                        <script type="text/javascript">
                            function ver_reporte(formato){
                                $b_fecha_desde            = document.form_busqueda.b_fecha_desde.value;
                                if($b_fecha_desde.length == 0){           $b_fecha_desde = "NULL";          }
                                else{ $b_fecha_desde = replaceAll($b_fecha_desde, "/", "-" ); }
                                
                                $b_fecha_hasta            = document.form_busqueda.b_fecha_hasta.value;
                                if($b_fecha_hasta.length == 0){           $b_fecha_hasta = "NULL";          }
                                else{ $b_fecha_hasta = replaceAll($b_fecha_hasta, "/", "-" ); }

                                $b_id_usuario            = document.form_busqueda.b_id_usuario.value;
                                if($b_id_usuario.length == 0){           $b_id_usuario = "NULL";          }

                                $b_texto            = document.form_busqueda.b_texto.value;
                                if($b_texto.length == 0){           $b_texto = "NULL";          }

                                if(formato == 'pdf'){
                                    window.open("<?php echo ''.base_url('').''?>index.php/Bitacora/ver_reporte/pdf/"+$b_fecha_desde+"/"+$b_fecha_hasta+"/"+$b_id_usuario+"/"+$b_texto);
                                }
                                if(formato == 'excel'){
                                    window.open("<?php echo ''.base_url('').''?>index.php/Bitacora/ver_reporte/excel/"+$b_fecha_desde+"/"+$b_fecha_hasta+"/"+$b_id_usuario+"/"+$b_texto);
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
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <form action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                                <div class="container-fluid mt-2 mb-1">
                                    <div class="row">

                                        <div class="col-md-4 mt-2 text-left">
                                                <label>Buscar</label>
                                                <input class="form-control" type="text" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="" maxlength="50">
                                        </div>                                        
                                        
                                        <div class="col-md-4 mt-2">
                                        <!--div class="form-group col-md-6"-->
                                            <i class="fas fa-calendar-alt lisa_text_blue"></i> 
                                            <label>Fecha</label>
                                            <div class="shards-demo">
                                                <div class="input-daterange input-group" id="datepicker-example"><?php
                                                    if(strlen($b_fecha_desde) > 2){}
                                                    ?>
                                                    <input type="text" class="input-sm form-control" name="b_fecha_desde" placeholder="Desde" value="<?php echo $b_fecha_desde; ?>" readonly/>
                                                    <input type="text" class="input-sm form-control" name="b_fecha_hasta" placeholder="Hasta" value="<?php echo $b_fecha_hasta; ?>" readonly/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-2">
                                            <label>Usuario</label>
                                            <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="b_id_usuario" name="b_id_usuario" data-show-subtext="true" data-live-search="true">
                                                <?php
                                                $valorSel  = $b_id_usuario;
                                                ?><option value="null">Seleccione</option><?php
                                                for($i = 0; $i < count($matriz_conf_usuarios); $i++){
                                                    $valor_a_mostrar = "(".$matriz_conf_usuarios[$i]->ci_usu.") ".$matriz_conf_usuarios[$i]->nombre_usu." ".$matriz_conf_usuarios[$i]->apellido_usu;
                                                    $valor = $matriz_conf_usuarios[$i]->id_usuario;  ?>
                                                    <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>
                                
                                <div class="container-fluid mt-2 mb-1">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-secondary" onclick="enviar()">Buscar</button>
                                            <button type="button" class="btn btn-secondary mx-sm-1" onclick="reajustar()">Reajustar</button>
                                        </div>
                                    </div>                                                                    
                                </div>
                              
                                
                                <?php /*
                                <div class="form-group mx-sm-0 mb-2">
                                    <button type="button" class="btn btn-secondary" onclick="reajustar()">reajustar</button>
                                </div>  */ ?>                              
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <th scope="col"><div style="color:#FFF">ID</div></th>
                            <th scope="col"><div style="color:#FFF" class="">FECHA</div></th>
                            <th scope="col"><div style="color:#FFF" class="">HORA</div></th>
                            <th scope="col"><div style="color:#FFF" class="">IP</div></th>
                            <th scope="col"><div style="color:#FFF" class="text-left">USUARIO</div></th>
                            <th scope="col"><div style="color:#FFF" class="text-left">ACCIÓN</div></th>
                            <!--th scope="col"><div style="color:#FFF">Acciones</div></th-->
                        </tr>
                    </thead>
                    <tbody class="bg-white"><?php
                    if($dat_list != false){
                            foreach ($dat_list as $dat) {   ?>
                                <tr class="text-center">
                                    <th scope="row"><?=$dat->conf_bitacora_id?></th>
                                    <td><?=$dat->conf_bitacora_fecha?></td>
                                    <td><?=$dat->conf_bitacora_hora?></td>
                                    <td><?=$dat->conf_bitacora_ip_usuario?></td>
                                    <td align="left"><?php echo "(".$dat->conf_usuarios_ci_usu.") ".$dat->conf_usuarios_nombre_usu." ".$dat->conf_usuarios_apellido_usu; ?></td>
                                    <td align="left"><?=$dat->conf_bitacora_accion_2?></td>
                                    <?php /*
                                    <td>
                                        <script type="text/javascript">
                                            function abreVentana($conf_bitacora_id){
                                                    window.open("<?php echo ''.base_url('').''?>index.php/Bitacora/ver_pdf_detalle/"+$conf_bitacora_id);
                                            }
                                        </script>  
                                        <a class="text_azul mr-2" href="#" onclick="abreVentana('<?php echo $dat->conf_bitacora_id; ?>')">
                                            <span data-toggle="tooltip" data-placement="left" title="Ver detalle"><i class="fas fa-file-pdf text-danger"></i></span>
                                        </a>
                                    </td>*/ ?>
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
    <a href="<?=site_url('Menues/menu_consultas')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
        <i class="fas fa-arrow-circle-left fa-5x"></i>
    </a>*/ ?>

</div>