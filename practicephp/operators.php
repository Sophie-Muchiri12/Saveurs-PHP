<?php

//String operator : to connect string together

$a = "hey";
$b = "world";

$c = $a ." ". $b; //concatinating strings
echo $c;

//arithmetic operator

echo "<br>";
echo 10 % 3;

echo "<br>";
echo 10 ** 3;

echo "<br>";
echo 10 * 3;

echo "<br>";
echo 10 / 3;

//BODMAS

echo "<br>";
echo (4 + 41) + 3  /8;


//assignment operators
echo "<br>";
$a = 2;
// $a = $a + 3;
echo $a += 3;

//comparison operators
echo "<br>";
$d = 2;
$e = 2;

if ($d == $e){
    echo "statement is true";
}

echo "<br>";
$f = 2;
$g = "2";

if ($f == $g){ //loose equal operator just check if the data is equal
    echo "statement true";
}

if ($f === $g){ //strict equal operator will check the data and data type
    echo "statement true";
}

echo "<br>";
$i = 2;
$h = 5;

if ($h != $i){
    echo "statement true";
}


echo "<br>";
$i = 2;
$h = 5;

if ($h > $i){
    echo "statement true";
}


//logical operators
