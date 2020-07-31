<?php

namespace Jiny\Html;

class Form
{
    private $name;
    private $action;
    private $method = "POST";
    private $header;
    private $footer;

    private $fields=[];

    /**
     * 싱글턴
     */
    public static $_instance;

    public static function instance($args=null)
    {
        if (!isset(self::$_instance)) {        
            //echo "객체생성\n";
            // print_r($args);   
            self::$_instance = new self($args); // 인스턴스 생성
            if (method_exists(self::$_instance,"init")) {
                self::$_instance->init();
            }
            return self::$_instance;
        } else {
            //echo "객체공유\n";
            return self::$_instance; // 인스턴스가 중복
        }
    }

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

    public function start()
    {
        $body = "<form";
        if ($this->name) $body .= " name='".$this->name."'";
        if ($this->action) $body .= " action='".$this->action."'";
        if ($this->method) $body .= " method='".$this->method."'";
        $body .= ">";

        return $body;
    }

    public function end()
    {
        return "</form>";
    }

    // 폼 빌드
    public function build()
    {
        if(isset($this->header)) $body = $this->header;

        $body = $this->start();

        foreach ($this->fields as $key => $value) {
            $body .= $value;
        }       
        
        $body .= "</form>";

        if(isset($this->footer)) $body .= $this->footer;
        return $body;
    }

    public function setFields($args=[])
    {
        //print_r($args);
        foreach ($args as $value) {
            $this->input($value['type'], $value);
        }
        return $this;
    }

    /*
    private function elBuild()
    {
        $body .= "<ul>";
        foreach ($this->fields as $key => $value) {
            $body .= "<li>".$value."</li>";
        }
        $body .= "</ul>";
    }
    */


    public function __toString()
    {
        return $this->build();
    }

    public function label($title, $for=null)
    {
        if ($for) {
            return "<label for='".$for."'>".$title."</label>";
        } else {
            return "<label>".$title."</label>";
        }        
    }

    public function fieldset($el, $title=null)
    {
        if ($title) {
            return "<fieldset>"."<legend>".$title."</legend>".$el."</fieldset>";
        } else {
            return "<fieldset>".$el."</fieldset>";
        }       
    }

    private function attribute($args)
    {
        $code = "";
        $hidden = false;
        foreach ($args as $key => $value) {
            if($key == "type" && $value == "hidden") $hidden = true;
            if (empty($value)) {
                // 단일속성, 키값만 지정함
                $code .= " ".$key; 
            } else {
                if(!$hidden && $key == "name") {
                    $code .= " ".$key."='data[".$value."]'";
                } else {
                    $code .= " ".$key."='".$value."'";
                }                
            }            
        }
        return $code;
    }

    /**
     * input 요소생성
     */
    public function input($type, $args, $code=false) :string
    {
        // 라벨 생성
        if (isset($args['label'])) {
            if (!isset($args['id'])) $args['id'] = "label-".$args['name']; // 강제 id생성
            $label = $this->label($args['label'], $args['id']);
            unset($args['label']);
        } else {
            $label = "";
        }

        // 요소 생성
        $code = "<input ";
        $args['type'] = $type;
        $args = array_reverse($args);
        $code .= $this->attribute($args); // 요소루프
        $code .= "/>";

        if (isset($args['name'])) {
            $key = $args['name'];
            $this->fields[$key] = "<div>".$label.$code."</div>";
        } else {
            $this->fields []= "<div>".$label.$code."</div>";
        }

        if ($code) {
            return $label.$code;
        } else {
            return $this;
        }        
    }

    public function hidden($args, $code=false) 
    {
        return $this->input("hidden", $args);
    }

    public function text($args, $code=false) 
    {
        return $this->input("text", $args);
    }

    public function password($args, $code=false) 
    {
        return $this->input("password", $args);
    }

    public function submit($args, $code=false) 
    {
        return $this->input("submit", $args);
    }

    public function reset($args, $code=false) 
    {
        return $this->input("reset", $args);
    }

    public function image($args, $code=false) 
    {
        return $this->input("image", $args);
    }

    public function button($args, $code=false) 
    {
        return $this->input("button", $args);
    }

    public function checkbox($args, $code=false)
    {
        return $this->input("checkbox", $args);
    }

    public function radio($args, $code=false)
    {
        $body = "";
        foreach ($args as $radio) {
            $body .= $this->input("radio", $args, true);
        }
        $this->fields []= $body;
        return $body;
    }

    public function select($args, $code=false)
    {

    }

    public function textarea($args, $code=false)
    {

    }

    /**
     * output 테그 : 계산결과 출력형식
     */
    public function output($args, $code=false)
    {

    }

    public function progress($args, $code=false)
    {

    }

    public function meter($args, $code=false)
    {

    }


    /**
     * text 타입 html5 속성
     */
    public function color($args, $code=false) 
    {
        return $this->input("color", $args);
    }

    public function date($args, $code=false) 
    {
        return $this->input("date", $args);
    }

    public function datetime($args, $code=false)
    {
        return $this->input("datetime", $args);
    }

    public function datetimeLocal($args, $code=false)
    {
        return $this->input("datetime-local", $args);
    }

    /**
     * html5
     */
    public function email($args, $code=false)
    {
        return $this->input("email", $args);
    }

    public function month($args, $code=false)
    {
        return $this->input("month", $args);
    }

    /**
     * html
     */
    public function number($args, $code=false)
    {
        return $this->input("number", $args);
    }

    /**
     * html5
     */
    public function range($args, $code=false)
    {
        return $this->input("range", $args);
    }

    /**
     * html5
     */
    public function search($args, $code=false)
    {
        return $this->input("search", $args);
    }

    /**
     * html5
     */
    public function tel($args, $code=false)
    {
        return $this->input("tel", $args);
    }

    public function time($args, $code=false)
    {
        return $this->input("time", $args);
    }

    /**
     * html5
     */
    public function url($args, $code=false)
    {
        return $this->input("url", $args);
    }

    public function week($args, $code=false)
    {
        return $this->input("week", $args);
    }



    /**
     * 
     */

}