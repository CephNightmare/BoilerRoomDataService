<?php
header('Access-Control-Allow-Origin: *');

require '../vendor/autoload.php';
use Firebase\JWT\JWT;

function validateUser($secretKey)
{
    $jwt = $_POST['jwt'];

    $token = JWT::decode($jwt, $secretKey, array('HS512'));

    $tokenArray = (array)$token;
    $dataArray = (array)$tokenArray['data'];
    return $dataArray;
}