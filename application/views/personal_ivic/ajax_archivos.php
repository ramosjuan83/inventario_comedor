<script type="text/javascript">
        //mostrarArchivos();
        function mostrarArchivos(){

            id = document.getElementById("id").value;
            var baseurl = "<?php echo base_url(); ?>";
            $.post(baseurl+"index.php/Personal_visitante/get_personal_visitante_buscar_2",
            {
                id: id
            },
            function(data){ //alert(data);
                var matriz_personal_visitante = JSON.parse(data);
                imagen_nombre = matriz_personal_visitante[0]['imagen_nombre']
                if(imagen_nombre == null){
                    $("#archivos_subidos").html("");
                }else{
                    $("#archivos_subidos").html("");
                    $ruta = '<?php echo base_url("images/personal_visitante/"); ?>'+imagen_nombre;
                    $("#archivos_subidos").append("<img src='"+$ruta+"'  width='200' height='200'>");

                    decisiones_archivos_id = 1;

                    $("#archivos_subidos").append("\
                        <li class='list-group-item'>\
                            <a class='text-danger mr-2' href='#' data-toggle='modal' data-target='#exampleModal_eliminar_"+id+"'>\
                                <span class='badge badge-danger badge-pill' data-toggle='tooltip' data-placement='left' title='Eliminar'><i class='fas fa-times'></i></span>\
                            </a>\
                        </li>\
                        <div class='modal fade' id='exampleModal_eliminar_"+id+"' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>\
                          <div class='modal-dialog' role='document'>\
                            <div class='modal-content'>\
                              <div class='modal-header'>\
                                <h5 class='modal-title' id='exampleModalLabel'>&iquest;Desea eliminar la imagen?</h5>\
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>\
                                  <span aria-hidden='true'>&times;</span>\
                                </button>\
                              </div>\
                              <div class='modal-body'>\
                              </div>\
                              <div class='modal-footer'>\
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>\
                                    <a href='#' onclick='eliminar_conf_usuarios_imagen_nombre("+id+")'>\
                                        <button type='button' class='btn btn-primary'>Aceptar</button>\
                                    </a>\
                              </div>\
                            </div>\
                          </div>\
                        </div>\
                    ");                    
                }
            });
        }    
        
        function eliminar_conf_usuarios_imagen_nombre(id_usuario){
            CierraPopup(id_usuario);
            id_usuario = document.getElementById("id_usuario").value;
            var baseurl = "<?php echo base_url(); ?>";
            $.post(baseurl+"index.php/Conf_usuarios/get_eliminar_archivo",
            {
                id_usuario: id_usuario
            },
            function(data){ //alert(data);
                    if (data == 1){
                        mostrarArchivos();
                        mostrarRespuesta('El archivo ha sido eliminado correctamente.', true);
                    } else {
                        mostrarRespuesta('El archivo NO se ha podido eliminar.', false);
                    }                
                    
            });
            //document.getElementById("decisiones_archivos_id_a_eliminar").value = decisiones_archivos_id_a_eliminar;
            //archivos_cargar();
            //mostrarArchivos();
        }
        function CierraPopup(id_usuario){
            $('#exampleModal_eliminar_'+id_usuario).modal('hide');//ocultamos el modal
            $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
            $('.modal-backdrop').remove();//eliminamos el backdrop del modal
        }        
</script>