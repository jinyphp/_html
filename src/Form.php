<?php

namespace Jiny\Html;

class Form
{
    private $name;
    private $action;
    private $method;
    private $header;
    private $footer;

    // 폼이름 설정
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    // 폼 동작엑션 설정
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    // 폼 메소드 설정
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setHeader($str)
    {
        $this->header = $str;
        return $this;
    }

    public function setFooter($str)
    {
        $this->footer = $str;
        return $this;
    }

    
    
    // 폼 빌드
    public function build()
    {
        if(isset($this->header)) $body = $this->header;

        $body = "<form";
        if ($this->name) $body .= " name='".$this->name."'";
        if ($this->action) $body .= " action='".$this->action."'";
        if ($this->method) $body .= " method='".$this->method."'";
        $body .= ">";

        if (\jiny\arr\isAssoc($this->fields)) {
            $body .= $this->make_ul($this->fields);
        } else {
            $body .= $this->make($this->fields);
        }
        
        $body .= "</form>";

        if(isset($this->footer)) $body .= $this->footer;

        return $body;
    }

    public function __toString()
    {
        return $this->build();
    }


    private function make($fields)
    {
        foreach ($fields as $key => $obj) {
            $body .= $obj;               
        }
        return $body;
    }

    private function make_ul($fields)
    {
        $body = "<ul>";
        foreach ($fields as $key => $obj) {
            if(is_string($obj)) {
                $body .= "<li>".$obj."</li>";
            }                 
        }
        $body .= "</ul>";
        return $body;
    }


    public $fields;
    public function setField($args)
    {
        if(is_string($args)) {
            $this->fields []= $args;
        } else {
            foreach($args as $key => $value)
            {
                $this->fields[$key] = $value;
            }
        }
        return $this;
    }













    /**
     * 폼 구성요소
     */
    private function itemTemplate($args, $template=null)
    {
        // 실행 스크립트의 상위 경로
        $path = dirname(getcwd()).DIRECTORY_SEPARATOR."resource".DIRECTORY_SEPARATOR.$template; 
        return \jiny\template($path, $args);
    }

    public function submit($args, $template=null)
    {
        if($template) {
            // 템플릿 응용
            return $this->itemTemplate($args, $template=null);
            
        } else {
            extract($args);
            // 서브밋
            $code = "<input type='submit'";
            if(isset($class)) $code .= " class='".$class."'";
            if(isset($id)) $code .= " id='".$id."'";
            if(isset($value)) $code .= " value='".$value."'";
            $code .= "/>";
        }

        return $code;
    }

    public function button($args, $template=null)
    {
        if($template) {
            // 템플릿 응용
            // 템플릿 응용
            return $this->itemTemplate($args, $template=null);
            
        } else {
            extract($args);
            // 버튼빌드
            $code = "<button type='button'";
            foreach ($args as $key => $value) {
                if($key == "value") continue;
                $code .= " $key='".$value."'";
            }
            /*
            if(isset($name)) $code .= " name='".$name."'";
            if(isset($class)) $code .= " class='".$class."'";
            if(isset($id)) $code .= " id='".$id."'";
            */
            $code .= ">";

            if(isset($args['value'])) $code .= $args['value'];

            $code .= "</button>";
        }

        return $code;
    }

    public function hidden($args, $template=null)
    {
        if($template) {
            // 템플릿 응용
            // 템플릿 응용
            return $this->itemTemplate($args, $template=null);
            
        } else {
            extract($args);
            // hidden
            $code = "<input type='hidden'";
            if(isset($name)) $code .= " name='".$name."'";
            if(isset($id)) $code .= " id='".$id."'";
            if(isset($value)) $code .= " value='".$value."'";
            $code .= "/>";
        }

        return $code;
    }


    /**
     * postdata
     */

    public function mode()
    {
        if(isset($_POST['mode'])) return $_POST['mode'];
    }

    public function id()
    {
        if(isset($_POST['id'])) return intval($_POST['id']);
    }

    public function data()
    {
        if(isset($_POST['postdata'])) return intval($_POST['postdata']);
    }




    /**
     * 
     */

    public function label($name, $for)
    {
        $body = "<label";
        if($for) $body .= "for=\"idiom\"";
        $body .= ">";
        return $body.$name."</label>";
    }


  


    public function formGroup($label, $input)
    {
        $body = "<div class=\"form-group\">";
        $body .= $label;
        $body .= $input;
        $body .= "</div>";
        return $body;
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

    /**
     * 
     */

}