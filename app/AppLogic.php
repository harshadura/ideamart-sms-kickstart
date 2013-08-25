<?php

function getResponse($fullMessage)
{
    $split = explode(' ', $fullMessage);

    if (sizeof($split) < 2) {
        $responseMsg = "Invalid message content";
    } else {
        $name = $split[1];
        $responseMsg = getLuckyNumber($name);
    }
    return $responseMsg;
}

function getLuckyNumber($name)
{
    $luckyNo = rand(0,9);
    $res = "Hello " . $name . ", Your today's lucky number is: " . $luckyNo;
    return $res;
}

?>