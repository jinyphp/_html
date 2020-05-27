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
    function isAssoArray($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private $data;
    public function __construct($data=null)
    {
        if ($data) { // 데이터 설정
            if($this->isAssoArray($data)) {
                // 연상배열 데이터               
            } else {
                // 일차 데이터
            }
            $this->data = $data;
        }
    }

    // 테이블을 빌드합니다.
    public function build()
    {
        $body = $this->header;

        // 테이블 코드 시작, class / id를 추가합니다.
        $body .= "<table";
        if($this->class) $body .= " class=\"".$this->class."\"";
        if($this->id) $body .= " class=\"".$this->id."\"";
        $body .= ">";

        // 테이블 Header를 설정합니다
        if(!$this->thead) $this->setThead( array_keys($this->data[0]) ); // 첫번째줄, 키값만 전달.
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

    // 테이블 Body
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
        
        if (is_array($arr)) {
            // 배열처리: 여러개의 셀이 존재합니다.
            foreach ($arr as $key => $cell) {
                if (array_key_exists($key, $this->href)) {
                    if (is_array($this->href[$key])) {
                        $value = $arr[ $this->href[$key]['field'] ]; // 지정한 키값
                        $uri = $this->link($key, $value, $this->href[$key]['url']);
                    } else {
                        $value = $arr[ $this->href[$key] ]; // 지정한 키값
                        $uri = $this->link($key, $value);
                    }                    
                } else {
                    $uri = null;          
                }

                $str .= $this->td($cell, $uri);                
            }
        } else {
            // 단일값 : 한개의 셀만 존재합니다.
            $str .= $this->td($arr);  
        }
        
        $str .= "</tr>"; // 행종료 테그
        return $str;
    }

    // td: 열
    private function td($value, $link=null)
    {
        if ($link) {
            // 링크연결이 있는 셀.
            return "<td><a href='".$link."'>".$value."</a></td>";
        } else {
            return "<td>".$value."</td>"; 
        }        
    }

    // 셀링크 체크
    private function link($key, $value=null, $url=null)
    {
        if (array_key_exists($key, $this->href)) {
            
            if ($url) {
                $uri = $url;
            } else {
                $uri = "/". explode("/",$_SERVER['REQUEST_URI'])[1];
            }            
            
            if ($value) {
                $uri .= "/".$value;
            }
            
        } else {
            $uri = null;          
        }
        return $uri;
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
    public function setThead($arr)
    {
        $this->thead = "<thead>";
        $this->thead .= $this->th($arr);
        $this->thead .= "</thead>";

        return $this;
    }

    private function th($arr)
    {
        $str = "<tr>";
        foreach ($arr as $cell) {
            $str .= "<th>".$cell."</th>";
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