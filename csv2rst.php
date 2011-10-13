<?php
mb_internal_encoding("UTF-8");

    $fh_in = fopen('sample.csv','r');
    $fh_out = fopen('sample.rst','w');
    $dataarray = array();
    while($arr = fgetcsv($fh_in,1024)){
        $dataarray[] = $arr;
    }

    include_once('makerst.php');
    include_once('max_length.php');
    $maxlength = new Max_length($dataarray);
    $maxlength_array = $maxlength->get_max_length_data();
    $makerst = new Makerst($dataarray,$maxlength_array);
    
    $out = "";
    $out .= $makerst->lineout(' ','=');
    $out .= $makerst->outall();
    $out .= $makerst->lineout(' ','=');
    /*
    $out .= $makerst->lineout('+');
    $out .= $makerst->outall('|');
    $out .= $makerst->lineout('+');
     */

    fwrite($fh_out,$out);
    fclose($fh_in);
    fclose($fh_out);
