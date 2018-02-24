<?php

/*
          Copyright (C) 2018 Enea Dolcini


          This file is part of getUpdatesBot.
          getUpdatesBot is free software: you can redistribute it and/or modify
          it under the terms of the GNU Affero General Public License as published by
          the Free Software Foundation, either version 3 of the License, or
          (at your option) any later version.

          getUpdatesBot is distributed in the hope that it will be useful,
          but WITHOUT ANY WARRANTY; without even the implied warranty of
          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
          GNU Affero General Public License for more details.

          You should have received a copy of the GNU  Affero General Public License
          along with getUpdatesBot.  If not, see http://www.gnu.org/licenses.
*/

error_reporting(E_ERROR);
if(isset($argv[1]) and $argv[1] == 'background') {
  shell_exec('screen -d -m php start.php');
  echo 'getUpdatesBot avviato in background.' . PHP_EOL;
  exit;
}
if(isset($argv[1]) and $argv[1] == 'update') {
  echo 'Starting updating getUpdatesBot...' . PHP_EOL;
  try {
    $_commands = file_get_contents('_commands.php');
    $token = file_get_contents('api_token.php');
    shell_exec('git pull');
    file_put_contents('_commands.php', $_commands);
    file_put_contents('api_token.php', $token);
  } catch (\Exception | \Error $e) {
    echo 'Error while trying to update getUpdatesBot: ' . $e->getMessage() . ' on line ' . $e->getLine() . PHP_EOL;
    file_put_contents('error.log', 'Error while trying to update getUpdatesBot: ' . $e->getMessage() . ' on line ' . $e->getLine());
    exit;
  }
  echo 'getUpdatesBot updated!' . PHP_EOL;
  exit;
}

if(isset($argv[1]) and $argv[1] !== 'background' and $argv[1] !== 'update') {
  exit ('Unknown option ' . $argv[1] . PHP_EOL);
}

echo 'getUpdatesBot is starting...' . PHP_EOL;
require 'api_token.php';
$API  = 'https://api.telegram.org/bot' . $Token . '/';
if(file_exists('_commands.php') and file_exists('_functions.php')) {
  echo '_commands.php and _functions.php loaded.' . PHP_EOL;
} else {
  exit ('Error while trying to include _functions and _commands.php' . PHP_EOL);
}
$Offset = 0;
echo 'Starting receiving updates...' . PHP_EOL;
function curlRequest($type, $url, $args = null) {
  $type = strtoupper($type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  if($type == 'GET') {
    $url = $url . '?' . http_build_query($args);
    curl_setopt($ch, CURLOPT_URL, $url);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($type == 'POST') {
    curl_setopt($ch, 'CURLPT_POST', true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
  }
  $exec = curl_exec($ch);
  curl_close($ch);
  return $exec;
}
try {
  require_once '_functions.php';
} catch (\Error | \Exception $e) {
  file_put_contents('_error.log', 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
  exit ('Error in ' . $e->getFile() . ' on line ' . $e->getLine() . ', look in _error.log. The error is ' . $e->getMessage() . PHP_EOL);
}
while(true) {
  $Updates = json_decode(curlRequest('POST', $API . 'getUpdates?offset=' . $Offset), true);
  if($Updates['ok'] == false) {
    exit ('Telegram error: ' . $Updates['description'] . PHP_EOL);
  }
  foreach($Updates['result'] as $Key => $Value) {
    $Update = $Updates['result'][$Key];
    if(empty($Update)) continue;
    require '_variables.php';
    require '_commands.php';
  }
  $Offset = $Updates['result'][count($Updates['result']) - 1]['update_id'] + 1;
}
 ?>
