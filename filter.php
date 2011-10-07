<?php

$file = $argv[1];

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
  else {
    if (preg_match('/' . $remove_after . '/', $line, $matches)) {
      break;
    }
    else {
      $new_doc .= $line;
    }
  }
}

file_put_contents($file, $new_doc);

