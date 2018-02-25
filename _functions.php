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

function sendMessage($chat_id, $text)
{
    global $API;
    return curlRequest('POST', $API . 'sendMessage', ['chat_id' => $chat_id, 'text' => $text]);
}

function sendMessagePlus($chat_id, $text, $parse_mode = 'default', $disable_web_page_preview = 'default', $disable_notification = false, $reply_to_message_id = 'default', $reply_markup = false, $inline = 'default', $resize_keyboard = false)
{
    global $API;
    global $Update;

    if ($parse_mode == 'default') {
        $parse_mode = 'HTML';
    }
    if ($reply_to_message_id == 'default') {
        $reply_to_message_id = $Update['message']['message_id'];
    }
    if ($inline == 'default') {
        $inline = true;
    } else {
        $inline = false;
    }
    if ($resize_keyboard == true) {
        $inline = false;
    }
    if ($disable_web_page_preview == 'default') {
        $disable_web_page_preview = true;
    }
    if (!$inline) {
        if ($resize_keyboard == true) {
            $rm = array(
                'hide_keyboard' => true
            );
        } else {
            $rm = array(
                'keyboard' => $reply_markup,
                'resize_keyboard' => true
            );
        }
    } else {
        $rm = array(
            'inline_keyboard' => $reply_markup
        );
    }
    $rm   = json_encode($rm);
    $args = array(
        'chat_id' => $chat_id,
        'text' => $text,
        'disable_notification' => $disable_notification,
        'parse_mode' => $parse_mode
    );
    if ($disable_web_page_preview) {
        $args['disable_web_page_preview'] = $disable_web_page_preview;
    }
    if ($reply_to_message_id) {
        $args['reply_to_message_id'] = $reply_to_message_id;
    }
    if ($reply_markup) {
        $args['reply_markup'] = $rm;
    }
    if ($text) {
        $rr   = curlRequest('post', $API . 'sendMessage', $args);
        $ar   = json_decode($rr, true);
        $ok   = $ar['ok'];
        $e403 = $ar['error_code'];
        if ($e403 == '403') {
            return false;
        } elseif ($e403) {
            return false;
        } else {
            return $rr;
        }
    }
}

function cb_reply($id, $text, $alert = false, $cbmid = false, $ntext = false, $nmenu = false, $npm = 'pred')
{
    global $API;
    global $chatID;
    global $Update;

    if ($npm == 'pred') {
        $npm = 'HTML';
    }
    $args = array(
        'callback_query_id' => $id,
        'text' => $text,
        'show_alert' => $alert
    );
    $r    = curlRequest('post', $API . 'answerCallbackQuery', $args);
    if ($cbmid) {
        if ($nmenu) {
            $rm = array(
                'inline_keyboard' => $nmenu
            );
            $rm = json_encode($rm);
        }
        $args = array(
            'chat_id' => $chatID,
            'message_id' => $cbmid,
            'text' => $ntext,
            'parse_mode' => $npm
        );
        if ($nmenu) {
            $args['reply_markup'] = $rm;
        }
        $r = curlRequest('post', $API . 'editMessageText', $args);
    }
}
