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

class Tags
{
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

    /**
     * 앵커 테그
     */

    public function a($text, $href="#")
    {
        return "<a href='$href'>".$text."</a>";
    }

    /**
     * 
     */

}