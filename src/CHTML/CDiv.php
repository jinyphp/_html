<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CTag;

class CDiv extends CTag {

	/**
	 * 테그 생성
	 */
	public function __construct($items = null) {
		parent::__construct('div', true);

		$this->addItem($items);
	}

	/**
	 * 가로폭 인라인 지정
	 * 기본값 px
	 */
	public function setWidth($value, $unit="px") {
		$this->addStyle('width: '.$value.$unit.';');

		return $this;
	}
}
