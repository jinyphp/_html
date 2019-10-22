<?php

namespace Jiny\Html;

class Field
{
    public $_type;
    public $_name;
    public $_id;
    public $_size;
    public $_value;

    public $_src;

    public $_onclick;

    public $_readonly;

    public $_placeholder;

    public $_autofocus;

    public $_autocomplete;

    public $_min;
    public $_max;
    public $_maxLength;
    public $_setp;

    public $_required;
    public $_title;

    public function __construct($args=[])
    {
        //echo __CLASS__;
        foreach ($args as $key => $value) {
            if (property_exists($this, "_".$key)) {
                $this->{"_".$key} = $value;
            }            
        }
    }

    public function __toString()
    {
        if($this->_type == "text") {
            $str = "<input";

            if ($this->_type) $str .= " type='".$this->_type."'";
            if ($this->_name) $str .= " name='".$this->_name."'";

            if ($this->_value) $str .= " value='".$this->_value."'";
            if ($this->_id) $str .= " id='".$this->_id."'";
            if ($this->_size) $str .= " size='".$this->_size."'";

            $str .= ">";
        } else {
            $str = "***";
        }
        

        return $str;
    }

    public function input($name,$id=null,$type=text)
    {
        return "<input type='text' name='".$name."'>";
    }

    public function hidden($name)
    {
        return "<input type='hidden' name='".$name."'>";
    }

    public function text($args)
    {
        extract($args);
        
        $str = "";
        if (isset($id)) $str .= " id='".$id."'";
        if (isset($size)) $str .= " size='".$size."'";

        return "<input type='text' name='$name'".$str.">";
    }

    public function search()
    {

    }

    public function tel()
    {

    }

    public function url()
    {

    }

    public function email()
    {

    }

    public function password()
    {

    }

    public function number()
    {

    }

    public function range()
    {

    }

    public function color()
    {

    }

    public function checkbox()
    {


    }

    public function radio()
    {

    }

    public function datetime()
    {

    }

    public function datetime_local()
    {

    }

    public function date()
    {

    }

    public function month()
    {

    }

    public function week()
    {

    }

    public function time()
    {

    }

    public function button()
    {

    }

    public function file()
    {

    }

    public function submit()
    {

    }

    public function image()
    {

    }

    public function reset()
    {

    }
}