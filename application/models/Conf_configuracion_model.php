<?php
class Conf_configuracion_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    /*
    //conf_configuracion
    //    id
    //    orden
    //    opcion
    //    valor
    //    valores_posibles
    //    detalles
    public function conf_configuracion_buscar_2(){
            $sql = "SELECT * FROM conf_configuracion ORDER BY orden ASC";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                $matriz_conf_configuracion = $resultado->result();
                unset($matriz_conf_configuracion_final); //$x = 0;
                //echo "matriz_conf_configuracion <pre>*"; print_r($matriz_conf_configuracion); echo "</pre>*";
                for($i = 0; $i < count($matriz_conf_configuracion); $i++) {
                    $opcion = $matriz_conf_configuracion[$i]->opcion;
                    $valor  = $matriz_conf_configuracion[$i]->valor;
                    $matriz_conf_configuracion_final[$opcion] = $valor;
                }
                //echo "matriz_conf_configuracion_final <pre>*"; print_r($matriz_conf_configuracion_final); echo "</pre>*";
                return $matriz_conf_configuracion_final;
            }else{
                return false;
            }        
    }
    
    //conf_configuracion
    //    id
    //    orden
    //    opcion
    //    valor
    //    valores_posibles
    //    detalles
    public function conf_configuracion_buscar_3($id){
            $sql = "SELECT * FROM conf_configuracion
                    WHERE id = '".$id."'";
            $resultado = $this->db->query($sql);
            if( $resultado->num_rows() > 0 ){
                return $resultado->result();
            }else{
                return false;
            }
    }    

    //conf_configuracion
    //    id
    //    orden
    //    opcion
    //    valor
    //    valores_posibles
    //    detalles    
    public function conf_configuracion_editar($id, $valor){
            $sql = "
                    UPDATE conf_configuracion SET
                          valor   =   '".$valor."'
                    WHERE id = '".$id."'
            ";      //echo "<br />sql *".$sql."*";
            $resultado = $this->db->query($sql);
            return $resultado;
    }    
    */
    
    
    
    
    
    
    
    
    
    
    
    
    
    //FUNCION OBSOLETA reemplazada por conf_configuracion_buscar_2
    /*
    public function conf_configuracion_buscar(){
            unset($matris_configuracion);
            $i = 0;

            //Configuracion de Escala de calificacion a utilizar, valores
                //  1: Del 0 al 20
                //  2: Del 0 al 5
                @$matris_configuracion[$i]->escala_de_calificacion = 2;
                $matris_configuracion[$i]->escala_not_max  = "5";
                $matris_configuracion[$i]->escala_not_min  = "0";
                $matris_configuracion[$i]->escala_not_aprobacion  = "4";
            //Fin de Configuracion de Escala de calificacion

//                //CONFIGURACION DE OSCAR
//                @$matris_configuracion[$i]->escala_de_calificacion = 1;
//                $matris_configuracion[$i]->escala_not_max  = "20";
//                $matris_configuracion[$i]->escala_not_min  = "0";
//                $matris_configuracion[$i]->escala_not_aprobacion  = "10";
                
            //ESTA AREA ES INTERNO DEL SISTEMA SE TRABAJARA EN BASE A 20.00
                $matris_configuracion[$i]->not_max          = 20;        //Este valor no se cambia
                $matris_configuracion[$i]->not_min          = 0;         //Este valor no se cambia
                $matris_configuracion[$i]->not_aprobacion   = "16";      //Minimo de punto para pasar una materia ejemplo: 10
            //FIN DE ESTA AREA ES INTERNO DEL SISTEMA SE TRABAJARA EN BASE A 20.00
            
            //______________________________________________________________________________________________________________________________________
            //Inscripcion ---------------------------------------------------------------------------------------------------------------------------    
                
            //Forma de inscripción que se utilizara el sistema
            //valores '1': la inscripcion se realiza por materia
            //valores '2': la inscripcion se realiza por semestre completo
            $matris_configuracion[$i]->tipo_de_inscripcion = '2';
            
                    //Este opcion se utilizara solo cuando, tipo_de_inscripcion = '2';
                    //Valores desde cero hasta infinito, 0, 1, 2 ...
                    $matris_configuracion[$i]->numero_de_materia_de_arrastre = 2;

            //Habilita una opción
            //  - para que el estudiante reporte el o los pagos de una inscripción
            //  - para que el administrador o control de estudio, le aparezca una opción para ver el pago de un estudiante
            //valores: 0 / 1
            $matris_configuracion[$i]->habilitar_pago_de_inscripcion = 1;
                    $matris_configuracion[$i]->habilitar_pago_de_inscripcion_campo_de_motivo_de_pago = 1;
            //Fin de Inscripcion --------------------------------------------------------------------------------------------------------------------
            //______________________________________________________________________________________________________________________________________
            
            //activar el  menu de carga de notas iniciales y coloca una opcion en periodo para cargar un periodo con estatus cerrado.
            //valores 1: activo, valores 0: oculto
            $matris_configuracion[$i]->activar_carga_de_notas_iniciales = 1;
            
            //activar el uso de Items
            //valores 1: activo, valores 0: oculto
            //Esta opcion al estar activa se vera lo siguiente:
            //  - En Agregar Asignatura colocara un control obligarorio para seleccionar un grupo de items.
            $matris_configuracion[$i]->activar_el_uso_de_items = 1;
            
            //CONFIGURACION DEL PENSUM
            //horas y sesiones son unos campos para se visto en un reporte
            //Esta opcion ativa para activar o desactivar unos campos hubicados en 
            //Ver Pensum  -> click en asignaturas -> editar o agregar
            //valores 1: activo, valores 0: oculto
            $matris_configuracion[$i]->activar_campo_num_horas      = 1;
            //FIN DE CONFIGURACION DEL PENSUM
            
            
            //CONFIGURACION DE Asignaturas ofertadas
            //Esta opcion ativa para activar o desactivar unos campos hubicados en 
            //Asignatura ofertada por pensum -> en el formulario
            $matris_configuracion[$i]->activar_campo_num_sesiones   = 1;            
            
            //activar el  menu de asignaturas ofertadas generales
            //valores 1: activo, valores 0: oculto
            $matris_configuracion[$i]->activar_asignaturas_ofertadas_generales = 1;            
            //Fin de CONFIGURACION DE Asignaturas ofertadas

            //Activa la consulta de un reporte para el administrador hubicado en Configuración -> Consultas y carga de notas
            //valores 1: activo, valores 0: oculto
            $matris_configuracion[$i]->activar_reporte_de_notas_por_asignatura   = 1;
                    //valores 1: formato de cesdi de notas resumidas
                    $matris_configuracion[$i]->reporte_de_notas_por_asignatura_formato = 1;
                    //valores 1: formato de cesdi de notas detalladas usando items
                    $matris_configuracion[$i]->reporte_de_notas_por_asignatura_con_items_formato = 1;
            
            //En las vista y los reportes, se mostrará la calificacion con un estado o un valor numérico
            //Al estar activo se mostrar la calificion total com "Aprobado o Reprobado" y no una escala
            //Valores: 0="cuantitativa" / 1="cualitativa" 
            $matris_configuracion[$i]->mostrar_vistas_con_calificacion_cualitativa = 1;
            
            //Campo solo para Cesdi
            //Habilita una opcion para cambiar el nombre de una calificación cualitativa de "reprobada" a "sigue"
            //Habilita una opcion en calificar, y enn la carga de notas iniciales.
            //valores 1: activo, valores 0: oculto
            $matris_configuracion[$i]->habilitar_campo_sigue = 1;
            
            //Habilitar clasificación Profesor
            //habilita un campo en la ficha de profesor que gurdara los siguientes valores: 1-Asistente, 2-Asociados, 3-Titulares, 4-Jubilados
            //valores: 0 / 1
            $matris_configuracion[$i]->habilitar_profesor_clasificacion = 1;
            
            //Habilitar Corte de pensum
            //habilita un crud que se asociara a un pensum llamado corte
            //valores: 0 / 1
            $matris_configuracion[$i]->habilitar_pensum_cohorte = 1;

            //Habilitar Retiro de Materias
            //Coloca una opcion de menu para el administrador permitir el retiro de materias.
            //valores: 0 / 1
            $matris_configuracion[$i]->habilitar_retiro_materias = 1;

            //Habilitar configurar clase quincenales
            //Coloca un segundo grupo de semanas en las clases de asignaturas ofertadas
            //valores: 0 / 1
            $matris_configuracion[$i]->habilitar_opciones_de_clase_quincenal = 1;
            
            //________________________________________________________________________________________________________
            //Formatos de Reportes
            //      valores: 1 :formato generico
            //      valores: 2 :formato de Cesdi
            $matris_configuracion[$i]->formato_horario_general      = 1;
            $matris_configuracion[$i]->formato_horario_estudiante   = 2;
            $matris_configuracion[$i]->formato_horario_profesor     = 2;
            //Hubicado en Configuracion -> Usuarios -> Estudiantes -> Lista
            $matris_configuracion[$i]->formato_lista_de_estudiantes     = 2;
            //Hubicado en Configuracion -> Administrar Pensum -> Pensum -> Reporte del pensum
            $matris_configuracion[$i]->formato_Pensum     = 1;
            //Numero del formato del reporte de oferta académica
            //valores: 
            //      1  : formato generico, sin firmas al final
            //      11 : formato generico, sin firmas al final, sin los campos horas y sesiones, sin CLASIFICACIÓN DOCENTE
            //      2  : formato utilizado por CESDI
            $matris_configuracion[$i]->formato_de_oferta_academica = 11;
            
            //Formato del reporte de inscripción
            //valores: 1: Formato Genérico, sin firmas
            //valores: 2: Formato De Cesdi
            $matris_configuracion[$i]->reporte_de_inscripcion_formato = 2;            
            
            //Constancia de Estudios
            //valores: 
            //      0  : Desactivado, ningún Formato
            //      1  : Formato generico, sin firmas al final
            //      2  : Formato de Cesdi
            $matris_configuracion[$i]->formato_constancia_estudios = 2;
            
            //OBSOLETA, Fue reempĺazado por record Académico
            //Aplica en las vistas Area de notas actuales que ve el administrador y el estudiante con sus reportes
            //valores: 
            //      0  : Desactivado, ningún Formato
            //      1  : Formato Comun    -> Notas Históricas  
            $matris_configuracion[$i]->formato_notas_actuales = 0;

            //Aplica en las vistas Area de notas historicas que ve el administrador y el estudiante con sus reportes
            //valores: 
            //      0  : Desactivado, ningún Formato
            //      1  : Formato Comun    -> Notas Históricas  
            $matris_configuracion[$i]->formato_notas_historicas = 1;

            //Aplica en las vistas Area de notas historicas que ve el administrador y el estudiante con sus reportes
            //valores:
            //      0  : Desactivado, ningún Formato
            //      1  : Formato Comun
            //      2  : Formato de Cesdi
            $matris_configuracion[$i]->formato_record_academico = 2;
            
            //Aplica en las vistas Area de notas historicas que ve el administrador y el estudiante con sus reportes
            //valores:
            //      0  : Desactivado, ningún Formato
            //      1  : Formato Comun
            //      2  : Formato de Cesdi
            $matris_configuracion[$i]->formato_notas_certificadas = 2;
            
            //Coloca un reporte de consulta de estudiantespor parte del administrador, hubicado en Consultas
            //valores:
            //      0  : Desactivado, ningún Formato
            //      1  : Formato Comun
            //      2  : Formato de Cesdi (NO EXISTE EN ESTE MOMENTO)
            $matris_configuracion[$i]->formato_orden_de_merito = 1;
            
            //Fin de Formatos de Reportes
            //________________________________________________________________________________________________________
            
            return $matris_configuracion;
    } */
    
}