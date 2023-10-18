<?php
//OVO RADI
$arr = ['1:15:14', '3:12:16', '7:04:05', '19:07:18', '5:38:51'];
usort($arr, function ($a, $b) {
    return strtotime($a) - strtotime($b);
});
//print_r($arr);
function process_something($a){
    $return = [];

    foreach($a as $b){
      // Some logic here
      $return[] = $something;
    }

    return $return;
}
//ovo radi!!!
$apps = [
    ['distance' => 'long', 'time' => 2],
    ['distance' => 'medium', 'time' => 1],
    ['distance' => 'long', 'time' => 3],
    ['distance' => 'medium', 'time' => 7],
    ['distance' => 'long', 'time' => 9]
];

$long = [];
$medium = [];

foreach ( $apps as $var ) {
    if ($var['distance'] == "long") {
        $long[] = $var['time'];
    } else {
        $medium[] = $var['time'];
    }
}

print_r($long);
print_r($medium);






//print_r(array_fill_keys($array1, $array2));