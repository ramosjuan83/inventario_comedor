<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">        
        <title>IVIC SISTEMA INTEGRAL</title>
        <link rel="icon" type="image/png" href="<?php echo '' .base_url('/images').''?>/favicon_para_icon.png" sizes="16x16" />

        <?php
            //echo "ruta_llamados_head *".$ruta_llamados_head."*";
            if (isset($ruta_llamados_head)){
                $this->load->view($ruta_llamados_head);
            }
        ?>

    </head>
    <body class="bg-body bg-light">