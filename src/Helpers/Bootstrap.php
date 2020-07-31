<?php
namespace jiny\html\bootstrap;

function isAlertDanger($msg)
{
    if ($msg) {
        return \jiny\html\bootstrap()->alertDanger($msg);
    }    
}





