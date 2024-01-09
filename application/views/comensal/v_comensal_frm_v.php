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
                    <i class="color_7 fas fa-user-check fa-2x"></i>
                    <span class="color_7">Administrar Comensal</span>
                </h4>
            </div>
            <div class="col-md-6 float-left text-right container-fluid mt-2">
                <?php

                if( strlen($this->session->userdata('comensal_mensaje_tipo')) > 0  ){ ?>
                        <div class="alert <?php echo $this->session->userdata('comensal_mensaje_tipo'); ?> text-center"><?php
                            echo $this->session->userdata('comensal_mensaje_contenido'); ?>
                        </div><?php
                        $s_mensaje = array(
                                'comensal_mensaje_tipo'         => '',
                                'comensal_mensaje_contenido'    => ''
                        );
                        $this->session->set_userdata($s_mensaje);
                } ?>
            </div>
            <div class="col-md-2 float-left text-right estilo1 container-fluid mt-2">
            </div>
        </div>
    </div>

    <div class="row2">
        <div class="container-fluid22 mt-1">

            <script language="javascript">
                    function valida(){
                            ok = true;
                            var soloNumero= /^([0-9])+$/
                            
                            /*VALIDA QUE CEDULA SEA SOLO NUMERO*/
                            $("#cedula").removeClass("border-danger");
                            $('#error_cedula').css('display', 'none');
                            if(document.getElementById("cedula").value.length < 1){
                            }else{
                                if(soloNumero.test(document.getElementById("cedula").value) ) {
                                }else{
                                    $("#cedula").addClass("border-danger");
                                    $('#error_cedula').css('display', 'block');
                                    ok = false;
                                }
                                
                            };   
                            
                            /*VALIDA QUE CARNET SEA SOLO NUMERO*/
                            $("#carnet").removeClass("border-danger");
                            $('#error_carnet').css('display', 'none');
                            if(document.getElementById("carnet").value.length < 1){
                            }else{
                                if(soloNumero.test(document.getElementById("carnet").value) ) {
                                }else{
                                    $("#carnet").addClass("border-danger");
                                    $('#error_carnet').css('display', 'block');
                                    ok = false;
                                }
                                
                            };                               
                            
                            return ok;
                    }
                    function pulsar(e) { 
                            tecla = (document.all) ? e.keyCode :e.which; 
                            if (tecla==13){enviar();}
                            return (tecla!=13); 
                    }   
                    function chequearSoloNumero(k) {//solo numeros como la cedula
                            if(k.value.length|=0){//para cuando el campo este vacio no valide
                                    var soloNumero= /^([0-9])+$/
                                    if(!soloNumero.test(k.value) ) {			
                                            //alert("Lo siento "+k.id+" debe ser solo numeros, compruebe que no tenga puntos, espacios o letras");
                                            //k.focus();	
                                            return false;
                                    } else {return true;}
                            }return true;
                    }                    
                    /*
                    function reajustar() {
                            document.form_busqueda.b_texto.value     = "";
                            document.form_busqueda.b_id_periodo.value     = "";
                            document.form_busqueda.b_id_cohorte.value     = "";
                            document.form_busqueda.b_estatus.value     = "NULL";
                            document.form_busqueda.area_de_interes_id.value     = "NULL";
                            document.form_busqueda.linea_de_investigacion_id.value     = "NULL";
                            enviar();
                    } */
                    function enviar() {
                            if(valida() == true){
                                document.form_busqueda.submit();    
                            }
                    }
            </script>

            <div class="container-fluid">
                <div class="row mb-0">
                    <!--div class="col-md-6 mb-2 mt-2">
                        <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-filter"></i>
                            Filtrar por:
                        </a>
                    </div-->
                    <div class="col-md-6 mb-2 mt-2 text-right">
                        <script type="text/javascript">
                            /*
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
                            }     */                       
                        </script>
                        
                        <?php /*
                        <a href="#" onclick="ver_reporte()" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf  text-danger"></i>
                            ver reporte
                        </a>*/ ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <!--div class="collapse22" id="collapseExample22"-->
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-6 text-left">

                                        <form class="form-inline" action="agregar" name="form_busqueda" id="form_busqueda" target="_self" enctype="multipart/form-data" method="POST">
                                            <label for="cedula">C&Eacute;DULA</label>
                                            <input class="form-control" id="cedula" name="cedula" type="text" placeholder="C&eacute;dula" value="" size="10" maxlength="10" onkeypress="return pulsar(event)">

                                            <label for="carnet">CARNET</label>

                                            <?php
                                            $autofocus = true;
                                            if(isset($matriz_personal_ivic)){
                                                if($matriz_personal_ivic != false){ 
                                                    $autofocus = false;
                                                }   
                                            }
                                            if(isset($matriz_personal_visitante)){
                                                if($matriz_personal_visitante != false){ 
                                                    $autofocus = false;
                                                }   
                                            }                                            
                                            ?>
                                            
                                            <input class="form-control" id="carnet" name="carnet" type="text" placeholder="Carnet" value="" size="6" maxlength="6" onkeypress="return pulsar(event)" <?php if($autofocus == true){ ?> autofocus=""  <?php }?> >

                                            <button type="button" class="btn btn-secondary" onclick="enviar()">Buscar</button>

                                            <span id="error_cedula" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i>
                                                El valor del campo debe ser sólo Número
                                            </span>                                              
                                            <span id="error_carnet" style="display: none" class="text-danger error-camp">
                                                <i class="fa fa-exclamation-circle fa-2x"></i>
                                                El valor del campo debe ser sólo Número
                                            </span>                                            
                                        </form>
                                </div>
                                <div class="col-md-6 text-left">
                                        <?php
                                            if($hora_fuera_de_horario == false){ ?>
                                                <div class="alert alert-secondary">
                                                    <span class="badge badge-primary">COMENSALES</span>
                                                    <span class='badge badge-pill badge-info'><?php echo $fecha_con_formato; ?></span>
                                                    <span class="badge badge-pill badge-secondary"><?php echo strtoupper($nombre_comedor_comida_tipo); ?></span>


                                                    <span class="badge badge-pill badge-info"><?php echo "IVIC: ".$num_personal_ivic; ?></span>

                                                    <span class="badge badge-pill badge-info"><?php echo "EXTERNO: ".$num_personal_visitante; ?></span>

                                                    <span class="badge badge-pill badge-info"><?php echo "TOTAL: ".$num_personal_total; ?></span>                                            
                                                </div>
                                                <?php
                                            }
                                            ?>
                                </div>
                            </div>
                        </div>
                    <!--/div-->
                </div>
                <?php /*
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">Basic card</div>
                    </div>
                </div>*/ ?>
            </div>            
            

                <div class="row mb-2 mt-2">
                    <div class="col-md-6">
                        <?php 
                        //echo "matriz_personal_ivic *<pre>"; print_r($matriz_personal_ivic); echo "</pre>*";
                        //[0] => stdClass Object
                        //    (
                        //        [id] => 2
                        //        [cedula] => 10850201
                        //        [nombres] => Escarlet Ruiz
                        //        [apellidos] => Bracho pineda
                        //        [id_cargo] => 2
                        //        [id_gerencia] => 3
                        //        [estado] => 1
                        //        [imagen_nombre] => 
                        //        [carnet_codigo] => 10008
                        //        [cargos_nombre] => Analista II
                        //        [gerencia_nombre] => Contabilidad
                        //        [estado_nombre] => Activo
                        //        [puede_registrar] => 1
                        //        [mensaje_de_porque_no_registra] => 
                        //    )                        
                        $tiene_ficha = false;
                        if(isset($matriz_personal_ivic)){
                            if($matriz_personal_ivic != false){ 
                                $tiene_ficha = true;
                                for($i = 0; $i < count($matriz_personal_ivic); $i++){ ?>
                                    <!--div class="col-md-6"-->
                                        <div class="card card-body">
                                            <div class="row">
                                                <div class="col-md-6 container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>C&eacute;dula</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo $matriz_personal_ivic[$i]->cedula;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Carnet</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo $matriz_personal_ivic[$i]->carnet_codigo;
                                                                ?>
                                                            </div>
                                                        </div>                                                


                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Nombres</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo $matriz_personal_ivic[$i]->nombres;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Apellidos</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo $matriz_personal_ivic[$i]->apellidos;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if(isset($matriz_personal_ivic[$i]->cargos_nombre)){ ?>
                                                            <div class="row">
                                                                <div class="col-md-4 container-fluid">
                                                                    <label>Cargo</label>
                                                                </div>
                                                                <div class="col-md-8 container-fluid font-weight-bold">
                                                                    <?php
                                                                    echo $matriz_personal_ivic[$i]->cargos_nombre;
                                                                    ?>
                                                                </div>
                                                            </div>                                                 
                                                            <?php
                                                        } ?>
                                                        <?php
                                                        if(isset($matriz_personal_ivic[$i]->gerencia_nombre)){ ?>
                                                            <div class="row">
                                                                <div class="col-md-4 container-fluid">
                                                                    <label>Gerencia</label>
                                                                </div>
                                                                <div class="col-md-8 container-fluid font-weight-bold">
                                                                    <?php
                                                                    echo $matriz_personal_ivic[$i]->gerencia_nombre;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } ?>

                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Personal</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                IVIC
                                                            </div>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Estado</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo strtoupper($matriz_personal_ivic[$i]->estado_nombre);
                                                                ?>
                                                            </div>
                                                        </div>                                                

                                                </div>
                                                <div class="col-md-6 container-fluid text-right">
                                                        <?php 
                                                        //echo "matriz_personal_2<pre>"; print_r($matriz_personal_2); echo "*</pre>";
                                                        //echo "matriz_personal_ivic[i]->imagen_nombre *".$matriz_personal_ivic[$i]->imagen_nombre."*";
                                                        if( $matriz_personal_ivic[$i]->imagen_nombre == "" ){ 
                                                            $ruta = base_url("images/personal_ivic/")."sin_imagen.png";
                                                        }else{ 
                                                            $ruta = base_url("images/personal_ivic/").$matriz_personal_ivic[$i]->imagen_nombre;                                     
                                                        } ?>
                                                        <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px" class="img-thumbnail">  
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 container-fluid text-right">
                                                    <?php
                                                    //echo "matriz_personal_ivic<pre>"; print_r($matriz_personal_ivic); echo "*</pre>";
                                                    if($matriz_personal_ivic[$i]->puede_registrar == true){ ?>
                                                        <form action="agregar_guardar" name="form_1" id="form_1" target="_self" enctype="multipart/form-data" method="POST">
                                                                <?php
                                                                $id_personal_ivic       = "";
                                                                $id_personal_visitante  = "";
                                                                $id_personal_ivic       = $matriz_personal_ivic[$i]->id;
                                                                ?>
                                                                <input type="hidden" id="id_personal_ivic" name="id_personal_ivic" value="<?php echo $id_personal_ivic; ?>">
                                                                <input type="hidden" id="id_personal_visitante" name="id_personal_visitante" value="<?php echo $id_personal_visitante; ?>">
                                                                <button type="submit" class="btn btn-secondary" autofocus>Registrar</button>
                                                        </form><?php
                                                    }else{ ?>
                                                        <div class="alert alert-danger" role="alert">
                                                          <?php echo $matriz_personal_ivic[$i]->mensaje_de_porque_no_registra; ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>                                        

                                        </div>
                                    <!--/div-->    
                                    <?php                                
                                }
                            }
                        }
                        
                        //echo "matriz_personal_visitante *<pre>"; print_r($matriz_personal_visitante); echo "</pre>*";
                        //[0] => stdClass Object
                        //    (
                        //        [id] => 1
                        //        [cedula] => 10850211
                        //        [nombres] => Laura Juanita
                        //        [apellidos] => Perez Gonzales
                        //        [imagen_nombre] => 
                        //        [estado] => 1
                        //        [estado_nombre] => Activo
                        //        [puede_registrar] => 1
                        //        [mensaje_de_porque_no_registra] => 
                        //    )
                        if(isset($matriz_personal_visitante)){
                            if($matriz_personal_visitante != false){ 
                                $tiene_ficha = true;
                                for($i = 0; $i < count($matriz_personal_visitante); $i++){ ?>
                                    <!--div class="col-md-6"-->
                                        <div class="card card-body">
                                            <div class="row">
                                                <div class="col-md-6 container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>C&eacute;dula</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo $matriz_personal_visitante[$i]->cedula;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Nombres</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo strtoupper($matriz_personal_visitante[$i]->nombres);
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Apellidos</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo strtoupper($matriz_personal_visitante[$i]->apellidos);
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Personal</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                EXTERNO
                                                            </div>
                                                        </div>  
                                                    
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Tipo</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo strtoupper($matriz_personal_visitante[$i]->tipo_nombre);
                                                                ?>
                                                            </div>
                                                        </div>                                                     
                                                    
                                                        <div class="row">
                                                            <div class="col-md-4 container-fluid">
                                                                <label>Estado</label>
                                                            </div>
                                                            <div class="col-md-8 container-fluid font-weight-bold">
                                                                <?php
                                                                echo strtoupper($matriz_personal_visitante[$i]->estado_nombre);
                                                                ?>
                                                            </div>
                                                        </div>                                                

                                                </div>
                                                <div class="col-md-6 container-fluid text-right">
                                                        <?php 
                                                        //echo "matriz_personal_2<pre>"; print_r($matriz_personal_2); echo "*</pre>";
                                                        $ruta = base_url("images/personal_visitante/")."sin_imagen.png";
                                                        ?>
                                                        <img src="<?php echo $ruta; ?>"  width="150" height="150" border="2px">  
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 container-fluid text-right">
                                                    <?php
                                                    //echo "matriz_personal_ivic<pre>"; print_r($matriz_personal_visitante); echo "*</pre>";
                                                    if($matriz_personal_visitante[$i]->puede_registrar == true){ ?>
                                                        <form action="agregar_guardar" name="form_1" id="form_1" target="_self" enctype="multipart/form-data" method="POST">
                                                                <?php
                                                                $id_personal_ivic       = "";
                                                                $id_personal_visitante  = $matriz_personal_visitante[$i]->id;
                                                                $id_personal_ivic       = "";
                                                                ?>
                                                                <input type="hidden" id="id_personal_ivic" name="id_personal_ivic" value="<?php echo $id_personal_ivic; ?>">
                                                                <input type="hidden" id="id_personal_visitante" name="id_personal_visitante" value="<?php echo $id_personal_visitante; ?>">
                                                                <button type="submit" class="btn btn-secondary" autofocus>Registrar</button>
                                                        </form><?php
                                                    }else{ ?>
                                                        <div class="alert alert-danger" role="alert">
                                                          <?php echo $matriz_personal_visitante[$i]->mensaje_de_porque_no_registra; ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>                                        

                                        </div>
                                    <!--/div-->    
                                    <?php                                
                                }
                            }
                        }

                        //echo "tiene_ficha *".$tiene_ficha."*";
                        
                        $mensaje_mostrado = false;
                        
                        if($tiene_ficha == true){}
                        else{
                                ?>
                                    
                                        
                                        <?php
                                        if($hora_fuera_de_horario == true){ ?>
                                            <div class="card card-body">
                                                <div class="jumbotron">
                                                  <h1>Horario de comida esta fuera de hora</h1>
                                                  <p>No puede registrar en este momento</p>
                                                </div>
                                            </div><?php   
                                            $mensaje_mostrado = true;
                                        }
                                        ?>

                                        
                                        <?php

                                        if($busquedad_no_encontrada == true){ ?>
                                            <div class="card card-body">
                                                <div class="jumbotron">
                                                    <div class="alert alert-warning" role="alert">
                                                            No se han encontrado Resultados, con los filtros seleccionados
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $mensaje_mostrado = true;
                                        }
                                        
                                        if($mensaje_mostrado == false){ ?>
                                                <div class="card card-body">
                                                    <div class="jumbotron">
                                                        <h3>Seleccione</h3>
                                                    </div>
                                                </div><?php 
                                        }                                        
                        } ?>

                        
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <?php /*
                            <label>ÚLTIMOS COMENSALES</label> */ ?>
                            <ul class="list-group">
                            <?php //echo "matriz_comensales *<pre>"; print_r($matriz_comensales); echo "</pre>*";
                            if(isset($matriz_comensales) == true){
                                if($matriz_comensales != false){ //font-weight-bold
                                    for($i = 0; $i < count($matriz_comensales); $i++){ 
                                            $texto = " <span class='badge badge-pill badge-info'>".$matriz_comensales[$i]->fecha_con_formato." ".$matriz_comensales[$i]->hora."</span>";
                                            $comida_tipo = strtoupper($matriz_comensales[$i]->comida_tipo);
                                            $texto .= " <span class='badge badge-pill badge-secondary'>".$comida_tipo."</span>";
                                            $texto .= " <span class='badge badge-pill badge-secondary'>CI:".$matriz_comensales[$i]->cedula."</span>";
                                            
                                            if(isset($matriz_comensales[$i]->carnet_codigo)){
                                                $texto .= " <span class='badge badge-success'>CARNET:".$matriz_comensales[$i]->carnet_codigo."</span>";    
                                            }
                                            
                                            $personal = strtoupper($matriz_comensales[$i]->nombres." ".$matriz_comensales[$i]->apellidos);
                                            $texto .= " <span class='badge badge-secondary'>".$personal."</span>";
                                            ?>
                                            <li class="list-group-item"><?php echo $texto; ?></li>
                                        <?php
                                    }
                                }else{ 
                                    if($hora_fuera_de_horario == false){
                                            ?>
                                            <p>NO HAY COMENSALES PARA <strong><?php echo strtoupper($nombre_comedor_comida_tipo); ?></strong> EN ESTE MOMENTO </p>
                                            <?php
                                    }
                                }
                            }
                            ?>
                            </ul>
                        </div>
                    </div> 
                    
                </div>


        </div>
    </div>
   
    
    
</div>
