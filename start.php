<?php

error_reporting(E_ERROR);

if(isset($argv[1]) and $argv[1] == 'background') {
  shell_exec('screen -d -m php start.php');
  echo PHP_EOL . 'getUpdatesBot avviato in background.' . PHP_EOL;
  exit;
}

if(isset($argv[1]) and $argv[1] == 'update') {
  echo PHP_EOL . 'Starting updating getUpdatesBot...' . PHP_EOL;
  try {
    file_put_contents('_functions.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/_functions.php'));
    file_put_contents('_variables.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/_variables.php'));
    file_put_contents('LICENSE', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/LICENSE'));
    file_put_contents('README.md', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/README.md'));
    file_put_contents('start.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/start.php'));
  } catch (\Exception | \Error $e) {
    echo PHP_EOL . 'Error while trying to update getUpdatesBot: ' . $e->getMessage() . ' on line ' . $e->getLine() . PHP_EOL;
    file_put_contents('error.log', 'Error while trying to update getUpdatesBot: ' . $e->getMessage() . ' on line ' . $e->getLine());
    exit;
  }
  echo PHP_EOL . 'Bot updated!' . PHP_EOL;
  exit;
}

echo PHP_EOL . 'getUpdatesBot is starting...' . PHP_EOL;

$Token      = '523209487:AAEtYvbeFiGJ2g-2I76c0c1y6EC5NiKW_YQ'; #Insert here your API key
$API  = 'https://api.telegram.org/bot' . $Token . '/';

if(file_exists('_commands.php') and file_exists('_functions.php')) {
  echo PHP_EOL . '_commands.php and _functions.php loaded.' . PHP_EOL;
} else {
  exit (PHP_EOL . 'Error while trying to include _functions and _commands.php' . PHP_EOL);
}

$Offset = 0;

echo PHP_EOL . 'Starting receiving updates...' . PHP_EOL;

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

while(true) {
  $Updates = json_decode(curlRequest('POST', $API . 'getUpdates?offset=' . $Offset), true);
  if($Updates['ok'] == false) {
    exit (PHP_EOL . 'Telegram error: ' . $Updates['description'] . PHP_EOL);
  }
  try {
    require_once '_functions.php';
  } catch (\Error | \Exception $e) {
    file_put_contents('_error.log', 'Error: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
    exit (PHP_EOL . 'Error in ' . $e->getFile() . ' on line ' . $e->getLine() . ', look in _error.log. The error is ' . $e->getMessage() . PHP_EOL);
  }
  foreach($Updates['result'] as $Key => $Value) {
    $Update = $Updates['result'][$Key];
    require '_variables.php';
    require '_commands.php';
  }
  $Offset = $Updates['result'][count($Updates['result']) - 1]['update_id'] + 1;
}

 ?>
