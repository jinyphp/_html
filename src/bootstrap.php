<?php

namespace Jiny\Html;

use \Jiny\Html\Semantic;

class Bootstrap extends Semantic
{

    public function __construct($ctl = null)
    {

    }

    public function tableResponsive($str)
    {
        return "<div class='table-responsive'>".$str."</div>";
    }
    
    public function tableHover($data, $body=null, $class=null)
    {
        $str = "";
        if (isset($body['title'])) $str .= $body['title'];
        if (isset($body['descript'])) $str .= $body['descript'];

        if (isset($body['header'])) $str .= $body['header'];
        
        $class['type'] = "table table-hover";

        $str .= $this->table($data, $class);

        if (isset($body['footer'])) $str .= $body['footer'];
        
        return $str;
    }

    /**
     * 버튼
     */

    public function butten($name, $attr)
    {
        extract($attr);
        $str = "<button type='button'";

        if (isset($align)) {
            if ($align == 'right') $align= " float-right";
        } else $align = "";

        if (isset($type)) {
            $str .= " class='btn $type $align'";
        }

        if (isset($id)) {
            $id = " id='$id'";
        }

        /*
        if ($path) {
            $click = "onclick=\"location.href='$path'\"";
        } else $click = "";
        */

        return $str." $id>".$name."</button>";
    }

    public function btnPrimary($name, $path=null, $align=null )
    {
        // float-right : 오른쪽 정렬
        if ($align == 'right') $align = "float-right";
        else $align = "";

        if ($path) {
            $click = "onclick=\"location.href='$path'\"";
        } else $click = "";
        

        return "<button type='button' class='btn btn-primary ".$align."' $click>".$name."</button>";
    }

    public function pagenation($arr, $limit=null)
    {
        $str = "<ul class='pagination'>";
        foreach($arr as $key => $value)
        {
            if($value == $limit) {
                $str .= "<li class='page-item active'><a class='page-link' href='?limit=".$value."'>".$key."</a></li>";
            } else {
                $str .= "<li class='page-item'><a class='page-link' href='?limit=$value'>$key</a></li>";
            }
        }

        $str .= "</ul>";
        return $str;
    }

    
    /**
     * 점보트론
     */

    public function jumboTron($str, $fluid=null)
    {
        if ($fluid) {
            return "<div class='jumbotron jumbotron-fluid'>".$str."</div>";
        } else {
            return "<div class='jumbotron'>".$str."</div>";
        }        
    }

    /**
     * 이미지
     */

    public function image($src, $align=null)
    {
        if ($align == 'right') {
            $class = "float-right";
        } else if ($align == 'center') {
            $class = "mx-auto d-block";
        } else {
            $class = "float-left";
        }

        return "<img src='$src' class='$class'>";
    }


    /**
     * form
     */

    public function form($name, $action, $fields)
    {
        return "<form name='$name' action='$action'></form>";
    }



    public function submit($title)
    {
        return "<button type='submit' class='btn btn-primary'>".$title."</button>";
    }


    /**
     * input
     */

    public function input($type, $name, $label)
    {
        return "<div class='form-group'>
         <label for='$name'>$label</label>
         <input type='$type' name='$name' class='form-control' id='$email'>
       </div>";
    }

    public function inputInline($type, $name, $label)
    {
        return "<label for='$name'>$label</label>
        <input type='$type' class='form-control' id='$name'>";
    }



    /**
     * 
     */

}