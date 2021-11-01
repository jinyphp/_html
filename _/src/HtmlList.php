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

class HtmlList
{
    private $data;
    public function __construct($data=null)
    {
        // echo __CLASS__;
        if($data) $this->data = $data;
    }

    /**
     * 배열을 ul테그로 생성합니다.
     */
    public function ul($attr=[])
    {
        if(isset($attr['ul'])) {
            if(\is_array($attr['ul'])) {
                $str = "<ul ";
                foreach ($attr['ul'] as $key => $value) {
                    $str .= $key."='".$value."'";
                }
                $str .= ">";
            } else {
                $str = "<ul class='".$attr['ul']."'>";
            }
        } else $str = "<ul>";

        $i = 0; // li class 선택용, 초기화
        foreach ($this->data as $key => $value) {
            if(isset($attr['li'])) {
                if(\is_array($attr['li'])) {
                    // print_r($attr['li']);
                    if(empty($attr['li'])) {
                        // 빈내용일 경우, ul클래스명 + 번호
                        $str .= "<li class='".$attr['ul']['class']."-".++$i."'>".$value."</li>";
                    } else {
                        // 서로다른 설정
                        $li = $attr['li'][$i++];
                        if(\is_array($li)) {
                            $str .= "<li ";
                            // 배열일때, 각각 설정
                            foreach ($li as $k => $v) {
                                $str .= $k."='".$v."'";
                            }
                            $str .= ">".$value."</li>";
                        } else if (\is_string($li)) {
                            // 문자열일때 클래스
                            $str .= "<li class='".$li."'>".$value."</li>";
                        }                        
                    }
                                  
                } else {
                    // 동일한 클래스명
                    $str .= "<li class='".$attr['li']."'>".$value."</li>";
                }                
            } else {
                // 없음
                $str .= "<li>".$value."</li>";
            }            
        }
        $str .= "</ul>";
        return $str;
    }
}