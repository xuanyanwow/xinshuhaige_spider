<?php

namespace app\i;

interface FactoryInterface
{
    public static function buildListUrl($bookId, $i):string;
    public static function buildListRange():string;
    public static function buildListRules():array;
    public static function buildContentRules():array;
    public static function buildContentPagesUrl($originUrl, $page):string;
    /** 是否需要js执行 */
    public static function needJS():bool;
    /** 同一章是否需要翻页,返回翻页数量 */
    public static function needPages():int;

    /** 解析入redis执行之前 可以优化url等信息 */
    public static function beforeAddLinkToJob(&$one, $url);
}