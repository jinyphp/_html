<?php
require "../../../../vendor/autoload.php";

$html = new \Jiny\Html\TagList;

$data = [
    'aaa',
    [
        'a','b','c'
    ],
    'ccc'
];
echo $html->ul($data);
