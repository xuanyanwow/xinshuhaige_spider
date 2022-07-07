<?php

$path = __DIR__."/../store/我有一座恐怖屋/";
$newFile = __DIR__."/../store/我有一座恐怖屋.txt";

function siam_sort($a, $b){
    return (int) $a> (int) $b ? 1: -1;
}

$array = scandir($path, SORT_NUMERIC);
usort($array, 'siam_sort');
foreach ($array as $filepath){
    if (in_array($filepath,['.','..'])) continue;
    $origin = file_get_contents($path.$filepath);
    $origin = str_replace("亲,点击进去,给个好评呗,分数越高更新越快,据说给新笔趣阁打满分的最后都找到了漂亮的老婆哦!手机站全新改版升级地址：https://wap.xbiquge.la，数据和书签与电脑站同步，无广告清新阅读！", "", $origin);
    file_put_contents($newFile, $origin, FILE_APPEND);
}

echo "拼接成功";

