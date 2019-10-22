<?php

namespace Jiny\Html;

class Form
{
    private $name;
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    private $action;
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    private $method;
    public function setMethod($method)
    {
        $this->method = $method;
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

    
    public $fields;
    public function setField($key, $obj)
    {
        $this->fields[$key] = $obj;
        return $this;
    }

    public function label($name, $for)
    {
        $body = "<label";
        if($for) $body .= "for=\"idiom\"";
        $body .= ">";
        return $body.$name."</label>";
    }

    private function fields($fields)
    {
        $body = "<ul>";
        foreach ($fields as $key => $obj) {
            if(is_string($obj)) {
                $body .= "<li>".$obj."</li>";
            } else if(is_object($obj)) {
                if ($obj->title) {
                    $body .= "<li>".$this->label($obj->title).$obj."</li>";
                } else {
                    $body .= "<li>".$obj."</li>";
                } 
            }                  
        }
        $body .= "</ul>";
        return $body;
    }


    public function __toString()
    {
        $body = $this->header;

        $body = "<form";
        if ($this->name) $body .= " name='".$this->name."'";
        if ($this->action) $body .= " action='".$this->action."'";
        if ($this->method) $body .= " method='".$this->method."'";
        $body .= ">";

        $body .= $this->fields($this->fields);
        
        $body .= "</form>";

        $body .= $this->footer;

        return $body;
    }


    public function formGroup($label, $input)
    {
        $body = "<div class=\"form-group\">";
        $body .= $label;
        $body .= $input;
        $body .= "</div>";
        return $body;
    }




    
    


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


    public function load($filename)
    {
        $f = file_get_contents($filename);
        $f = json_decode($f);

        if($f->name) $this->name = $f->name;
        if($f->action) $this->action = $f->action;
        if($f->method) $this->method = $f->method;

        if($f->fields) {
            foreach($f->fields as $key => $ff) {
                $this->setField($key, new \Jiny\Html\Field($ff)); 
            }
        }       
    }

    /**
     * 
     */

}