<?php

namespace app\facade;

use app\factory\VipzhuishuFactory;
use app\factory\XbiqugeFactory;

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


        if (strpos($url,"xbiquge" ) != false){
            $url = str_replace("https://www.xbiquge.la/","", $url);
            $bookId = str_replace(".html","", $url);
            return [new XbiqugeFactory(), $bookId];
        }


        throw new \Exception("解析url错误 规则不存在");
    }
}