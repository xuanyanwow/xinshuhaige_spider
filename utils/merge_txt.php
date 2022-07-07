<?php

$path = __DIR__."/../store/三寸人间/";
$newFile = __DIR__."/../store/三寸人间.txt";

function siam_sort($a, $b){
    return (int) $a> (int) $b ? 1: -1;
}

$array = scandir($path, SORT_NUMERIC);
usort($array, 'siam_sort');
foreach ($array as $filepath){
    if (in_array($filepath,['.','..'])) continue;
    file_put_contents($newFile, file_get_contents($path.$filepath), FILE_APPEND);
}

echo "拼接成功";

