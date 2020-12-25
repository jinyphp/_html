<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

class CObject 
{
	public $items;

	public function __construct($items = null) 
	{
		$this->items = [];
		if (isset($items)) {
			$this->addItem($items);
		}
	}

	/**
	 * 객체를 출력합니다.
	 */
	public function __toString()
	{
		return $this->toString();
	}

	public function show($destroy = true)
	{
		echo $this->toString($destroy);
		return $this;
	}

	public function toString($destroy = true)
	{
		$res = implode('', $this->items);
		if ($destroy) {
			$this->destroy(); // 출력후 객체를 제거합니다.
		}
		return $res;
	}

	/**
	 * 객체를 제거합니다.
	 */
	public function destroy()
	{
		$this->cleanItems();
		return $this;
	}

	public function cleanItems()
	{
		$this->items = [];
		return $this;
	}

	/**
	 * 아이템의 갯수를 반환합니다.
	 */
	public function itemsCount()
	{
		return count($this->items);
	}

	/**
	 * 아이템을 추가합니다.
	 */
	public function addItem($value)
	{
		// 아이템이 객체일때
		if (is_object($value)) {
			array_push($this->items, unpack_object($value));
		}
		// 아이템이 문자열일때
		else if (is_string($value)) {
			array_push($this->items, $value);
		}
		// 아이탬이 배열일때
		elseif (is_array($value)) {
			foreach ($value as $item) {
				$this->addItem($item); 
			}
		}
		// 
		elseif (!is_null($value)) {
			array_push($this->items, unpack_object($value));
		}

		return $this;
	}

}

// 공용함수
function unpack_object(&$item) {
	$res = '';
	// CPartial 객체인 경우
	/* ==> include/classes/mvc/CPartial
	if ($item instanceof CPartial) {
		$res = $item->getOutput();
	}
	// 객체인 경우 toString 처리
	else
	*/
	if (is_object($item)) {
		$res = $item->toString(false);
	}
	// 배열인 경우 문자열 결합, 재귀함수 응용
	elseif (is_array($item)) {
		foreach ($item as $id => $dat) {
			$res .= unpack_object($item[$id]);
		}
	}
	elseif (!is_null($item)) {
		$res = strval($item);
		unset($item);
	}
	return $res;
}
