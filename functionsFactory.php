<?php

namespace Neneone\getUpdatesBot;
use \Exception;

class functionsFactory {
  private $token;

  function __construct($token) {
    if(empty($token)) {
      throw new \Exception('Invalid token!');
      return false;
    }
    $this->token = $token;
    $this->API = 'https://api.telegram.org/bot' . $token . '/';
    return 'functionsFactory initialized...';
  }

  public function getFunction($method) {
    return function ($args = []) {
      if(!is_array($args)) {
        throw new \Exception('Parameters must be an array.');
        return 0;
      }
      return Neneone\getUpdatesBot\functionsFactory::TG_API($method, $args);
    };
  }

  public function TG_API($method, $args = []) {
    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $this->API . $method);
    curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($cURL, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($cURL, CURLOPT_POST, 1);
    curl_setopt($cURL, CURLOPT_POSTFIELDS, $args);
    curl_setopt($cURL, CURLOPT_TIMEOUT, 2);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($cURL);
    curl_close($cURL);
    return $result;
  }
}

 ?>
