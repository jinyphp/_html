<?php

namespace Jiny\Html;

class Semantic
{
    public function __construct()
    {
        // echo __CLASS__;
    }

    public function table($data, $class=null)
    {
        $tbody = $this->tbody($data);    
        $thead = $this->thead($data[0]);
        
        if($class) {
            $body = "<table class='$class'>";
        } else {
            $body = "<table>";
        }

        return $body.$thead.$tbody."</table>";
    }

    private function thead($arr)
    {
        $aa = "<thead><tr>";
        foreach($arr as $key => $value) {
            if(is_numeric($key)) continue;
            $aa .= "<td>$key</td>";
        }
        $aa .= "</tr></thead>";
        return $aa;
    }

    private function tbody($arr)
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


    public function p($string)
    {
        return "<p>".$string."</p>";
    }
    
}