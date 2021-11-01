<?php

namespace Jiny\Html;

class Form
{
    private $name;
    private $action;
    private $method = "POST";
    private $header;
    private $footer;

    public $fields=[];

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

        $body = $this->start(); // 시작테크

        // 요소를 하나씩 결합
        foreach ($this->fields as $id => $item) {
            if(is_array($item)) {
                $code = "";
                foreach($item as $tag => $str) {
                    //if($tag == "group") continue;
                    $code .= $str;
                }
            } else {
                $code = $item;
            }
            $body .= "<div id='form-".$id."'>".$code."</div>";    
        }       
        
        $body .= "</form>"; // 종료테그

        if(isset($this->footer)) $body .= $this->footer;
        return $body;
    }

 
    public function setFields($fields, $row=[])
    {

        foreach ($fields as $id => $field) { 
            // 요소 생성
            foreach($field as $tag => $el) {
                $type = isset($el['type']) ? $el['type'] : $tag ;
                if(method_exists($this, $type)) {
                    if (isset($el['name']) && $type != "password") { // 페스워드는 제외함
                        $v = $el['name'];
                        if($row[$v]) $el['value'] = $row[$v];
                    }

                    // 생성된 요소 추가
                    $this->fields[$id][$tag] = $this->$type($el, $id);
                } else {
                    // 의미없는 메소드의 경우, 텍스트로 추가
                   
                    if(\is_array($el)) {
                        foreach ( $el as $i => $value) {
                            $this->fields[$id][$tag] .= $value;
                        } 
                    } else {
                        $this->fields[$id][$tag] = $el;
                    }
                    
                    // $this->setFieldString($el, $id);
                    
                }
            }
        }
        return $this;
    }

    private function setFieldString($el, $id)
    {
        if(\is_array($el)) {
            foreach ( $el as $i => $value) {
                $this->fields[$id][$tag] .= $value;
            } 
        } else {
            $this->fields[$id][$tag] = $el;
        }

    }


    public function __toString()
    {
        return $this->build();
    }

   
    public function label($el, $id=null)
    {
        if($id) $el['for'] = $id;

        $code = "<label";
        foreach ($el as $key => $value) {
            if($key == "title") {
                $title = $value; 
            } else {
                $code .= " ".$key."='".$value."'";
            }
        }
        $code .= ">".$title."</label>";
        return $code;        
    }

    public function fieldset($el, $title=null)
    {
        if ($title) {
            return "<fieldset>"."<legend>".$title."</legend>".$el."</fieldset>";
        } else {
            return "<fieldset>".$el."</fieldset>";
        }       
    }


    public function input($el, $id) {
        $code = "<input";
        foreach ($el as $key => $value) {
            if($key == "name") {
                $code .= " ".$key."='data[".$value."]'"; // name은 배열처리
            } else if(empty($value)) {
                $code .= " ".$key; // 값이 없는 경우, 키값만 설정
            } else {
                $code .= " ".$key."='".$value."'";
            }            
        }
        $code .= " id='".$id."'>";
        return $code;
    }

   

    public function hidden($el, $id=null) 
    {
        $el['type'] = "hidden";
        
        $code = "<input";
        foreach ($el as $key => $value) {
            $code .= " ".$key."='".$value."'";            
        }

        if ($id) {
            $code .= " id='".$id."'>";
        } else {
            $code .= ">";
        }
        
        return $code;
    }

    public function password($el, $id=null) 
    {
        $el['type'] = "password";
        return $this->input($el, $id);
    }

    public function button($el, $id=null) 
    {
        // print_r($el);
        unset($el['type']);
        if(isset($el['title'])) {
            $title = $el['title'];
            // unset($el['title']);
        } else $title = "button";

        $code = "<button";
        foreach ($el as $key => $value) {
            $code .= " ".$key."='".$value."'";            
        }

        if ($id) {
            $code .= " id='".$id."'>".$title."</button>";
        } else {
            $code .= ">".$title."</button>";
        }
        
        return $code;
    }


    public function text($el, $id=null) 
    {
        return $this->input($el, $id);
    }

    

    public function submit($el, $id=null) 
    {
  
    }

    public function reset($el, $id=null) 
    {
      
    }

    public function image($el, $id=null) 
    {
     
    }

    

    public function checkbox($el, $id=null)
    {
       
    }

    public function radio($el, $id=null)
    {
        $body = "";
        foreach ($args as $radio) {
            //$body .= $this->input("radio", $args, true);
        }
        $this->fields []= $body;
        return $body;
    }

    use Forms\FormSelect; // select 요소처리

    

    public function textarea($el, $id=null)
    {
        $content = ""; // new 모드일때는, $content 변수가 생성되지 않기 때문에 초기화
        $code = "<textarea";
        foreach ($el as $key => $value) {
            if($key == "type") {
                continue; // textarea는 타입 속서이 없음.
            } else if($key == "name") {
                $code .= " ".$key."='data[".$value."]'"; // name은 배열처리
            } else if(empty($value)) {
                $code .= " ".$key; // 값이 없는 경우, 키값만 설정
            } else if($key == "value") {
                $content = $value;
            } else {
                $code .= " ".$key."='".$value."'";
            }            
        }
        $code .= " id='".$id."'>";
        return $code.$content."</textarea>";
    }

    /**
     * output 테그 : 계산결과 출력형식
     */
    public function output($el, $id=null)
    {

    }

    public function progress($el, $id=null)
    {

    }

    public function meter($el, $id=null)
    {

    }


    /**
     * text 타입 html5 속성
     */
    public function color($el, $id=null) 
    {
    
    }

    public function date($el, $id=null) 
    {
      
    }

    public function datetime($el, $id=null)
    {
      
    }

    public function datetimeLocal($el, $id=null)
    {
      
    }

    /**
     * html5
     */
    public function email($el, $id=null)
    {
        return $this->input($el, $id);
    }

    public function month($el, $id=null)
    {
       
    }

    /**
     * html
     */
    public function number($el, $id=null)
    {
    
    }

    /**
     * html5
     */
    public function range($el, $id=null)
    {
      
    }

    /**
     * html5
     */
    public function search($el, $id=null)
    {
      
    }

    /**
     * html5
     */
    public function tel($el, $id=null)
    {
        
    }

    public function time($el, $id=null)
    {
       
    }

    /**
     * html5
     */
    public function url($el, $id=null)
    {
       
    }

    public function week($el, $id=null)
    {
     
    }



    /**
     * 
     */

}