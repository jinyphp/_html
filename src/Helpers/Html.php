<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jiny\html;

// 테그
if (!function_exists("div")) {
    function div($value) {
        return "<div>".$value."</div>";
    }
}

if (!function_exists("a")) {
    function a($value, $href) {
        return "<a href='$href'>".$value."</a>";
    }
}




// csrf 해쉬키 생성
if (!function_exists("csrf")) {
    function csrf($salt, $algo="sha1")
    {
        $csrf = \hash($algo,$salt.date("Y-m-d H:i:s"));
        $_SESSION['_csrf'] = $csrf;
        return $csrf;
    }
}

// csrf 해쉬키 생성
if (!function_exists("isCsrf")) {
    function isCsrf()
    {
        if(isset($_SESSION)) { // session_start 여부 확인
            if(isset($_POST['csrf']) && $_SESSION['_csrf'] == $_POST['csrf']) {
                $_SESSION['_csrf'] = null;
                return true;
            }
        }
        $_SESSION['_csrf'] = null;
        return false;        
    }
}



function form($body=null, $vars=[]) 
{
    return \Jiny\Html\Form::instance();
}

function table($data=null)
{
    $obj = \Jiny\Html\Table::instance();
    if ($data) $obj->setData($data);
    return $obj;
}

if (! function_exists('bootstrap')) {
    function bootstrap()
    {
        return \Jiny\Html\Bootstrap::instance();
    }
}

//////////////////

namespace jiny\html\from;

// 폼 시작요소
function start()
{
    echo \jiny\html\form()->start();
}

// 폼 종료요소
function end()
{
    echo "</form>";
}

function hidden($attr=[])
{
    $str = "<input type='hidden' ";
    $str .= ">";
}

/**
 * 
 */
namespace jiny\html\Table;

function build($attr=[])
{
    echo \jiny\html\table()->build($attr);
}

/**
 * 
 */
namespace jiny\html\form;
function build($attr=[])
{
    echo \jiny\html\form()->build($attr);
}
