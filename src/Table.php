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

class Table
{
    public function __construct()
    {
        // echo __CLASS__;
    }

    private $thead;
    public function setThead($arr)
    {
        $this->thead = "<thead>";
        $this->thead .= $this->th($arr);
        $this->thead .= "</thead>";

        return $this;
    }

    private function th(array $arr)
    {
        $str = "<tr>";
        foreach ($arr as $cell) {
            $str .= "<th>".$cell."</th>";
        }
        $str .= "</tr>";
        return $str;
    }

    private $tbody;
    public function setTbody($rows)
    {
        $this->tbody = "<tbody>";
        foreach ($rows as $arr) {
            $this->tbody .= $this->tr($arr);
        }        
        $this->tbody .= "</tbody>";

        return $this;
    }

    private function tr(array $arr)
    {
        $str = "<tr>";
        foreach ($arr as $key => $cell) {
            if (array_key_exists($key, $this->href)) {
                $link = $arr[ $this->href[$key] ];
                $uri = "/". explode("/",$_SERVER['REQUEST_URI'])[1] ."/".$link;
                $str .= "<td><a href='".$uri."'>".$cell."</a></td>";
            } else {
                $str .= "<td>".$cell."</td>";                
            }            
        }
        $str .= "</tr>";
        return $str;
    }

    private $href=[];
    public function setHref($key, $value)
    {
        $this->href[$key] = $value;
        return $this;
    }

    private $tfoot;
    public function setTfoot($str)
    {
        $this->tfoot = "<tfoot>";
        $this->tfoot .= $this->tr($arr);
        $this->tfoot .= "</tfoot>";

        return $this;
    }

    private $caption;
    public function SetCaption($str)
    {
        $this->caption = "<caption>".$str."</caption>";
        return $this;
    }




    private $class;
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    private $id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    private $header;
    public function setHeader($str)
    {
        $this->header = $str;
        return $this;
    }

    private $footer;
    public function setFooter($str)
    {
        $this->footer = $str;
        return $this;
    }

    public function __toString()
    {
        $body = $this->header;

        $body .= "<table";
        if($this->class) $body .= " class=\"".$this->class."\"";
        if($this->id) $body .= " class=\"".$this->id."\"";
        $body .= ">";
        $body .= $this->thead;
        $body .= $this->caption;
        $body .= $this->tbody;
        $body .= $this->tfoot;
        $body .= "</table>";

        $body .= $this->footer;

        return $body;
    }


    /**
     * 
     */
}