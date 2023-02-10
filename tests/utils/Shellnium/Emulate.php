<?php

namespace utils\Shellnium;

class Emulate
{
    public static function run($url, $accountNumber)
    {
        exec(__DIR__ . "/check_chrome_driver.sh", $checkResult);
        $isReady = json_decode($checkResult[0], true)['ready'];
        if($isReady == 0) {
            exec(__DIR__ . "/chromedriver > /dev/null 2>/dev/null &");
            sleep(2);
        }
        exec("bash " . __DIR__ . "/fairstone.sh $url $accountNumber " . __DIR__, $bashResults);
        var_dump($bashResults);
    }
}