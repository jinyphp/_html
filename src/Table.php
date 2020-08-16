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
    // 연상배열 여부 체크
    public function isAssoArray($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private $data=[];
    public function __construct($data=null)
    {
        if ($data) { // 데이터 설정
            if($this->isAssoArray($data)) {
                // 연상배열              
            } else {
                // 순서배열
            }
            $this->data = $data;
            $this->displayfield($data[0]); //출력필드 설정
        }
    }

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

    /**
     * 테이블 데이터 설정
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->displayfield($data[0]); //출력필드 설정
        return $this;
    }

    private $_field=[];
    public $field_width=[];
    public $field_attr=[];

    public function displayfield($arr=[])
    {
        if($this->isAssoArray($arr)) {
            $this->_field = []; // 초기화, 재설정
            foreach($arr as $key => $value) $this->_field []= $key;
            //print_r($this->_field);
        } else {
            $this->_field = $arr;
        }
        return $this;
    }

    public function tagStart($attr=[])
    {
        $body = "<table";
        if (empty($attr)) {
            // 테이블 코드 시작, class / id를 추가합니다.
            if($this->class) $body .= " class=\"".$this->class."\"";
            if($this->id) $body .= " class=\"".$this->id."\"";
            
        } else {
            foreach ($attr as $key => $value) {
                $body .= " ".$key."=\"".$value."\"";
            }
        }
        $body .= ">";
        return $body;
    }

    /**
     * 빌드로직
     * 실제 html 테이블을 생성합니다.
     */
    public function build($attr=[])
    {
        $body = $this->header;
        $body .= $this->tagStart($attr); // table 시작테크 생성

        // 테이블 Header를 설정합니다
        // echo "header 생성";
        if(!$this->thead) {
            // print_r($this->_theadTitle);
            if (isset($this->data[0])) {
                $fieldTitle = $this->data[0];
            } else {
                $fieldTitle = $this->_theadTitle;
            }
            // print_r($fieldTitle);       
            $this->buildThead( $fieldTitle ); // 첫번째줄, 키값만 전달.
        }
        $body .= $this->thead;

        $body .= $this->caption;

        // 테이블 Body를 설정합니다.
        if(!$this->tbody) $this->setTbody($this->data); 
        $body .= $this->tbody;
        
        $body .= $this->tfoot;
        
        $body .= "</table>";

        $body .= $this->footer;

        return $body;
    }

    public function __toString()
    {
        return $this->build();
    }

    // 테이블 클래스명 설정하기
    private $class;
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    // 테이블 id명 설정하기
    private $id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 테이블 body를 생성합니다.
     */
    private $tbody;
    public function setTbody($rows)
    {
        
        $this->tbody = "<tbody>";

        foreach ($rows as $arr) {
            // 한줄씩 호출
            $this->tbody .= $this->tr($arr);
        }  
              
        $this->tbody .= "</tbody>";
        return $this;
    }

    // tr: 행
    private function tr($arr)
    {
        $str = "<tr>"; // 행시작 테그
        
        // 배열처리: 여러개의 셀이 존재합니다.
        if (is_array($arr)) {
            $str .= $this->trAssoc($arr); // 순차배열
            
        } else 
        // 문자열일때, 한개의 셀만 존재합니다.
        if(\is_string($arr)) {
            $str .= "<td>".$this->td($arr)."</td>";  
        }
        
        $str .= "</tr>"; // 행종료 테그
        return $str;
    }

    private function trAssoc($arr)
    {
        $str = "";
        foreach ($arr as $key => $cell) {
            if (!in_array($key, $this->_field)) continue; // t선택한 필드만 출력허용

            // a링크 설정검사
            if (array_key_exists($key, $this->href)) {
                $uri = $this->uri($key, $arr);  
            } else {
                $uri = null; // 링크설정 없음        
            }
            
            $str .= "<td";
            //속성적용
            if(isset($this->field_attr[$key])) {
                foreach($this->field_attr[$key] as $attr => $style) {
                    $str .= " ".$attr."='".$style."'";
                }
            }
            $str .= ">".$this->td($cell, $uri)."</td>";                
        }
        return $str;
    }

    private function uri($key, $arr)
    {
        $href = $this->href[$key]; //링크값
        if (\is_string($href)) {
            // 경로처리
            if($href[0] == "/") $uri = $href; // 절대경로
            else $uri = rtrim($_SERVER['REQUEST_URI'],"/")."/".$href; // 상대경로

            //변수치환
            $str = \explode("{",$uri);
            foreach($str as $v) {
                if(strrev($v)[0] == '}') {
                    $sel = rtrim($v,"}");
                    $uri = str_replace("{".$v,$arr[$sel],$uri);
                }
            }
            return $uri;

        } else if (\is_array($href)) {
            if($href[0] == 'script') {
                $uri = $href[1];
                // echo $uri;
                
                //변수치환
                $str = \explode("{",$uri);
                    // print_r($str);
                foreach($str as $v) {
                    if(($pos=strpos($v,"}")) === false ) {
                    } else {
                        $k = substr($v,0,$pos);
                        $uri = str_replace("{".$k."}",$arr[$k],$uri);
                        //echo "===".$uri;
                    }
                    /*
                    if(strrev($v)[0] == '}') {
                        $sel = rtrim($v,"}");
                        echo $sel;
                        $uri = str_replace("{".$v,$arr[$sel],$uri);
                    }*/
                }
                return $uri;
            }
        }
    }

    private function aLink($text, $attr=[])
    {
        $a = "<a";
        foreach($attr as $key => $value) {
            $a .= " ".$key."='".$value."'";
        }
        $a .= ">";
        $a .= $text;
        $a .= "</a>";
        return $a;
    }

    /**
     * td 열을 생성합니다.
     */
    private function td($text, $href=null)
    {
  
        if ($href) {
            // 링크연결이 있는 셀.
            return $this->aLink($text,['href'=>$href]);
        } else {
            return $text; 
        }
        
        //return $td;
    }



    // 링크설정
    private $href=[];
    public function setHref($key, $value)
    {
        $this->href[$key] = $value;
        return $this;
    }


    // 테이블 해더
    private $thead;
    private $_theadTitle=[];
    public function theadTitle($arr)
    {
        $this->_theadTitle = $arr;
        return $this;
    }

    public function buildThead($arr)
    {
        $this->thead = "<thead>";
        $this->thead .= $this->th($arr);
        $this->thead .= "</thead>";

        return $this;
    }

    private function th($arr)
    {
        $str = "<tr>";
        foreach ($arr as $key => $value) {
            if (!in_array($key, $this->_field)) continue; // t선택한 필드만 출력허용

            $str .= "<th";
            //속성적용
            if(isset($this->field_attr[$key])) {
                foreach($this->field_attr[$key] as $attr => $style) {
                    $str .= " ".$attr."='".$style."'";
                }
            }            
            $str .= ">".$this->thTitle($key)."</th>";      
        }
        $str .= "</tr>";
        return $str;
    }

    // th 타일명
    private function thTitle($key)
    {
        if(isset($this->_theadTitle[$key])) {
            //사용자 지정 타이틀이 이는 경우
            return $this->_theadTitle[$key];
        } else {
            // 키값을 타이틀 명으로 출력
            return $key;
        } 
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
    public function setCaption($str)
    {
        $this->caption = "<caption>".$str."</caption>";
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

    /**
     * 
     */
}