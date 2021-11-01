<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CTag;

class CList extends CTag {

	private $emptyList;

	/**
	 * Creates a UL list.
	 *
	 * @param array $values			an array of items to add to the list
	 */
	public function __construct(array $values = []) 
	{
		// ul 테그를 생성합니다.
		parent::__construct('ul', true);

		if (!$values) {
			$this->addItem(_('List is empty'), 'empty');
			$this->emptyList = true;
		} else {
			foreach ($values as $value) {
				//테그내 아이템을 추가합니다.
				$this->addItem($value);
			}
		}
	}

	/**
	 * 오버라이드
	 */
	public function addItem($value, $class = null, $id = null) 
	{
		// 초기화
		if (!is_null($value) && $this->emptyList) {
			$this->emptyList = false;
			$this->items = [];
		}

		if ($value instanceof CListItem) { //li테그
			// CListItem 객체
			parent::addItem($value);
		}
		else {
			parent::addItem($this->prepareItem($value, $class, $id));
		}

		return $this;
	}
	

	private function prepareItem($value = null, $class = null, $id = null) 
	{
		if ($value !== null) {
			$value = new CListItem($value); // li테그

			if ($class !== null) {
				$value->addClass($class);
			}

			if ($id !== null) {
				$value->setId($id);
			}
		}

		// null 반환
		return $value;
	}

}
