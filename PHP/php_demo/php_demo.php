<?php 
$weights = [2 , 5 , 7];
$range = array_sum($weights);
$needle = 0;
$start = 1;
$rand = mt_rand($start, $range);
foreach ($weights as $weight) {
    if ($rand <= ($weight + $start - 1)) break;
    $start = $start + $weight;
    $needle++;
}
var_dump($needle);
