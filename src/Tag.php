<?php

use \Jiny\Html;

class Tag
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


 



}