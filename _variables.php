<?php

$chatID        = $Update['message']['chat']['id'];
$userID        = $Update['message']['from']['id'];
$msg           = $Update['message']['text'];
$username      = $Update['message']['from']['username'];
$msgID         = $Update['message']['message_id'];
$nome          = $Update['message']['from']['first_name'];
$cognome       = $Update['message']['from']['last_name'];
$language_code = $Update['message']['from']['language_code'];
$messageID     = $Update['message']['message_id'];
if ($chatID < 0) {
    $titolo       = $Update['message']['chat']['title'];
    $usernamechat = $Update['message']['chat']['username'];
}
$video_note = $Update['message']['video_note']['file_id'];
$voice      = $Update['message']['voice']['file_id'];
$photo      = $Update['message']['photo'][0]['file_id'];
$photo_array = array();
foreach ($Update['message']['photo'] as $photo_file_id) {
    $photo_array[] = $photo_file_id;
}
$document   = $Update['message']['document']['file_id'];
$audio      = $Update['message']['audio']['file_id'];
$sticker    = $Update['message']['sticker']['file_id'];
if ($Update['callback_query']) {
    $cbid     = $Update['callback_query']['id'];
    $cbdata   = $Update['callback_query']['data'];
    $cbmid    = $Update['callback_query']['message']['message_id'];
    $chatID   = $Update['callback_query']['message']['chat']['id'];
    $userID   = $Update['callback_query']['from']['id'];
    $nome     = $Update['callback_query']['from']['first_name'];
    $cognome  = $Update['callback_query']['from']['last_name'];
    $username = $Update['callback_query']['from']['username'];
}

 ?>
