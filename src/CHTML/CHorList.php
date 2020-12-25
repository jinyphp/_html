<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CTag;

class CHorList extends CList {

	/**
	 * Creates a UL horizontal list with spaces between elements.
	 *
	 * @param array $values			an array of items to add to the list
	 */
	public function __construct(array $values = []) {
		parent::__construct($values);

		$this->addClass('hor-list'); // ZBX_STYLE_HOR_LIST
	}

}
