<?php

mb_internal_encoding('UTF-8');

require 'simple_html_dom.php';
require 'makerst.php';
require 'max_length.php';

$file = $argv[1];

if (file_exists($file)) {
  $html = file_get_html($file);
}
else {
  exit("No such file: $file\n");
}

$tables = $html->find('table');
$count = count($tables);
$i = 2;  // 1st, 2nd tables are used for layout
$filename = 'tmp.csv';

while ($count > 2) {
  $table = $html->find('table', $i);
  $output = '';

  foreach ($table->find('tr') as $tr) {
    $a = array();
    $col = 0;

    foreach ($tr->find('td,th') as $td) {
      $row = 0;
      $tmp = htmlspecialchars_decode($td->plaintext);
      $length = 40;

      for ($j = 0; $j < mb_strlen($tmp); $j += $length ) {
        $part = mb_substr($tmp, $j, $length);
        //var_dump($part);
        $part = str_replace('"', '""', $part);
        $a[$col][$row] = '"' . $part . '"';
        $row++;
      }

      $col++;
    }

    //var_dump($a);
    $max = 0;
    foreach ($a as $item) {
      $max = max($max, count($item));
    }
    //var_dump($max);
    
    for ($j = 0; $j < $max; $j++) {
      $tmp = array();
      foreach ($a as $item) {
      	//var_dump($item);
        if ( ! isset($item[$j])) {
          $item[$j] = '""';
        }
        $tmp[] = $item[$j];
      }
      $output .= implode(',', $tmp) . "\n";
    }
  }
  
  file_put_contents($filename, $output);

  $fh_in = fopen($filename, 'r');
  $data_array = array();
  while($arr = fgetcsv($fh_in, 1024)){
    $data_array[] = $arr;
  }

  $maxlength = new Max_length($data_array);
  $maxlength_array = $maxlength->get_max_length_data();
  $makerst = new Makerst($data_array,$maxlength_array);

  $out = '';
  $out .= $makerst->lineout(' ', '=');
  $out .= $makerst->outall();
  $out .= $makerst->lineout(' ', '=');

  echo $out;

  $i++;
  $count--;
  $output = '';
}
