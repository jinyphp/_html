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

class Markup
{
    /**
     * 싱글턴 
     */
    private static $_instance;
    public static function instance($arg=null)
    {
        if (!isset(self::$_instance)) {
            // 자기 자신의 인스턴스를 생성합니다.                
            self::$_instance = new self($arg);
            return self::$_instance;
        } else {
            // 인스턴스가 중복
            return self::$_instance; 
        }
    }


    /**
     * 테이블 객체
     */
    private $_table;
    public function table($rows=null)
    {
        if(!isset($this->_table)) {
            $this->_table = \jiny\factory("\Jiny\Html\Table", $rows);
        }
        return $this->_table;
    }

    /**
     * 폼 객체
     */
    private $_form;
    public function form($rows=null)
    {
        if(!isset($this->_form)) {
            $this->_form = \jiny\factory("\Jiny\Html\Form");
        }
        return $this->_form;
    }


    /**
     * 테그
     */

    public function a($args)
    {
        if(is_string($args)) {
            return "<a href='#'>$args</a>";
        } else {
            $code = "<a";
            foreach ($args as $key => $value) {
                if ($key=="value") continue;
                $code .= " $key='$value'";
            }
            $code .= ">";
            $code .= $args['value'];
            $code .= "</a>";
        }

        return $code;        
    }

    public function h1($msg)
    {
        return "<h1>".$msg."</h1>";
    }

    public function h2($msg)
    {
        return "<h2>".$msg."</h2>";
    }

    public function h3($msg)
    {
        return "<h3>".$msg."</h3>";
    }

    public function h4($msg)
    {
        return "<h4>".$msg."</h4>";
    }

    public function h5($msg)
    {
        return "<h5>".$msg."</h5>";
    }

    public function h6($msg)
    {
        return "<h6>".$msg."</h6>";
    }

    /**
     * 본문테그
     */
    public function p($msg)
    {
        return "<p>".$msg."</p>";
    }

    /**
     * 문단 구분
     */
 
    public function br()
    {
        return "<br>";
    }

    public function hr()
    {
        return "<hr>";
    }

    public function ul($data)
    {
        $string = "<ul>";
        $string .= $this->li($data);
        $string .= "</ul>";

        return $string;
    }

    public function ol($data)
    {
        $string = "<ol>";
        $string .= $this->li($data);
        $string .= "</ol>";

        return $string;
    }

    private function li($data)
    {
        $string = "";
        foreach ($data as $d)
        {
            $string .= "<li>";
            
            if(is_array($d)) $string .= $this->ul($d);
            else $string .= $d;

            $string .= "</li>";
        }
        return $string;
    }


    private $_script;
    public function script()
    {
        if(!isset($this->_script)) {
            $this->_script = \jiny\factory("\Jiny\Html\Script");
        }
        return $this->_script;
    }

    /**
     * 
     */
}