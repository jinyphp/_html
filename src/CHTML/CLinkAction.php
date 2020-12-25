<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/
namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CTag;

class CLinkAction extends CLink {

	public function __construct($items = null) {
		parent::__construct($items);

		$this->addClass('link-action');
	}
}
