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

if (file_exists('settings.php') == 0 or ($argv[1] != 'update' && empty(file_get_contents('settings.php')))) {
    touch('settings.php');
    echo 'An update is required, please run php start.php update'.PHP_EOL;
    exit();
}

require 'settings.php';

if (file_exists('trad_'.$settings['language'].'.json')) {
    $trad = file_get_contents('trad_'.$settings['language'].'.json');
} else {
    if ($settings['language'] == 'it') {
        file_put_contents('trad_it.json', curlRequest('GET', 'https://neneone.github.io/getUpdatesBot.trad_it.json'));
        $trad = file_get_contents('trad_it.json');
    } elseif ($settings['language'] == 'en') {
        file_put_contents('trad_en.json', curlRequest('GET', 'https://neneone.github.io/getUpdatesBot.trad_en.json'));
        $trad = file_get_contents('trad_en.json');
    } elseif (file_exists('trad_en.json')) {
        $trad = file_get_contents('trad_en.json');
    } elseif (file_exists('trad_it.json')) {
        $trad = file_get_contents('trad_en.json');
    } else {
        file_put_contents('trad_en.json', curlRequest('GET', 'https://neneone.github.io/getUpdatesBot.trad_en.json'));
        $trad = file_get_contents('trad_en.json');
    }
}

$trad = json_decode($trad, true);

echo $trad['trad_loaded'].PHP_EOL;

if (isset($argv[1]) && $argv[1] == 'background') {
    shell_exec('screen -d -m php start.php');
    echo $trad['background'].PHP_EOL;
    exit;
}
if (isset($argv[1]) && $argv[1] == 'update') {
    echo $trad['update'].PHP_EOL;
    if (file_exists('.git')) {
        try {
            $_commands = file_get_contents('_commands.php');
            $token = file_get_contents('api_token.php');
            $settings = file_get_contents('settings.php');
            @unlink('settings.php');
            shell_exec('git reset --hard HEAD');
            shell_exec('git pull');
            file_put_contents('_commands.php', $_commands);
            file_put_contents('api_token.php', $token);
            if (!empty($settings)) {
                file_put_contents('settings.php', $settings);
            }
            unlink('_config.yml');
            unlink('README.md');
        } catch (\Exception | \Error $e) {
            echo 'Error while trying to update getUpdatesBot: '.$e->getMessage().' on line '.$e->getLine().PHP_EOL;
            file_put_contents('error.log', 'Error while trying to update getUpdatesBot: '.$e->getMessage().' on line '.$e->getLine());
            exit;
        }
    } else {
        file_put_contents('_functions.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/_functions.php'));
        file_put_contents('_variables.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/_variables.php'));
        file_put_contents('LICENSE', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/LICENSE'));
        file_put_contents('start.php', curlRequest('GET', 'https://raw.githubusercontent.com/Neneone/getUpdatesBot/master/start.php'));
    }
    echo $trad['updated'].PHP_EOL;
    exit;
}

if (isset($argv[1]) && $argv[1] !== 'background' && $argv[1] !== 'update') {
    exit($trad['unknown_option'].$argv[1].PHP_EOL);
}

echo $trad['starting'].PHP_EOL;
require 'api_token.php';
$API = 'https://api.telegram.org/bot'.$Token.'/';
if (file_exists('_commands.php') && file_exists('_functions.php')) {
    echo $trad['loaded'].PHP_EOL;
} else {
    exit('Error while trying to include _functions and _commands.php'.PHP_EOL);
}
$Offset = 0;
echo $trad['update_fetching'].PHP_EOL;
function curlRequest($type, $url, $args = null)
{
    $type = strtoupper($type);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($type == 'GET') {
        $url = $url.'?'.http_build_query($args);
        curl_setopt($ch, CURLOPT_URL, $url);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($type == 'POST') {
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
    file_put_contents('_error.log', 'Error: '.$e->getMessage().' on line '.$e->getLine().' in '.$e->getFile());
    exit('Error in '.$e->getFile().' on line '.$e->getLine().', look in _error.log. The error is '.$e->getMessage().PHP_EOL);
}
while (true) {
    $Updates = json_decode(curlRequest('POST', $API.'getUpdates?offset='.$Offset), true);
    if ($Updates['ok'] == false) {
        exit('Telegram error: '.$Updates['description'].PHP_EOL);
    }
    foreach ($Updates['result'] as $Key => $Value) {
        $Update = $Updates['result'][$Key];
        if (empty($Update)) {
            continue;
        }
        require '_variables.php';
        require '_commands.php';
        if ($settings['log'] == 1 && $chatID > 0 && $msg) {
            $msg = strip_tags($msg);
            echo $nome.' ['.$userID.'] -> '.$msg.$msg[count(str_split($msg)) - 1].PHP_EOL;
        }
    }
    $Offset = $Updates['result'][count($Updates['result']) - 1]['update_id'] + 1;
}
