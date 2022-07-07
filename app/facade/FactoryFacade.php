<?php

namespace app\facade;

use app\factory\VipzhuishuFactory;

class FactoryFacade
{
    public static function parser($url): array
    {
        if (strpos($url,"vipzhuishu" ) != false){
            $url = str_replace("http://www.vipzhuishu.com/book/","", $url);
            $url = str_replace("https://www.vipzhuishu.com/book/","", $url);
            $bookId = str_replace(".html","", $url);
            return [new VipzhuishuFactory(), $bookId];
        }
        throw new \Exception("解析url错误 规则不存在");
    }
}