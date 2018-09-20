<?php
//http://192.168.20.20/PHP/play/cipher/

//-------CONSTANTS AND VARIABLES --------------------------------------------

$alphabetArr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

$alphabetMatrix = [['a','b','c','d','e'],['f','g','h','i','k'],['l','m','n','o','p'],['q','r','s','t','u'],['v','w','x','y','z']];

$keyWord = 'kryptos';
$keyWordArr = str_split($keyWord);
$adjustedAlphabet1 = newAlphabet($alphabetArr, $keyWordArr);
var_dump($adjustedAlphabet1);

//-------FUNCTIONS --------------------------------------------

//Creating a re-ordered alphabet array which starts with key
// and ends in remaining alphabet characters
function newAlphabet($alphabetArr, $keyWordArr) {
    //this compares array1 and array2 and returns array1 which are not present in array2
    $nonKeyCharacters = array_diff($alphabetArr, $keyWordArr);

    //F.E loop creats a new alphabet starting with the key array and
    // adding on all the characters of the alphabet which
    // are not in the key array (i.e. re-ordered alphabet)
    foreach ($nonKeyCharacters as $addChar) {
        array_push($keyWordArr, $addChar);
    }
    return $keyWordArr;
};



function rotateDecypher($encryptedString, $alphabetArr) {
    for ($i = 0; $i < 27; $i++) {
        $decodedArr = [];
        echo 'ROT' . $i . '- - - - - - -';
        
        foreach ($encryptedString as $inputletter) {
            if($inputletter == " ") {
                $decodedArrAll = array_push($decodedArr, " ");
                continue;
            };
            $keyfound = (array_search($inputletter, $alphabetArr) + $i) % 26;
            $decodedArrAll = array_push($decodedArr, $alphabetArr[$keyfound]);
        }
        
        $decodedString = implode("", $decodedArr);
        echo $decodedString . '<br>'; 
        }
        return $decodedString;
}


function substituteDecypher($encryptedString, $alphabetArr, $alphabetArrEncrypted) {
    $decodedArr = [];
    
    foreach ($encryptedString as $inputletter) {
        if($inputletter == " ") {
            $decodedArrAll = array_push($decodedArr, " ");
            continue;
        };
        $keyfound = array_search($inputletter, $alphabetArrEncrypted) ;
        $decodedArrAll = array_push($decodedArr, $alphabetArr[$keyfound]);
    }
    
    $decodedString = implode("", $decodedArr);
    return $decodedString;
}


function letterToAsciBackToLetter($encryptedString) {
    $decodedArr = [];

    foreach ($encryptedString as $inputletter) {
        if($inputletter == " ") {
            $decodedArrAll = array_push($decodedArr, " ");
            continue;
        };
        $charFound = chr(ord($inputletter) + 30) ;
        array_push($decodedArr, $charFound);
    }

    $decodedString = implode("", $decodedArr);
    return $decodedString;
}

//-------ENCODED AND DECIPHERED --------------------------------------------

echo '- - - - - - - SIMPLE ROT - - - - - - - - - ' . '<br>';
$inputString1 = 'kh lv qrw wkh phvvldkd kh lv d yhub qdxjkwb erb';
$inputStringArr1 = str_split($inputString1);
rotateDecypher($inputStringArr1, $alphabetArr);

echo '- - - - - - - ROT AND REV - - - - - - - - - ' . '<br>';
$inputString2 = 'borzsm fob nxk dyb k cs csrd';
$inputStringArr2 = str_split(strrev($inputString2));
rotateDecypher($inputStringArr2, $alphabetArr);

echo '- - - - - - - SUBSTITUTE CIPHER (WITH KEY) - - - - - - - - -' . '<br>';
//test coded string with keyWord
$inputString3 = 'dghvetpst bm ihvtl';
$inputStringArr3 = str_split($inputString3);
echo substituteDecypher($inputStringArr3, $alphabetArr, $adjustedAlphabet1) . '<br>';

echo '- - - - - - - ASCII CIPHER - - - - - - - - -' . '<br>';
//move from Capital to lower case ascii
$inputString4 = 'UVQR UJQWVKPI';
$inputStringArr4 = str_split($inputString4);
echo letterToAsciBackToLetter($inputStringArr4) . '<br>';

echo '- - - - - - - MATRIX CIPHER - - - - - - - - -' . '<br>';
$inputString5 = '';
$inputStringArr5 = str_split($inputString5);
echo letterToAsciBackToLetter($inputStringArr4) . '<br>';


?>



    