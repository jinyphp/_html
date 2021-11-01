<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;
use \Jiny\Html\CHTML\CTag;

class CImg extends CTag {

	//public $preloader;

	public function __construct($src, $name = 'image', $width = null, $height = null)
	{
		parent::__construct('img');

		$this->setBorder();
		$this->setName($name);
		$this->setAltText($name);
		$this->setSrc($src);
		$this->setWidth($width);
		$this->setHeight($height);
	}

	/**
	 * 이미지 경로 설정
	 */
	public function setSrc($value)
	{
		$this->setAttribute('src', $value);
		return $this;
	}

	/**
	 * ALt 속성 부여
	 */
	public function setAltText($value = null)
	{
		if (!is_null($value)) {
			$this->setAttribute('alt', $value);
		} 
		else {
			$this->removeAttribute('alt');
		}
		
		return $this;
	}

	public function setTitleText($value = null)
	{
		if (!is_null($value)) {
			$this->setTitle($value);
		} 
		else {
			$this->removeTitle();
		}
		return $this;
	}

	/**
	 * 이미지맵 설정
	 */
	public function setMap($value = null) 
	{
		if (is_null($value)) {
			$this->deleteOption('usemap');
		}
		else {
			$value = '#'.ltrim($value, '#');
			$this->setAttribute('usemap', $value);
		}
		return $this;
	}

	/**
	 * 가로폭 속성 설정
	 */
	public function setWidth($value = null)
	{
		if (is_null($value)) {
			$this->removeAttribute('width');
		}
		// 가로폭 설정
		else {
			$this->setAttribute('width', $value);
		}

		return $this;
	}

	/**
	 * 세로 속성 설정
	 */
	public function setHeight($value = null) 
	{
		if (is_null($value)) {
			$this->removeAttribute('height');
		}
		else {
			$this->setAttribute('height', $value);
		}
		return $this;
	}

	public function setBorder($value = 0) 
	{
		$this->setAttribute('border', $value);
		return $this;
	}


}
