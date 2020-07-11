<?php
require "vendor/autoload.php";

use ScssPhp\ScssPhp\Compiler;

$scss = \jiny\scss_file("test.scss");
echo $scss;