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
                    function enviar(id_almacen) {
                        
                            document.form_busqueda.b_texto.value=document.getElementById("id_almacen").value;
                            document.form_busqueda.submit();
                            document.form_principal.almacen_aux=document.getElementById("id_almacen").value;
                            document.form_principal.fecha.value=document.getElementById("fecha_aux").value;
                     
                            //if ( validarForm() ){	document.form_busqueda.submit();	}
                    }

                    function ver_reporte(formato){
                        $b_texto            = document.form_busqueda.id_almacen.value;
                        let fecha= document.getElementById("fecha_aux").value;
                        

                        if($b_texto.length == 0){           $b_texto = "NULL";          }

                       

                        // $b_estado            = document.form_busqueda.b_estado.value;
                        // if($b_estado.length == 0){           $b_estado = "NULL";          }

                       
                        fecha=String(fecha).replace("/","_");
                        fecha=String(fecha).replace("/","_");

                        
            
                        let str=$b_texto+'_'+fecha;


                        if(formato == 'pdf'){
                            window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/ver_pdf_lista_toma_inventario/"+str);
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

                    setTimeout(() => {    
                if (document.readyState === 'complete') {
                    $('#fecha_aux').datepicker({
                                    format: 'dd/mm/yyyy',
                                    todayHighlight: true,
                                    pick12HourFormat: true,
                                    language: "es"
                                }); 
                }
            }, 100);

            </script>

            <form class="form-inline" action="listar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
            <div class="card-body bg-white">
                <div class="row">
                <td>
                    <div class="col-md-6">
                        <span>Fecha <span style="color:#F00;"></span></span>
                        <br />
                        <input type="text" class="form-control" id="fecha_aux" name="fecha_aux" value="<?php if(isset($_POST['fecha_aux'])){ echo $_POST['fecha_aux']; }else{ echo date("d/m/Y"); } ?>" onchange="enviar(this.value)">
                        <span id="error_id_almacen" style="display: none" class="text-danger error-camp">
                                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                                    Campo Vacio
                        </span>
                    </div>

                    <div class="col-md-3">
                        
                        <span>Almacén <span style="color:#F00;">*</span></span>
                        <br />
                        <select class="form-control bg-sigalsx4-purpple_dark text-white selectpicker" id="id_almacen" name="id_almacen" data-show-subtext="true" data-live-search="true" onchange="enviar(this.value)"><?php
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
                    <div class='col-md-3'>
                    <br>
                    <?php if(isset($_POST['fecha_aux']) && $_POST['fecha_aux']!='') { ?>
                    <span class="text-success" data-toggle="tooltip" data-placement="left" title="Ver reporte en formato PDF">
                        <a href="#" onclick="ver_reporte('pdf')" class="btn btn-outline-secondary">
                            <i class="fas fa-file-pdf  text-danger"></i> Imprimir Listado
                        </a>
                    </span>
                    <?php } ?>
                </div> 
                </div>
                <br> 
                     
            </div>
                <input class="form-control" type="hidden" name="b_texto" id="b_texto" value="<?php echo $b_texto; ?>" placeholder="buscar" onkeypress="return pulsar(event)" size="20" maxlength="20">
           
        </form>

        <!--<?php 
                    // $atributos2 = array(
                    //     'name' => 'form_principal',
                    //     'id' => 'form_principal',
                    //     'onsubmit' => 'return valida(this)',
                    //     'role' => 'form'
                    //     //'enctype' => 'multipart/form-data'
                    // );
                    ?>-->
       <?php //echo form_open('Inv_inventario/guardar_inventario_ajuste', $atributos2); ?>

        <?php
       $atributos2 = array(
                            'name' => 'form_principal',
                            'id' => 'form_principal',
                            'onsubmit' => 'return valida(this)',
                            'role' => 'form'
                            //'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php echo form_open('Inv_inventario/guardar_inventario_ajuste', $atributos2); ?>

        <div class="table-responsive">
                <table class="table table-hover bg-white" style="box-shadow: 1px 5px 5px 1px #d9d9d9">
                    <thead class="bg_color_1 text-white">
                        <tr class="text-center">
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col" class="text-left" colspan="4">Ajustar el Inventario</th>
                        </tr>
                    </thead>
                        <tbody class="bg-white">
                        <tr>
                            <input type='hidden' id="almacen_aux" name="almacen_aux" value="<?php if(isset($_POST['id_almacen'])){ echo $_POST['id_almacen']; }else{ echo ''; } ?>">
                            <td><div class="col-md-6">
                                <span>Fecha <span style="color:#F00;"></span></span>
                                <br />
                                <input type="hidden" class="form-control" id="fecha" readonly name="fecha" value="<?php if(isset($_POST['fecha_aux'])) { echo $_POST['fecha_aux']; } ?>">
                                <span id="error_id_almacen" style="display: none" class="text-danger error-camp">
                                                    <i class="fa fa-exclamation-circle fa-2x"></i>
                                                    Campo Vacio
                                </span>
                            </div>
                            </td>   
                            <td>      
                                <div class="col-md-6">
                                    <textarea class="form-control" id="observacion" name="observacion"  placeholder="Observacion" cols="80" rows="3"></textarea>
                                    <span id="error_capacidad_almacen" style="display: none" class="text-danger error-camp">
                                    <i class="fa fa-exclamation-circle fa-2x"></i>Campo Vacio</span> 
                                </div> 
                            </td> 
                            <?php if(isset($_POST['id_almacen']) && ($_POST['id_almacen']!='null')){ ?>
                            <td><button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>  Ajustar Inventario </button></td>
                            <?php } ?>
                            <td></td>
                        </tr>
                        <tr class="text-center">
                            <!-- <th scope="col">ID</th> -->
                            <th scope="col" class="text-left">Artículo</th>
                            <!-- <th scope="col" class="text-left">Almacén</th> -->
                            <!-- <th scope="col" class="text-center">Capacidad de Almacén</th> -->
                            <th scope="col" class="text-center">Disponible</th>
                            <th scope="col" class="text-center">Unidad Medida</th>
                            <th scope="col">Cantidad Contada</th>
                        </tr>
                        <?php
                        
                        if($dat_list != false){
                                foreach ($dat_list as $dat) {   ?>
                                    <tr class="text-center">
                                        <!-- <th scope="row"><?=$dat->id?></th> -->
                                        <td class="text-left"><?=$dat->nombre_articulo ?></td>
                                        <!-- <td class="text-left"><?=$dat->nombre_almacen?></td> -->
                                        <!-- <td class="text-center"><?=$dat->capacidad_almacen?></td> -->
                                        <td class="text-center"><?=$dat->disponible?></td>
                                        <td class="text-center"><?=$dat->nombre_medida?></td>
                                        <td class="text-center">
                                            <input type="number" class="form-control" style="text-align:right;" id="<?php echo "ajuste_".$dat->id_articulo; ?>" name="<?php echo "ajuste_".$dat->id_articulo; ?>" value="<?php  echo $dat->monto_ajuste; ?>">
                                            <input type="hidden" class="form-control" id="<?php echo "disponible_".$dat->id_articulo; ?>" name="<?php echo "disponible_".$dat->id_articulo; ?>" value="<?php echo $dat->disponible; ?>">
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
                        <?php echo form_close(); ?>
                        </tbody>
                </table>                
            </div>
        </div>
    </div>
                

    <!-- <div class="row">
        <div class="col-md-5 float-left">
            <ul class="pagination"><?php
                echo $this->pagination->create_links(); ?>
            </ul>            
        </div>
        <div class="col-md-3 float-left">
            <label class="estilo_para_paginacion"><?php echo $pag_desde; ?> - <?php echo $pag_hasta; ?> de <?php echo $pag_totales; ?></label>
        </div>
    </div> -->
    
    <?php /*
    <a href="<?=site_url('Menues/menu_administrar_pensum')?>" id="btn_float" class="button button-circle button-flat-primary bg-sigalsx4-purpple">
        <i class="fas fa-arrow-circle-left fa-5x"></i>
    </a>*/ ?>

</div>