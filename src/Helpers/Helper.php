<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jiny;

if (! function_exists('htmlMarkup')) {
    function htmlMarkup()
    {
        return \Jiny\Html\Markup::instance();
    }
}

/**
 * css/scss
 */

if (!function_exists("html_get_contents")) {
    function html_get_contents($file, $vars=[]) :string
    {
        if(\file_exists($file)) {
            extract($vars); // 키명으로 변수화
            ob_start(); // 출력 버퍼링
            include($file);
            return ob_get_clean(); // 버퍼를 반환합니다.
        } else {
            echo $file."을 읽을 수 없습니다.";
            exit;
        }
        
    }
}

/**
 * css/scss
 */

if (! function_exists('css')) {
    function css()
    {
        return \Jiny\Html\css::instance();
    }
}

if (!function_exists(" css_get_contents")) {
    function css_get_contents($file, $vars=[]) :string
    {
        if(\file_exists($file)) {
            extract($vars); // 키명으로 변수화
            ob_start(); // 출력 버퍼링
            include($file);
            return ob_get_clean(); // 버퍼를 반환합니다.
        } else {
            echo $file."을 읽을 수 없습니다.";
            exit;
        }
    }
}

if (!function_exists("scss_file")) {
    // scss file 처리
    function scss_file($file, $vars=[]) 
    {
        if (\file_exists($file)) {
            $body = \file_get_contents($file);
            return \jiny\scss_contents($body);
        } else {
            echo $file." 파일을 읽을 수 없습니다.";
            exit;
        }
    }
}

if (!function_exists("scss_get_contents")) {
    // scss compiler
    function scss_get_contents($body, $vars=[]) 
    {
        return \Jiny\Html\Scss::instance()->compile($body);
    }
}