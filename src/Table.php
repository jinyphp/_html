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

    private $data;
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
     * 테이블 데이터 설정
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->displayfield($data[0]); //출력필드 설정
        return $this;
    }

    private $_field=[];
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

    /**
     * 빌드로직
     * 실제 html 테이블을 생성합니다.
     */
    public function build()
    {
        $body = $this->header;

        // 테이블 코드 시작, class / id를 추가합니다.
        $body .= "<table";
        if($this->class) $body .= " class=\"".$this->class."\"";
        if($this->id) $body .= " class=\"".$this->id."\"";
        $body .= ">";

        // 테이블 Header를 설정합니다
        if(!$this->thead) $this->buildThead( $this->data[0] ); // 첫번째줄, 키값만 전달.
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
            $str .= $this->td($arr);  
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
            
            $str .= $this->td($cell, $uri);                
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

    // td: 열
    private function td($value, $href=null)
    {
        if ($href) {
            // 링크연결이 있는 셀.
            return "<td><a href='".$href."'>".$value."</a></td>";
        } else {
            return "<td>".$value."</td>"; 
        }        
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
            if(isset($this->_theadTitle[$key])) {
                $str .= "<th>".$this->_theadTitle[$key]."</th>";
            } else {
                $str .= "<th>".$key."</th>";
            }            
        }
        $str .= "</tr>";
        return $str;
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