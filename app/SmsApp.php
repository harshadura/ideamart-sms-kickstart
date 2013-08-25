<?php
/**
 *   (C) Copyright 1997-2013 hSenid International (pvt) Limited.
 *   All Rights Reserved.
 *
 *   These materials are unpublished, proprietary, confidential source code of
 *   hSenid International (pvt) Limited and constitute a TRADE SECRET of hSenid
 *   International (pvt) Limited.
 *
 *   hSenid International (pvt) Limited retains all title to and intellectual
 *   property rights in these materials.
 */

include_once '../lib/SmsReceiver.php';
include_once '../lib/SmsSender.php';
include_once '../lib/log.php';
include_once 'AppLogic.php';
ini_set('error_log', '../logs/sms-app-error.log');

try {
    $ini_array = parse_ini_file('../config/settings.ini');

    $receiver = new SmsReceiver(); // Create the Receiver object

    $content = $receiver->getMessage(); // get the message content
    $address = $receiver->getAddress(); // get the sender's address
    $requestId = $receiver->getRequestID(); // get the request ID
    $applicationId = $receiver->getApplicationId(); // get application ID
    $encoding = $receiver->getEncoding(); // get the encoding value
    $version = $receiver->getVersion(); // get the version

    logFile("[ content=$content, address=$address, requestId=$requestId, applicationId=$applicationId, encoding=$encoding, version=$version ]");

    $responseMsg;

    // ****** SMS Process ***** //
    $responseMsg = getResponse($content);
    // ******-------------***** //

    $applicationId = $ini_array['applicationId'];
    $password = $ini_array['password'];
    $sourceAddress = $ini_array['sourceAddress'];

 	$encoding = "0";
 	$version =  "1.0";
    $deliveryStatusRequest = "1";
    $charging_amount = ":15.75";
    $destinationAddresses = array("tel:94771122336");
    $binary_header = "";

    $serverUrl = $ini_array['serverUrl'];
    $sender = new SmsSender($serverUrl);

    $res = $sender->sms($responseMsg, $destinationAddresses, $password, $applicationId, $sourceAddress, $deliveryStatusRequest, $charging_amount, $encoding, $version, $binary_header);

} catch (SmsException $ex) {
    //throws when failed sending or receiving the sms
    error_log("ERROR: {$ex->getStatusCode()} | {$ex->getStatusMessage()}");
}

?>