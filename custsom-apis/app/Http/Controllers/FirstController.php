<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstController extends Controller
{
    
    function sortString($randomString) {
        $lowerCaseChar = "";
        $upperCaseChar = "";
        $numbers = "";
        $resultString = "";
        // separate the main string into substring
        for ($i=0; $i < strlen($randomString); $i++) { 
            if (ctype_upper($randomString[$i])) {
                $upperCaseChar = $upperCaseChar . $randomString[$i];
            } elseif (ctype_lower($randomString[$i])) {
                $lowerCaseChar = $lowerCaseChar . $randomString[$i];
            } else {
                $numbers = $numbers . $randomString[$i];
            }
        }
        // Sort the sub Strings
        $lowerCaseChar - sortSubString($lowerCaseChar);
        $upperCaseChar = sortSubString($upperCaseChar);
        $numbers = sortSubString($numbers);

    }

    function sortSubString($subString) {
        $array = str_split($subString);
        sort($array);
        return implode($array);
    }

}
