<?php
const BR = '<br>';

// 1. count();
$arr = ['fox', 'bear', 'dog', 'cat', 'dog', 'wolf', ['Alf', 'Bolt'] , 'deer'];
echo "count(arr): " . count($arr) . BR;
echo "count(arr, COUNT_RECURSIVE): " . count($arr, COUNT_RECURSIVE) . BR;

// 2. is_array
echo "is_array():" . is_array($arr) .BR;

// 3. substr()
$name = "mike";

echo "substr(): " . BR;
echo (substr($name, -1) === 'a') ? "You are lady" : "You are gentelman";
echo BR;

// 3.5 ucfirst()

echo "ucfirst(): " . ucfirst($name) . BR;

// 4. in_array()
echo "in_array(): " . in_array('dog', $arr) . BR;

// 4.5 array_search()
echo "array_search(): " . array_search('dog', $arr) .BR;

