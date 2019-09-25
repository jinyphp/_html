<?php
namespace Jiny\Html;

class TagList
{

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
}