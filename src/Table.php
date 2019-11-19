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
    private $data = [];
    public function __construct($data=[], $titles=null)
    {
        $this->data = $data;
        
        if ($titles) {
            $this->fieldTitle = $titles;
        }        
    }

    // 테이블 해더
    private $thead;
    public function setThead($arr)
    {
        $this->thead = $this->thead($arr[0]);
        return $this;
    }

    private function thead($arr, $num=null)
    {
        $str = "<thead>";
        $str .= $this->th($arr, $num);
        $str .= "</thead>";
        return $str;
    }

    private $fieldTitle;
    public function setFieldTitle($titles)
    {
        $this->fieldTitle = $titles;
        return $this;
    }

    private function th(array $arr, $num=null)
    {
        $str = "<tr>";
        // 번호출력
        if($num) {
            $str .= "<th>".$this->numTitle."</th>";
        }

        // 필드명
        foreach ($arr as $key => $cell) {
            if($key == "id") continue; // id필드 스킵
            
            if($this->fieldTitle && array_key_exists($key, $this->fieldTitle) ){
                $str .= "<th>".$this->fieldTitle[$key]."</th>";
            } else {
                $str .= "<th>".$key."</th>";
            }            
        }
        $str .= "</tr>";
        return $str;
    }

    //////////////////////

    /**
     * 테이블 tbody를 설정합니다.
     */
    private $tbody;
    public function setTbody($rows)
    {
        $this->tbody = $this->tbody($rows);
        return $this;
    }

    private function tbody($rows, $num=null)
    {
        $str = "<tbody>";
        foreach ($rows as $arr) {            
            $str .= $this->tr($arr, $num);
            if ($num) $num++;
        }        
        $str .= "</tbody>";
        return $str;
    }

    private function tr(array $arr, $num=null)
    {
        $str = "<tr>";
        // 번호
        if($num) {
            $str .= "<td>".$num."</td>";
        }

        foreach ($arr as $key => $cell) {
            if($key == "id") continue; // id필드 스킵

            if (array_key_exists($key, $this->href)) {
                $uri = $this->href[$key];
                foreach ($this->hrefParser($uri) as $field) {
                    $uri = str_replace("{".$field."}", $arr[$field] ,$uri);
                }

                $str .= "<td><a href='".$uri."'>".$cell."</a></td>";
            } else {
                $str .= "<td>".$cell."</td>";                
            }            
        }
        $str .= "</tr>";
        return $str;
    }

    public function hrefParser($string)
    {
        $k = 0;
        $key[$k] = "";
        $capture = false;
        for ($i=0;$i<strlen($string);$i++) {
            //echo $string[$i];
            
            if($string[$i] == "{") {
                $capture = true;
                $key[$k] = "";
                //echo "<br>t".$capture;
                continue;
            }

            if($string[$i] == "}") {
                $capture = false;
                //echo "<br>f".$capture;
                $k++;
                
                continue;
            }

            if($capture) $key[$k] .= $string[$i];            
        }

        return $key;
    }

    private $href=[];
    public function setHref($key, $value)
    {
        $this->href[$key] = $value;
        return $this;
    }

    /**
     * 테이블 tfoot을 설정합니다.
     */
    private $tfoot;
    public function setTfoot($str)
    {
        $this->tfoot = "<tfoot>";
        $this->tfoot .= $this->tr($arr);
        $this->tfoot .= "</tfoot>";

        return $this;
    }

    /**
     * 캡션 정보를 설정합니다.
     */
    private $caption;
    public function SetCaption($str)
    {
        $this->caption = "<caption>".$str."</caption>";
        return $this;
    }

    /**
     * 테이블 클래스 속성을 설정합니다.
     */
    private $class;
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * 테이블 Id 속성을 설정합니다.
     */
    private $id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 상단 출력을 설정합니다.
     */
    private $header;
    public function setHeader($str)
    {
        $this->header = $str;
        return $this;
    }

    /**
     * 하단 출력을 설정합니다.
     */
    private $footer;
    public function setFooter($str)
    {
        $this->footer = $str;
        return $this;
    }

    /**
     * 번호를 출력합니다.
     */
    private $num=1;
    private $numTitle = "Num";
    private function num()
    {
        return $this->num;
    }

    public function setNum($num, $title=null)
    {
        $this->num = $num;
        if($title) $this->numTitle = $title;
        return $this;
    }

    /**
     * 테이블을 출력합니다.
     */
    public function __toString()
    {
        $body = $this->header;  // 테이블 상단 배치내용
        
        $body .= "<table";
        if($this->class) $body .= " class=\"".$this->class."\"";
        if($this->id) $body .= " class=\"".$this->id."\"";
        $body .= ">";

        
        $body .= $this->caption;

        if ($this->thead) {
            $body .= $this->thead;
        } else {
            $body .= $this->thead($this->data[0], $this->num());
        }
      

        // tbody 처리
        if ($this->tbody) {
            $body .= $this->tbody;
        } else {
            if($this->data) {
                $body .= $this->tbody($this->data, $this->num());
            } else {
                $body .= "<tbody><tr><td>데이터가 없습니다.</td></tr></tbody>";
            }
        }
        
        $body .= $this->tfoot;

        $body .= "</table>";

        $body .= $this->footer; // 테이블 하단 배치내용
        
        return $body;
    }


    /**
     * 
     */
}