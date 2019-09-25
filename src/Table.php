<?php
namespace Module\Html;

class Table
{
    public function table($str, $attr=null)
    {
        return "<table ".$attr.">".$str."</table>";
    }

    public function caption($str)
    {
        return "<caption>".$str."</caption>";
    }

    public function thead($str)
    {
        return "<thead>".$str."</thead>";
    }

    public function tbody($str)
    {
        return "<tbody>".$str."</tbody>";
    }

    public function tfoot($str)
    {
        return "<tfoot>".$str."</tfoot>";
    }

    public function tr(array $arr)
    {
        $str = "<tr>";
        foreach ($arr as $cell) {
            $str .= "<td>".$cell."</td>";
        }
        $str .= "</tr>";
        return $str;
    }
}