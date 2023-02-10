<?php
if (isset($data['totalAmount'])) {
    $strData = str_replace('"totalAmount":"' . $data['totalAmount'] . '"',
        '"totalAmount":' . $data['totalAmount'] . '',
        $strData);
}
if (isset($data['transactionAmount'])) {
    $strData = str_replace('"transactionAmount":"' . $data['transactionAmount'] . '"',
        '"transactionAmount":' . $data['transactionAmount'] . '',
        $strData);
}

if (isset($data['transactions'])) {
    $count = count($data['transactions']);
    for ($i = 0; $i < $count; $i++) {
        $strData = str_replace('"total":"' . $data['transactions'][$i]['amount']['total'] . '"',
            '"total":' . $data['transactions'][$i]['amount']['total'] . '',
            $strData);
        $countitem = count($data['transactions'][$i]['amount']['details']['items']);

        for ($j = 0; $j < $countitem; $j++) {
            $strData =
                str_replace('"subTotal":"' . $data['transactions'][$i]['amount']['details']['items'][$j]['subTotal'] . '"',
                    '"subTotal":' . $data['transactions'][$i]['amount']['details']['items'][$j]['subTotal'] . '',
                    $strData);
        }
    }
}
if (isset($data['transaction'])) {
    $strData = str_replace('"total":"' . $data['transaction']['total'] . '"',
        '"total":' . $data['transaction']['total'] . '',
        $strData);
    $strData = str_replace('"transactionAmount":"' . $data['transaction']['transactionAmount'] . '"',
        '"transactionAmount":' . $data['transaction']['transactionAmount'] . '',
        $strData);
}

if (isset($data['detail'])) {
    $strData = str_replace('"amount":"' . $data['detail']['amount'] . '"',
        '"amount":' . $data['detail']['amount'] . '',
        $strData);
}
