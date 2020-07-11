<?php
/*
 * This file is part of the jinyphp package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Html;

class Css
{
    /**
     * 싱글턴 
     */
    private static $_instance;
    public static function instance($arg=null)
    {
        if (!isset(self::$_instance)) {
            // 자기 자신의 인스턴스를 생성합니다.                
            self::$_instance = new self();
            return self::$_instance;
        } else {
            // 인스턴스가 중복
            return self::$_instance; 
        }
    }
    
}