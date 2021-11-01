<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Html\Forms;

trait FormSelect
{
    public function select($el, $id=null)
    {
        $code = "<select";
        
        foreach ($el as $key => $value) {
            if($key == "type") {
                continue; // textarea는 타입 속서이 없음.
            } else if($key == "name") {
                $code .= " ".$key."='data[".$value."]'"; // name은 배열처리
            } else if(empty($value)) {
                $code .= " ".$key; // 값이 없는 경우, 키값만 설정
            } else if($key == "value") {
                $selected = $value;                
            } else if($key == "option") {
                continue; //   
            } else {
                $code .= " ".$key."='".$value."'";
            }            
        }
        $code .= " id='".$id."'>";

        // 옵션처리
        $code .= $this->selectOption($el['option'], $selected);

        return $code .$option ."</select>";
    }

    private function selectOption($opt, $selected=null)
    {
        // 옵션처리
        $option = "";
        foreach ($opt as $val => $title) {
            if($selected == $val) {
                $option .= "<option value='".$val."' selected>".$title."</option>";
            } else {
                $option .= "<option value='".$val."'>".$title."</option>";
            }
        }
        return $option;
    }

}