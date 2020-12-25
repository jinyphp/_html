<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/
namespace Jiny\Html\Forms;

use \Jiny\Html\CHTML\CTag;

class CLabel extends CTag {

	const STYLE_FIELD_LABEL_ASTERISK = 'form-label-asterisk';

	public function __construct($label, $for = null) {
		// label 테그를 생성합니다.
		parent::__construct('label', true, $label);

		if ($for !== null) {
			$this->setAttribute('for', str_replace(['[', ']'], ['_', ''], $for));
		}
	}

	/**
	 * Allow to add visual 'asterisk' mark to label.
	 *
	 * @param bool $add_asterisk  Define is label marked with asterisk or not.
	 *
	 * @return CLabel
	 */
	// 클래스 추가, CSS 연동
	public function setAsteriskMark($add_asterisk = true) {
		return $this->addClass($add_asterisk ? self::STYLE_FIELD_LABEL_ASTERISK : null);
	}
}
