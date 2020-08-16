<?php

namespace Jiny\Html\Admin;

class Resource
{
    public function __construct()
    {
        echo __CLASS__;
    }

    public function main()
    {
        $resource = \file_get_contents("../resource/admin/resource.html");
        $resource = str_replace("{{routelist}}",$body,$resource);
        return $resource;
    }
}