<?php


$prices = array('beer' => 15, 'suger' => 35, 'noodle' => 10);
$total = 0;

$abc = function($price, $title) use (&$total) {
    $total += $price;
};

echo $total;

array_walk($prices,$abc);

echo $total;
//$abc;
?>