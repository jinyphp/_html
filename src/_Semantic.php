<?php

namespace Jiny\Html;

class Semantic
{
    public function __construct($ctl = null)
    {

    }

    public function table($data, $class=null)
    {
        $tbody = $this->tbody($data, $class);    
        $thead = $this->thead($data[0], $class);
        
        if(isset($class['type'])) {
            $str = "<table class='".$class['type']."'>";
        } else {
            $str = "<table>";
        }

        return $str.$thead.$tbody."</table>";
    }

    // thead-dark, thead-light
    public function thead($arr, $class=null)
    {
        
        if (isset($class['thead'])) {
            $str = "<thead class='".$class['thead']."'>";
        } else {
            $str = "<thead>";
        }

        $str .= "<tr>";
        foreach($arr as $key => $value) {
            if(is_numeric($key)) continue;
            $str .= "<th>".$key."</th>";
        }
        $str .= "</tr>
        </thead>";

        return $str;
    }

    public function tbody($arr, $class=null)
    {
        $str = "";
        foreach ($arr as $a) {
            $str .= "<tr>";
            foreach ($a as $key => $value) {
                if(is_numeric($key)) continue;
                $str .= "<td class='$key'>".$value."</td>";
                $head[$key] = "";
            }
            $str .= "</tr>";
        }

        return "<tbody>".$str."</tbody>";
    }



    public function p($str)
    {
        return "<p>".$str."</p>";
    }

    public function h1($string)
    {
        return "<h1>".$string."</h1>";
    }

    public function h2($string)
    {
        return "<h2>".$string."</h2>";
    }

    public function h3($string)
    {
        return "<h3>".$string."</h3>";
    }

    public function h4($string)
    {
        return "<h4>".$string."</h4>";
    }

    public function h5($string)
    {
        return "<h5>".$string."</h5>";
    }

    public function h6($string)
    {
        return "<h6>".$string."</h6>";
    }

    /**
     * 
     */
}