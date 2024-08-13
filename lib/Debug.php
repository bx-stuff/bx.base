<?php

declare(strict_types=1);

namespace BX\Base;

class Debug
{
    public static function dumpConsole($var): void
    {
        $jsonArray = json_encode($var);
        echo "<script>let fullCSVArray = $jsonArray;console.log(fullCSVArray);</script>";
    }
}