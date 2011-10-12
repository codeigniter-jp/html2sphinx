<?php

$file = $argv[1];

/* first processing
 */

if (file_exists($file)) {
  $lines = file($file);
}
else {
  exit("No such file: $file\n");
}

$remove_before = 'ユーザガイドを検索'; 
$remove_after = '前のトピック|ページの先頭';

$new_doc = '';
$state = 'head';
$in_list = FALSE;

foreach ($lines as $line) {
  if ($state === 'head') {
    if (preg_match('/' . $remove_before . '/', $line, $matches)) {
      //var_dump($matches);
      $state = 'after_head';
    }
  }
  else if ($state === 'after_head') {
    if ($line != "\n") {
      $state = 'content';
      $new_doc .= $line;
    }
  }
  else {  // content
    if (preg_match('/' . $remove_after . '/', $line, $matches)) {
      break;
    }
    else {
      if (preg_match('/^\s*Note:\s(.*)/', $line, $m)) {
        //var_dump($m);
        $new_doc .= '.. note:: ' . $m[1];
      }
      else if (preg_match('/^- (.+)/', $line, $m)) {
        //var_dump($m);
        $new_doc .= '-  ' . $m[1] . "\n";
        $in_list = TRUE;
      }
      else if (preg_match('/^   - (.+)/', $line, $m)) {
        //var_dump($m);
        $new_doc .= '   -  ' . $m[1] . "\n";
        $in_list = TRUE;
      }
      else if ($line == "\n") {
        $in_list = FALSE;
        $new_doc .= $line;
      }
      else if ($in_list) {
        $new_doc .= ' ' . $line;
      }
      else {
        $new_doc .= $line;
      }
    }
  }
}

file_put_contents($file, $new_doc);

/* second processing
 */

if (file_exists($file)) {
  $lines = file($file);
}
else {
  exit("No such file: $file\n");
}

$new_doc = '';
$header_not_processed = TRUE;

foreach ($lines as $line) {
  if ($header_not_processed && preg_match('/^###/', $line, $matches)) {
    //var_dump($matches);
    $new_doc = $line . $new_doc . $line;
    $header_not_processed = FALSE;
  }
  else {
    $new_doc .= $line;
  }
}

file_put_contents($file, $new_doc);
