<?php

$alphabetArr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

$keyWord = 'kryptos';
$keyWordArr = str_split($keyWord);


function newAlphabet($alphabetArr, $keyWordArr) {
    $diffX = array_diff($alphabetArr, $keyWordArr);
    foreach ($diffX as $newItem) {
        array_push($keyWordArr, $newItem);
    }
    return $keyWordArr;
};

$adjustedAlphabet1 = newAlphabet($alphabetArr, $keyWordArr);
var_dump($adjustedAlphabet1);

$inputString1 = 'estd mzzv esle elfrse xp szh ez ncplep yph topyetetpd hspy t hld l acp-eppy';
$inputString2 = 'max vhlm hy max unl wkboxk ingva b nlxw mh ingva fr hpg mktglyxkl';
$inputString3 = 'pbzfsobp dkfobtpkx lq pbkfi ppbkfpry aoxtolc iixz lq abpr bobt pbzfsba cl bmvq obail bpbeq';
$inputString4 = 'gsvmznvlugsnvzrmuiznvhrszxpvwzgfhxrmgsvzikzmvgwzbh';
$inputString5 = 'jbi ujt veo eco ntk iwa lhc eeo anu uir trs hae oni rfn irt toh imi ets shs !eu';
$inputString6 = 'dghvetpst bm ihvtl'; //test coded string with key = 'kryptos'
$inputString7 = '';
$inputString8 = '';
$inputString9 = '';


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
$inputStringArr1 = str_split($inputString1);
rotateDecypher($inputStringArr1, $alphabetArr);

echo '2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 x x x x x' . '<br>';
$inputStringArr2 = str_split($inputString2);
rotateDecypher($inputStringArr2, $alphabetArr);

echo '3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 3 x x x x' . '<br>';
$inputStringArr3 = str_split(strrev($inputString3));
rotateDecypher($inputStringArr3, $alphabetArr);

echo '4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 4 x x x x x' . '<br>';
$inputStringArr6 = str_split($inputString6);
substituteDecypher($inputStringArr6, $alphabetArr, $adjustedAlphabet1);

echo '5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 5 x x x x' . '<br>';

echo '6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 x x x x x' . '<br>';

?>



    