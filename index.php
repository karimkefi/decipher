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

// http://practicalcryptography.com/ciphers/simple-substitution-cipher/
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


function asciDecipher($encryptedString) {
    $decodedArr = [];

    foreach ($encryptedString as $inputletter) {
        if($inputletter == " ") {
            $decodedArrAll = array_push($decodedArr, " ");
            continue;
        };
        $charFound = chr(ord($inputletter) + 62) ;
        array_push($decodedArr, $charFound);
    }

    $decodedString = implode("", $decodedArr);
    return $decodedString;
}

//takes a string, removes spaces and returns an array of pairs (padded if odd number with "q")
function convertIntoArrayOfPairs($inputString) {
    $pairArr = [];

    $inputString = str_replace(" ", "", $inputString);
    $inputStringArr = str_split($inputString);

    if(count($inputStringArr)%2 != 0) {
        array_push($inputStringArr, "q");
    };

    for ($i=0; $i < count($inputStringArr); $i++) {
        array_push($pairArr, [$inputStringArr[$i],$inputStringArr[$i +1]]);
        $i++;
    }

    return $pairArr;
}

//find coordinates with given pair and alphabet matrix
function findCoordinates($pairArr, $matrix) {
    $result = [];

    foreach($pairArr as $item) {
        foreach($matrix as $key=>$value) {
            if(array_search($item, $value) !== false) {
                array_push($result, [$key ,array_search($item, $value)]);
            }
        }
    }

    return $result;
}

function checkMax($value, $maxVal){
    if($value > $maxVal) {
        $value = 0;
    }
    return $value;
}

//function creates a encrypted string from plain text string using a matrix table and rules:
//https://en.wikipedia.org/wiki/Playfair_cipher
function createPlayfairCipher($inputArray, $alphabetMatrix) {
    $encodedPairArr = [];
    $encodedStringPair = '';
    $x = 0;

    //find coordinates of characters [A,B] in the alphabet matrix [[r,c],[r,c]]
    foreach ($inputArray as $pairArr) {
        $coords = findCoordinates($pairArr, $alphabetMatrix);

        //apply rules (switch statement) to return cipher pairs
        $scenario = "";
        if($coords[0][0] == $coords[1][0]) {
            //same row
            $scenario = "sameRow";

            //if the coordinate + 1 is beyond the end of a row
            if($coords[0][1]+1 > 4) {
                $coords[0][1] = -1;
            } elseif($coords[1][1]+1 > 4 ) {
                $coords[1][1] = -1;
            }

            array_push($encodedPairArr, [$alphabetMatrix[$coords[0][0]][$coords[0][1]+1], $alphabetMatrix[$coords[1][0]][$coords[1][1]+1]]);
            $encodedStringPair = $encodedStringPair . ' ' . implode("" ,$encodedPairArr[$x]);

        } elseif ($coords[0][1] == $coords[1][1]) {
            //same column
            $scenario = "sameColumn";

            //if the coordinate + 1 is beyond the end of a column
            if($coords[0][0]+1 > 4) {
                $coords[0][0] = -1;
            } elseif($coords[1][0]+1 > 4 ) {
                $coords[1][0] = -1;
            }

            array_push($encodedPairArr, [$alphabetMatrix[$coords[0][0]+1][$coords[0][1]], $alphabetMatrix[$coords[1][0]+1][$coords[1][1]]]);
            $encodedStringPair = $encodedStringPair . ' ' . implode("" ,$encodedPairArr[$x]);

        } else {
            //rectangle
            $scenario = "rectangle";
            array_push($encodedPairArr, [$alphabetMatrix[$coords[0][0]][$coords[1][1]], $alphabetMatrix[$coords[1][0]][$coords[0][1]]]);
            $encodedStringPair = $encodedStringPair . ' ' . implode("" ,$encodedPairArr[$x]);
        }
        $x++;
    }

    return $encodedStringPair;
}

//function decrypted string from using a matrix table and rules:
//https://en.wikipedia.org/wiki/Playfair_cipher
//
function playfairDecipher($inputArray, $alphabetMatrix) {
    $decodedPairArr = [];
    $decodedStringPair = '';
    $x = 0;

    //find coordinates of characters [A,B] in the alphabet matrix [[r,c],[r,c]]
    foreach ($inputArray as $pairArr) {
        $coords = findCoordinates($pairArr, $alphabetMatrix);

        //apply rules (switch statement) to return cipher pairs
        $scenario = "";
        if($coords[0][0] == $coords[1][0]) {
            //same row
            $scenario = "sameRow";

            //if the coordinate + 1 is beyond the end of a row
            if($coords[0][1]-1 < 0) {
                $coords[0][1] = 5;
            } elseif($coords[1][1]-1 < 0) {
                $coords[1][1] = 5;
            }

            array_push($decodedPairArr, [$alphabetMatrix[$coords[0][0]][$coords[0][1]-1], $alphabetMatrix[$coords[1][0]][$coords[1][1]-1]]);
            $decodedStringPair = $decodedStringPair . implode("" ,$decodedPairArr[$x]);

        } elseif ($coords[0][1] == $coords[1][1]) {
            //same column
            $scenario = "sameColumn";

            //if the coordinate + 1 is beyond the end of a column
            if($coords[0][0]-1 < 0) {
                $coords[0][0] = 5;
            } elseif($coords[1][0]-1 < 0) {
                $coords[1][0] = 5;
            }

            array_push($decodedPairArr, [$alphabetMatrix[$coords[0][0]-1][$coords[0][1]], $alphabetMatrix[$coords[1][0]-1][$coords[1][1]]]);
            $decodedStringPair = $decodedStringPair . implode("" ,$decodedPairArr[$x]);

        } else {
            //rectangle
            $scenario = "rectangle";
            array_push($decodedPairArr, [$alphabetMatrix[$coords[0][0]][$coords[1][1]], $alphabetMatrix[$coords[1][0]][$coords[0][1]]]);
            $decodedStringPair = $decodedStringPair . implode("" ,$decodedPairArr[$x]);
        }
        $x++;
    }

    return $decodedStringPair;
}



//-------ENCODED AND DECIPHERED --------------------------------------------

echo '- - - - - - - SIMPLE ROT (Life of Brian)- - - - - - - - - ' . '<br>';
$inputString1 = 'kh lv qrw wkh phvvldkd kh lv d yhub qdxjkwb erb';
$inputStringArr1 = str_split($inputString1);
rotateDecypher($inputStringArr1, $alphabetArr);

echo '- - - - - - - ROT AND REV (This is Spinal Tap)- - - - - - - - - ' . '<br>';
//$inputString2 = 'borzsm fob nxk dyb k cs csrd';
$inputString2 = 'dulubu ej fk ew uiuxj';
$inputStringArr2 = str_split(strrev($inputString2));
rotateDecypher($inputStringArr2, $alphabetArr);

echo '- - - - - - - SUBSTITUTE CIPHER (WITH KEY) - - - - - - - - -' . '<br>';
//create a function to encode with substitute cipher
//...
//...
//...
//test coded string with keyWord
$inputString3 = 'xhql fhnatl vkm k akfmntl kgp xhql oknatl mften ho teptlrtllbtm';
$inputStringArr3 = str_split($inputString3);
echo substituteDecypher($inputStringArr3, $alphabetArr, $adjustedAlphabet1) . '<br>';

echo '- - - - - - - ASCII CIPHER (Dr Strangelove) - - - - - - - - -' . '<br>';
//move from Capital to lower case ascii
$inputString4 = ")'06.'/'0 ;17 %#0016 (+)*6 +0 *'4' 6*+5 +5 6*' 9#4 411/";
$inputStringArr4 = str_split($inputString4);
echo asciDecipher($inputStringArr4) . '<br>';

echo '- - - - - - - PLAYFAIR: CREATING THE CIPHER OF LETTERS - - - - - - - - -' . '<br>';
//cipher some string
$inputString5 = 'that rug really tied the room together did it not';
$inputStringArr5 = convertIntoArrayOfPairs($inputString5);
$cipher = createPlayfairCipher($inputStringArr5,$alphabetMatrix);
echo $cipher . '<br>';

//run the cipher over the digraphs (pairs of values)

echo '- - - - - - - PLAYFAIR: DECIPHERING THE CIPHER OF LETTERS (The Big Lebowski) - - - - - - - - -' . '<br>';
//decipher string
$inputString6 = 'si dq sq mw ab mm dy kd iy kc tm pn yt kb si bu io io so ty';
$inputStringArr6 = convertIntoArrayOfPairs($inputString6);
//run the decipher over the digraphs (pairs of values)
//implode into a string
$decipher = playfairDecipher($inputStringArr6,$alphabetMatrix);
echo $decipher . '<br>';

?>
