<?php
namespace Module\Html;

class Markup
{
    public $Table;
    public $Form;

    public function __construct()
    {
        $this->Table = new \Module\Html\Table;
        $this->Form = new \Module\Html\Form;
    }
}