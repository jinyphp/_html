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