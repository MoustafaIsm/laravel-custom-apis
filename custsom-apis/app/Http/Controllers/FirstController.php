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

        // separate the main string into substrings
        for ($i=0; $i < strlen($randomString); $i++) { 
            if (ctype_upper($randomString[$i])) {
                $upperCaseChar = $upperCaseChar . $randomString[$i];
            } elseif (ctype_lower($randomString[$i])) {
                $lowerCaseChar = $lowerCaseChar . $randomString[$i];
            } else {
                $numbers = $numbers . $randomString[$i];
            }
        }

        // Remove duplicates from the substrings
        $lowerCaseChar = count_chars($lowerCaseChar, 3);
        $upperCaseChar = count_chars($upperCaseChar, 3);
        $numbers = count_chars($numbers, 3);

        // Sort the sub Strings and convert it to an array
        $lowerCaseArray = sortSubStringIntoArray($lowerCaseChar);
        $upperCaseArray = sortSubStringIntoArray($upperCaseChar);
        $numbers = sortSubStringIntoArray($numbers);

        // Intializing an associative array
        $tempArray = array();

        // Adding the normal arrays to the associative array
        for ($j=0; $j < count($lowerCaseArray); $j++) { 
            $tempArray[$lowerCaseArray[$j]] = ord($lowerCaseArray[$j]) - 33;
        }
        for ($k=0; $k < count($upperCaseArray); $k++) { 
            $tempArray[$upperCaseArray[$k]] = ord($upperCaseArray[$k]);
        }

        // Sorting the values of the associative array (They are ascii values)
        asort($tempArray);

        // Take the index (character) of the associative array in the result string
        foreach ($tempArray as $index => $value) {
            $resultString = $resultString . $index;
        }

        // Adding the numbers at the end (they are already sorted)
        $resultString = $resultString . implode($numbers);

        return response()->json([
            "response"=> "success",
            "result"=> $resultString
        ]);

    }

    function getNumberPlacements($num) {
        if (is_numeric($num)) {
            $digitCount = countDigits($num);
            $modValue = pow(10, $digitCount - 1);
            $resultArray = array();
            while ($modValue > 0) {
                if ($num < 10) {
                    $temp = $num;
                    array_push($resultArray, $temp);
                    break;
                } else {
                    $temp = $num -($num % $modValue);
                    $num = $num - $temp;
                    $modValue = $modValue / 10;
                }
                array_push($resultArray, $temp);
            }
            return response()->json([
                "response"=> "success",
                "result"=> $resultArray
            ]);
        } else {
            return response()->json([
                "response"=> "failed"
            ]);
        }
        
    }

    function transformHumanToRobot() {
        $string = request()->string;
        preg_match_all('!\d+!', $string, $matches);
        $resultString = $string;
        foreach ($matches[0] as $item) {
            $resultString = str_replace($item, "" . decbin($item), $resultString);
        }
        return response()->json([
            "response"=> "success",
            "result"=> $resultString
        ]);
    }

    function solveNotation() {
        $prefixNotation = request()->prefixNotation;
        $notationArray = explode(" ", $prefixNotation);
        $operator = $notationArray[0];
        $resultString = calculateResult($operator, $notationArray);
        return response()->json([
            "response"=> "success",
            "result"=> $resultString
        ]);
    }

}

function sortSubStringIntoArray($subString) {
    $array = str_split($subString);
    sort($array);
    return $array;
}

function countDigits($myNum){
    $myNum = (int)$myNum;
    $count = 0;
  
    while($myNum != 0){
      $myNum = (int)($myNum / 10);
      $count++;
    }
    return $count;
}

function calculateResult ($operator, $operands) {
    $value = $operands[1];
    $result = "";
    switch ($operator) {
        case '+':
            for ($i=2; $i < count($operands); $i++) { 
                $value += $operands[$i];
            }
            $result = "Result: " . $value;
            break;
        
        case '-':
            for ($i=2; $i < count($operands); $i++) { 
                $value -= $operands[$i];
            }
            $result = "Result: " . $value;
            break;

        case '*':
            for ($i=2; $i < count($operands); $i++) { 
                $value *= $operands[$i];
            }
            $result = "Result: " . $value;
            break;

        case '/':
            for ($i=2; $i < count($operands); $i++) { 
                if ($operands[$i] != 0) {
                    $value /= $operands[$i];
                    
                } else {
                    return "Cant divide with 0.";
                }
            }
            $result = "Result: " . $value;
            break;

        default:
            $result = "No answer.";
            break;
    }
    return $result;
}
