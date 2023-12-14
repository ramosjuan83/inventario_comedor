
        <?php //PARA bootstrap  ?>
        <script src="<?php echo '' .base_url('/librerias/jquery').''?>/jquery.min.js"></script><?php //mascaras ?>
        <script src="<?php echo '' .base_url('/librerias/bootstrap-4.1.3-dist/otros_archivos_2').''?>/popper.min.js"></script>
        <script src="<?php echo '' .base_url('/librerias/bootstrap-4.1.3-dist/js').''?>/bootstrap.js"></script> <?php //se utiliza en el funcionamiento del boton cerrar session ?>
        
        <?php //PARA Los select inteligentes  ?>
        <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->
        <!--script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script-->
        <script src="<?php echo '' .base_url('/librerias/bootstrap-select').''?>/bootstrap-select.min.js"></script>        
        
        <?php /* PARA QUE SE VEAN LOS TOLTIPS */ ?>
        <script src="<?php echo '' .base_url('/librerias/jquery').''?>/jquery.easing.min.js"></script>
        <?php /* */ ?>
        <script type="text/javascript">
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })          
        </script>    <?php /* */ ?>          
        
        
        
        <?php  //mascaras ?>
        <script src="<?php echo '' .base_url('/librerias/jquery').''?>/jquery.mask.js"></script>
        <?php  /* ?><script src="<?php echo '' .base_url('/js').''?>/jquery.easing.min.js"></script><?php /**///no se sabe para que  ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.ci_campo').mask('V-99999999', {placeholder: 'Ejemplo: V-12345678'});
                $('.ci_campo_2').mask('99.999.999', {placeholder: 'Ejemplo: 12.345.678'});
                $('.rif_campo').mask('J-99999999-9', {placeholder: 'Ejemplo: J-12345678-9'});
                $('.rif_campo_2').mask('99999999-9', {placeholder: 'Ejemplo: 12345678-9'});
                $('.tlf').mask('(9999) 9999999');
                $('.fecha_fact').mask('9999-99-99');
                $('.fecha').mask('99/99/9999');
                $('.hora').mask('99:99:99');
                $('.decimal').mask('999999999999999999999999999999999.99');
                $('.decimal_sep').mask('999999999999999999999999999999999.99');
                $('.decimal_total').mask('999999999999999999999999999999999.99');
                $('.decimal_total_sep').mask('999999999999999999999999999999999.99');
                
                $('.double_d_10_2').mask('9999999999.99'); //Double 10.2
            });
        </script>
        <script>
            $(document).ready(function (){
              $('.solo-numero').keyup(function (){
                this.value = (this.value + '').replace(/[^0-9]/g, '');
              });
              //Numeros y guion
              $('.solo-numero_2').keyup(function (){
                this.value = (this.value + '').replace(/[^0-9|-]/g, '');
              });
              //Numeros y punto
              $('.solo-numero_3').keyup(function (){
                this.value = (this.value + '').replace(/[^0-9|.]/g, '');
              });
              $('.solo-texto').keyup(function (){
                this.value = (this.value + '').replace(/[^([a-z]|[A-Z]|á|é|í|ó|ú|ñ|ü|\s|\.]/g, '');
              });              
              //var Txt1 = /^([a-z]|[A-Z]|á|é|í|ó|ú|ñ|ü|\s|\.)+$/
              
            });
        </script>        
        
        <!-- para datepicker -->
        <script src="<?php echo '' .base_url('/librerias/bootstrap-datepicker/js').''?>/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo '' .base_url('/librerias/bootstrap-datepicker/locales').''?>/bootstrap-datepicker.es.min.js"></script><?php /**/ ?>
        <script type="text/javascript">
            $('#fecha_de_nacimiento').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            });
            $('#fecha').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            }); 
            $('#fecha_vencimiento').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            });             
            $('#fecha_de_pago').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            });
            $('#fecha_desde').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            });
            $('#fecha_hasta').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                pick12HourFormat: true,
                language: "es"
            });

            /*PARA DATEPICKER DESDE Y HASTA*/
            $('#datepicker-example').datepicker({
                format: 'dd/mm/yyyy'
                , language: "es"
            });     
        </script>