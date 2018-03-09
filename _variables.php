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

$chatID = $Update['message']['chat']['id'];
$userID = $Update['message']['from']['id'];
$msg = $Update['message']['text'];
$username = $Update['message']['from']['username'];
$msgID = $Update['message']['message_id'];
$nome = $Update['message']['from']['first_name'];
$cognome = $Update['message']['from']['last_name'];
$language_code = $Update['message']['from']['language_code'];
$messageID = $Update['message']['message_id'];
if ($chatID < 0) {
    $titolo = $Update['message']['chat']['title'];
    $usernamechat = $Update['message']['chat']['username'];
}
$video_note = $Update['message']['video_note']['file_id'];
$voice = $Update['message']['voice']['file_id'];
$photo = $Update['message']['photo'][0]['file_id'];
$photo_array = [];
foreach ($Update['message']['photo'] as $photo_file_id) {
    $photo_array[] = $photo_file_id;
}
$document = $Update['message']['document']['file_id'];
$audio = $Update['message']['audio']['file_id'];
$sticker = $Update['message']['sticker']['file_id'];
if ($Update['callback_query']) {
    $cbid = $Update['callback_query']['id'];
    $cbdata = $Update['callback_query']['data'];
    $cbmid = $Update['callback_query']['message']['message_id'];
    $chatID = $Update['callback_query']['message']['chat']['id'];
    $userID = $Update['callback_query']['from']['id'];
    $nome = $Update['callback_query']['from']['first_name'];
    $cognome = $Update['callback_query']['from']['last_name'];
    $username = $Update['callback_query']['from']['username'];
}
