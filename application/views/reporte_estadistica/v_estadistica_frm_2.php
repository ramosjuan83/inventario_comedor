<div class="container-fluid">

    <div class="row">
        <div class="container mb-4 mt-4">

            <div class="card card-login mx-auto bg-white border-0 card-shadow" style="margin-top: 10px; max-width: 50rem">
                <!--<div class="row">-->
                    <div class="card-header bg_color_2">
                        <h4>
                            <!--span class="text-white">Registrar Usuarios</span-->
                            <i class="text-white fa fa-file-pdf fa-2x"></i>
                            <?php
                            switch ($oper){
                                case 'reporte_form': ?>
                                        <span class="text-white">Reporte Estadística Semanal</span><?php
                                        //$oper_g = "agregar_guardar";
                                break;
                            } ?>
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        <script languaje="javascript">
                            function cambio_almacen(){
                                console.log("Ingresa en exchange de almacen");
                            }

                            function valida(){
                                    ok = true;
                                    // var soloNumero= /^([0-9])+$/

                                    // /*VALIDA QUE CEDULA SEA SOLO NUMERO*/
                                    // $("#cedula").removeClass("border-danger");
                                    // $('#error_cedula').css('display', 'none');
                                    // if(document.getElementById("cedula").value.length < 1){
                                    // }else{
                                    //     if(soloNumero.test(document.getElementById("cedula").value) ) {
                                    //     }else{
                                    //         $("#cedula").addClass("border-danger");
                                    //         $('#error_cedula').css('display', 'block');
                                    //         ok = false;
                                    //     }

                                    // };   
                                    
                                    // if(document.getElementById("b_fecha_desde").value.length < 1 || document.getElementById("b_fecha_hasta").value.length < 1)
                                    // {
                                    //     $("#b_fecha_desde").addClass("border-danger");
                                    //     $("#b_fecha_hasta").addClass("border-danger");
                                    //     $('#error_b_fecha_desde_hasta').css('display', 'block');
                                    //     ok = false;
                                    // }else{
                                    //     $("#b_fecha_desde").removeClass("border-danger");
                                    //     $("#b_fecha_hasta").removeClass("border-danger");
                                    //     $('#error_b_fecha_desde_hasta').css('display', 'none');
                                    // };                                    
                                    return ok;
                            }
                        </script>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger text-center alert-error-campo" style="display: none">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    Verificar los siguientes campos...!!!
                                </div>
                            </div>
                        </div>
                        <?php
                        $atributos2 = array(
                            'name' => 'form_principal',
                            'id' => 'form_principal',
                            'onsubmit' => 'return valida(this)',
                            'role' => 'form'
                            //'enctype' => 'multipart/form-data'
                        );
                        ?>
                        <?php 
                        $oper_g = "";
                        echo form_open('Personal/'.$oper_g, $atributos2);

                        if($oper == 'editar'){ ?>
                            <input type="hidden" id="id" name="id" value="<?php if( isset($fila_personal->id) ){ echo $fila_personal->id; } ?>" ><?php
                        } ?>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 text-left">
                                    <label>Artículo </label>
                                    <select class="form-control bg_color_3 text-white" id="id_articulo" name="id_articulo"><?php
                                        $valorSel  = "";
                                        ?><option value="null">Seleccione</option><?php
                                        for($j = 0; $j < count($matriz_articulos); $j++){
                                            $valor_a_mostrar = $matriz_articulos[$j]->nombre;
                                            $valor = $matriz_articulos[$j]->id;  ?>
                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                        }?>
                                    </select>   
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 text-left">
                                    <label>Almacén </label>
                                    <select class="form-control bg_color_3 text-white" id="id_almacen" name="id_almacen" onchange="cambio_almacen()"> <?php
                                        $valorSel  = "";
                                        ?><option value="null">Seleccione</option><?php
                                        for($j = 0; $j < count($matriz_almacenes); $j++){
                                            $valor_a_mostrar = $matriz_almacenes[$j]->nombre;
                                            $valor = $matriz_almacenes[$j]->id;  ?>
                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                        }?>
                                    </select>  
                            </div>
                            <!-- <div class="col-md-6 text-left">
                                    <label>ESTADO TEMPORAL </label>
                                    <select class="form-control bg_color_3 text-white" id="estados_id" name="estados_id"><?php
                                        $valorSel  = "";
                                        ?><option value="null">Todos</option><?php
                                        for($j = 0; $j < count($matriz_estados); $j++){
                                            $valor_a_mostrar = $matriz_estados[$j]->nombre;
                                            $valor = $matriz_estados[$j]->id;  ?>
                                            <option value="<?php echo $valor; ?>" <?php if($valor == $valorSel){echo "selected";} ?>><?php echo $valor_a_mostrar; ?></option><?php
                                        }?>
                                    </select>  
                            </div> -->
                        </div>
                        


                        <div class="row mt-4">
                            <div class="col-md-6 float-left">

                                <script type="text/javascript"> 	                                        
                                    
                                    // document.getElementById("id_personal_visitante_tipo").value = "null";
                                    // document.getElementById("id_personal_visitante_tipo").disabled = true;
                                    // function habilita_tipo_de_personal() {
                                    //     tipo_personal = document.getElementById("tipo_personal").value;
                                        
                                    //     if(tipo_personal == 2){
                                    //         document.getElementById("id_personal_visitante_tipo").disabled = false;
                                    //     }else{
                                    //         document.getElementById("id_personal_visitante_tipo").value = "null";
                                    //         document.getElementById("id_personal_visitante_tipo").disabled = true;
                                    //     }
                                        
                                    // }
                                    
                                    
                                    function ver_reporte(formato){
                                        if(valida() == true){
                                        


                                            // $b_fecha_desde            = document.form_principal.b_fecha_desde.value;
                                            // if($b_fecha_desde.length == 0){           $b_fecha_desde = "NULL";          }
                                            // else{ $b_fecha_desde = replaceAll($b_fecha_desde, "/", "-" ); }

                                            // $b_fecha_hasta            = document.form_principal.b_fecha_hasta.value;
                                            // if($b_fecha_hasta.length == 0){           $b_fecha_hasta = "NULL";          }
                                            // else{ $b_fecha_hasta = replaceAll($b_fecha_hasta, "/", "-" ); }

                                            // $cedula            = document.form_principal.cedula.value;
                                            // if($cedula.length == 0){           $cedula = "NULL";          }

                                            // $tipo_personal            = document.form_principal.tipo_personal.value;
                                            // if($tipo_personal.length == 0){           $tipo_personal = "NULL";          }

                                            // $id_personal_visitante_tipo            = document.form_principal.id_personal_visitante_tipo.value;
                                            // if($id_personal_visitante_tipo.length == 0){           $id_personal_visitante_tipo = "NULL";          }

                                            // $estados_id            = document.form_principal.estados_id.value;
                                            // if($estados_id.length == 0){           $estados_id = "NULL";          }
                                            

                                            // $id_comedor_comida_tipo            = document.form_principal.id_comedor_comida_tipo.value;
                                            // if($id_comedor_comida_tipo.length == 0){           $id_comedor_comida_tipo = "NULL";          }

                                            let id_articulo            = document.form_principal.id_articulo.value;
                                            let id_almacen            = document.form_principal.id_almacen.value;
                                        
                                            if(formato == 'pdf'){
                                                window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/llama_reporte_form/"+id_articulo+"/"+id_almacen+"/"+"/pdf");
                                            }
                                            if(formato == 'excel'){
                                                window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/llama_reporte_form/"+id_articulo+"/"+id_almacen+"/"+"/excel");
                                                //window.open("<?php echo ''.base_url('').''?>index.php/Inv_inventario/llama_reporte_form/"+$b_fecha_desde+"/"+$b_fecha_hasta+"/"+$cedula+"/"+$tipo_personal+"/"+$id_comedor_comida_tipo+"/"+$id_personal_visitante_tipo+"/"+$estados_id+"/excel");
                                            }                                        
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
                        
                        <?php echo form_close(); ?>
                    </div>

                </div>

            <!--</div>-->
        </div>
    </div>
</div>