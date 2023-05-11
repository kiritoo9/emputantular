<?php

namespace Empu;

/**
 * Empu-Logs Module
 * -------
 * Catch all errors to error.log file
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;

class Logs extends Core
{

	public static function empuErrHandler($err): void
	{
        date_default_timezone_set('Asia/Jakarta');
        $log = 
            "Date: ".date("Y-m-d H:i:s").PHP_EOL.
            "Error: ".$err->getMessage().PHP_EOL.
            "Location: ".$err->getFile().' in line '.$err->getLine().PHP_EOL.PHP_EOL;

        $assumedLine = 3;
        $countLine = 0;
        $filepath = './error.log';

        if(!file_exists($filepath)) {
            $fp = fopen($filepath, "w");
            fwrite($fp, "");
            fclose($fp);
            chmod($filepath, 0777); 
        }

        $fh = fopen($filepath, 'r');
        while ($line = fgets($fh)) {
          if(trim($line) !== "") $countLine++;
        }
        fclose($fh);

        if($countLine > 0 && ($countLine/3) >= 10) {
            /** 
             * Remove the oldest error
             * assumed 3lines in every error (defined in var $log)
             * +1 line for line break
             **/

            $fdel = fopen($filepath, 'r');
            $index = 1;
            $cleanContent = '';
            while ($line = fgets($fdel)) {
                if($index > ($assumedLine+1)) {
                    $cleanContent .= $line;
                }
                $index++;
            }
            fclose($fdel);
            file_put_contents($filepath, $cleanContent);
        }

        file_put_contents($filepath, $log, FILE_APPEND);
        header("HTTP/1.0 400 Bad Request");
        require_once __DIR__ . '/errors/html/errorHandler.php';
        return;
	}

}