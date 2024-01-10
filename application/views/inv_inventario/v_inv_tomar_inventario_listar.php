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
                    <i class="color_7 fas fa-cart-flatbed fa-2x"></i>
                    <span class="color_7">Tomar Inventario</span>
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

                if( strlen($this->session->userdata('inv_inventario_mensaje_tipo')) > 0  ){ ?>
                        <div class="alert <?php echo $this->session->userdata('inv_inventario_mensaje_tipo'); ?> text-center"><?php
                            echo $this->session->userdata('inv_inventario_mensaje_contenido'); ?>
                        </div><?php
                        $s_mensaje = array(
                                'inv_inventario_mensaje_tipo'         => '',
                                'inv_inventario_mensaje_contenido'    => ''
                        );
                        $this->session->set_userdata($s_mensaje);
                } ?>
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

                    function ver_reporte(formato){
                        $b_texto            = document.form_busqueda.b_texto.value;
                        if($b_texto.length == 0){           $b_texto = "NULL";          }

                        // $b_estado            = document.form_busqueda.b_estado.value;
                        // if($b_estado.length == 0){           $b_estado = "NULL";          }

                        if(formato == 'pdf'){
                            window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/ver_pdf_lista_toma_inventario/"+$b_texto);
                        }
                        // if(formato == 'excel'){
                        //     window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/ver_excel_lista/"+$b_texto);    
                        // }                            
                    }
                    function replaceAll( text, busca, reemplaza ){
                        while (text.toString().indexOf(busca) != -1)
                            text = text.toString().replace(busca,reemplaza);
                        return text;
                    }
            </script>

            <form class="form-inline" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-md-6">
                        
                        <span>Fecha <span style="color:#F00;"></span></span>
                        <br />
                        <input type="text" class="form-control" id="fecha" disabled name="fecha" value="<?php echo date("d/m/Y") ?>">
                        <span id="error_id_almacen" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                        </span>
                    </div>
                    <div class="col-md-3">
                        
                        <span>Almacén <span style="color:#F00;">*</span></span>
                        <br />
                        <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen" name="id_almacen" data-show-subtext="true" data-live-search="true" onchange="enviar()"><?php
                                            $valorSel  = $_POST['id_almacen'];
                                            ?><option value="null">Seleccione</option><?php
                                            for($j = 0; $j < count($matriz_almacenes); $j++){
                                                $valor_a_mostrar = $matriz_almacenes[$j]->nombre;
                                                $valor = $matriz_almacenes[$j]->id;  ?>
                                                <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                            }?>
                        </select>
                        <span id="error_id_almacen" style="display: none" class="text-danger error-camp">
                                            <i class="fa fa-exclamation-circle fa-2x"></i>
                                            Campo Vacio
                        </span>
                    </div> 
                </div>
                <br> 
                <div class="row">   
                    <div class="col-md-3">
                        <textarea class="form-control" id="observacion" name="observacion"  placeholder="Observacion" cols="80" rows="3"></textarea>
                        <span id="error_capacidad_almacen" style="display: none" class="text-danger error-camp">
                            <i class="fa fa-exclamation-circle fa-2x"></i>
                        Campo Vacio</span> 
                    </div> 
                </div> 
                <div class='col-md-3'>
                    <br>
                    <span class="text-success" data-toggle="tooltip" data-placement="left" title="Ver reporte en formato PDF">
                        <a href="#" onclick="ver_reporte('pdf')" class="btn btn-outline-secondary">
                            <i class="fas fa-file-pdf  text-danger"></i>
                        </a>
                    </span>
                    <!-- <a href="<?php echo site_url('Inv_inventario/agregar'); ?>" class="btn btn-primary">
                        <i class="fa fa-save"></i>Ajustar Inventario</a>  -->
                </div>           
            </div>
                <input class="form-control" type="hidden" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="20" maxlength="20">
            </form>
        

        <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col" class="text-left">Artículo</th>
                            <!-- <th scope="col" class="text-left">Almacén</th> -->
                            <!-- <th scope="col" class="text-center">Capacidad de Almacén</th> -->
                            <th scope="col" class="text-center">Disponible</th>
                            <th scope="col" class="text-center">Unidad Medida</th>
                            <th scope="col">Cantidad Contada</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white"><?php
                    if($dat_list != false){
                            foreach ($dat_list as $dat) {   ?>
                                <tr class="text-center">
                                    <!-- <th scope="row"><?=$dat->id?></th> -->
                                    <td class="text-left"><?=$dat->nombre_articulo?></td>
                                    <!-- <td class="text-left"><?=$dat->nombre_almacen?></td> -->
                                    <!-- <td class="text-center"><?=$dat->capacidad_almacen?></td> -->
                                    <td class="text-center"><?=$dat->disponible?></td>
                                    <td class="text-center"><?=$dat->nombre_medida?></td>
                                    <td class="text-center"><input type="text" class="form-control" id="cantidad_contada"></td>
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