<?php


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

    //F.E creats a new alphabet starting with the key array and
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
        echo 'START: ' . $i . '- - - - - - -';
        
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
    echo $decodedString . '<br>'; 

    return $decodedString;
}



function letterToAsciAddNumberBackToLetter($character) {
    $adjustedCharacter = chr(ord($character) + 2);
    echo $adjustedCharacter . '-';
    return $adjustedCharacter;
}


echo '1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 x x x x x x' . '<br>';
$inputString1 = 'kh lv qrw wkh phvvldkd kh lv d yhub qdxjkwb erb';
$inputStringArr1 = str_split($inputString1);
rotateDecypher($inputStringArr1, $alphabetArr);


echo '3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 x x x x' . '<br>';
$inputString2 = 'pbzfsobp dkfobtpkx lq pbkfi ppbkfpry aoxtolc iixz lq abpr bobt pbzfsba cl bmvq obail bpbeq';
$inputString3 = 'borzsm fob nxk dyb k cs csrd';
$inputStringArr3 = str_split(strrev($inputString3));
rotateDecypher($inputStringArr3, $alphabetArr);

echo '4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 x x x x x' . '<br>';
//test coded string with keyWord
$inputString6 = 'dghvetpst bm ihvtl';
$inputStringArr6 = str_split($inputString6);
substituteDecypher($inputStringArr6, $alphabetArr, $adjustedAlphabet1);

echo '5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 x x x x' . '<br>';



echo '6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 x x x x x' . '<br>';

?>



    