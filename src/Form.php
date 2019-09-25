<?php

namespace Jiny\Html;

class Form
{
    public $_name;
    public $_action;
    public $_method;

    public $_fields;

    public function __construct()
    {
        //echo __CLASS__;
    }


    public function group($title,$name,$value)
    {
        $str = "<div class=\"form-group\">";
        $str = "<label for=\"$name\">$title</label>";
        $str = "<input type=\"text\" name='$name' value='".$value."' class=\"form-control\" id=\"$name\">";
        $str = "</div>";

        return $str;
    }





    public function load($filename)
    {
        $f = file_get_contents($filename);
        $f = json_decode($f);

        if($f->name) $this->_name = $f->name;
        if($f->action) $this->_action = $f->action;
        if($f->method) $this->_method = $f->method;

        if($f->fields) {
            foreach($f->fields as $key => $ff) {
                $this->setField($key, new \Jiny\Html\Field($ff)); 
            }
        }       
    }


    public function label($name)
    {
        return "<label>".$name."</label>";
    }

    public function field()
    {

    }

    public function setField($key, $obj)
    {
        $this->_fields[$key] = $obj;
        return $this;
    }


    public function fieldset($el, $title=null)
    {
        if ($title) {
            $str = "<legend>".$title."</legend>";
        }         
        else {
            $str = "";
        }
        
        return "<fieldset>".$str.$el."</fieldset>";
    }

    public function __toString()
    {
        $form = "<form";
        if ($this->_name) $form .= " name='".$this->_name."'";
        if ($this->_action) $form .= " action='".$this->_action."'";
        if ($this->_method) $form .= " method='".$this->_method."'";
        $form .= ">";

        if ($this->_fields) {
            $form .= "<ul>";
            foreach ($this->_fields as $key => $obj) {
                if ($obj->_title) {
                    $form .= "<li>".$this->label($obj->_title).$obj."</li>";
                } else {
                    $form .= "<li>".$obj."</li>";
                }   
            }
            $form .= "</ul>";
        }
        
        return $form."</form>";
    }

}