<?php

namespace Jiny\Html;

class Form
{
    public function __construct($attr=null)
    {
        if ($attr) {
            if(isset($attr['name']) && $attr['name']) $this->setName($attr['name']);
            if(isset($attr['action']) && $attr['action']) $this->setAction($attr['action']);
            if(isset($attr['method']) && $attr['method']) $this->setMethod($attr['method']);
        }
    }

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

    private $method="post";
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

    private $formBody;
    public function setFormBody($string)
    {
        $this->formBody = $string;
        return $this;
    }

    public function __toString()
    {
        $body = $this->header;

        $body = "<form";
        if ($this->name) $body .= " name='".$this->name."'";
        if ($this->action) $body .= " action='".$this->action."'";
        if ($this->method) $body .= " method='".$this->method."'";
        $body .= ">";
        
        if ($this->formBody) {
            // 폼삽입
            $body .= $this->formBody;
        } else {
            // 폼빌드
            $body .= $this->items();
        }
        
        
        $body .= "</form>";

        $body .= $this->footer;

        return $body;
    }

    //////////-//////////

    public function formJsonBuilder($filename)
    {
        $formJson = $this->formJson($filename);
        $formBody = $this->formJsonParser($formJson);

        $this->formBody = $formBody;
        return $this;
    }

    public function formJson($filename)
    {
        $formJson = file_get_contents($filename);
        return json_decode($formJson);
    }

    public function formJsonParser($json)
    {
        $formitem = new \Jiny\Html\FormItem;        
        $str = "";
        foreach ($json as $name => $item) {
            $str .= $formitem->name($name)->formGroup($item);
        }

        return $str;
    }


    //////////-//////////


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

    /**
     * 
     */

}