<?php
namespace Jiny\Html;

class FormItem
{
    private $name;
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function formGroup($item)
    {
        $str = "<div class=\"form-group\">";
            
        foreach ($item as $func => $form) {
            $str .= $this->$func($form);                              
        }            

        $str .= "</div>";

        return $str;
    }

    public function label($item)
    {
        return "<label for='".$this->name."'>".$item."</label>";
    }
    
    public function input($item)
    {
        $str = "<input type='".$item->type."' name='".$this->name."' ";
        if (isset($item->class)) $str .= "class='".$item->class."' ";
        if (isset($item->id)) $str .= "id='".$item->id."' ";
        if (isset($item->value)) $str .= "value='".$item->value."' ";
        $str .= ">";
        return $str;
    }

    public function button($item)
    {
        $str = "<button name='".$this->name."' ";
        if (isset($item->class)) $str .= "class='".$item->class."' ";
        if (isset($item->id)) $str .= "id='".$item->id."' ";
        $str .= ">";
        if (isset($item->value)) $str .= $item->value;
        $str .= "</button>";
        return $str;
    }

    public function checkbox($item)
    {

    }

    public function file($item)
    {

    }

    public function hidden($item)
    {

    }

    public function image($item)
    {

    }

    public function password($item)
    {

    }

    public function radio($item)
    {

    }

    public function reset($item)
    {

    }

    public function submit($item)
    {

    }

    public function text($item)
    {

    }

}