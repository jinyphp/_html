<?php
require "../../../../vendor/autoload.php";

$html = new \Jiny\Html\TagList;

$data = ['aaa','bbb','ccc'];
echo $html->ul($data);
