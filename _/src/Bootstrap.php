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

class Bootstrap
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

    /**
     * alert
     */
    public function alertPrimary($msg)
    {
        return "<div class='alert alert-primary' role='alert'>".$msg."</div>";
    }

    public function alertSecondary($msg)
    {
        return "<div class='alert alert-secondary' role='alert'>".$msg."</div>";
    }

    public function alertSuccess($msg)
    {
        return "<div class='alert alert-success' role='alert'>".$msg."</div>";
    }

    public function alertDanger($msg)
    {
        return "<div class='alert alert-danger' role='alert'>".$msg."</div>";
    }

    public function alertWarning($msg)
    {
        return "<div class='alert alert-warning' role='alert'>".$msg."</div>";
    }

    public function alertInfo($msg)
    {
        return "<div class='alert alert-info' role='alert'>".$msg."</div>";
    }

    public function alertLight($msg)
    {
        return "<div class='alert alert-light' role='alert'>".$msg."</div>";
    }

    public function alertDark($msg)
    {
        return "<div class='alert alert-dark' role='alert'>".$msg."</div>";
    }

    /**
     * button
     */
    public function button($msg, $attr=[])
    {
        $str = "<button ";
        isset($attr['type']) ? :$attr['type'] = "button";
        foreach ($attr as $key => $value) {
            $str .= $key."='".$value."' ";
        }
        $str .= ">".$msg."</button>";
        return $str;
    }

    private function buttonA($msg, $href="#")
    {
        return "<a class='btn btn-primary' href='".$href."' role='button'>".$msg."</a>";
    }

    public function submitButtonPrimary($msg)
    {
        return $this->button($msg, ['type'=>"submit",'class'=>"btn btn-primary"]);
    } 
    /*
    <button type="button" class="btn btn-secondary">Secondary</button>
    <button type="button" class="btn btn-success">Success</button>
    <button type="button" class="btn btn-danger">Danger</button>
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-light">Light</button>
    <button type="button" class="btn btn-dark">Dark</button>

    <button type="button" class="btn btn-link">Link</button>
    */
}