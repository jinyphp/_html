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