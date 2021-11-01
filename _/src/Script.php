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

class Script
{
    private $_scripts;
    public function btn_delete($formname="forms[0]")
    {
        $this->_scripts []= "
            function btn_delete(){
                document.".$formname.".mode.value='delete';
                document.".$formname.".submit();
            }
        ";
        return $this;
    }

    public function build()
    {
        foreach ($this->_scripts as $javascript)
        {
            $script .= $javascript;
        }
        return "<script>".$script."</script>";
    }

    public function __toString()
    {
        return $this->build();
    }

    /**
     * 
     */
}