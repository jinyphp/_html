<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CObject;
use \Jiny\Html\CHTML as html;

class CTag extends CObject {

	const ENC_ALL = 1; // '<', '>', '"' 과 '&' 심볼기호를 엔코딩 합니다.
	const ENC_NOAMP = 2; // Encodes all symbols in ENC_ALL except for '&'.

	/**
	 * The HTML encoding strategy to use for the contents of the tag.
	 *
	 * @var int
	 */
	protected $encStrategy = self::ENC_NOAMP;

	/**
	 * The HTML encoding strategy for the "value", "name" and "id" attributes.
	 *
	 * @var int
	 */
	protected $attrEncStrategy = self::ENC_ALL;

	/**
	 * Hint element for the current CTag.
	 *
	 * @var CSpan
	 */
	protected $hint = null;

	/**
	 * 테그를 생성합니다.
	 */
	public function __construct($tagname, $paired = false, $body = null) {
		parent::__construct(); // CObject 생성자 호출

		$this->attributes = []; // 객체 속성 초기화
		$this->tagname = $tagname;
		$this->paired = $paired; // 테그페어 유무

		if (!is_null($body)) {
			// 내용이 있는 경우 아이템을 추가합니다.
			$this->addItem($body);
		}
	}

	/**
	 * 시작테크 생성
	 */
	// html 태그 앞뒤에 줄 바꿈 기호 (\ n)를 넣지 마십시오. 원하지 않는 곳에 공백이 추가됩니다.
	protected function startToString() {
		$res = '<'.$this->tagname;

		// 테그 속성
		foreach ($this->attributes as $key => $value) {
			if ($value === null) {
				continue; // 값이 없는 경우 속성을 추가하지 않음.
			}

			// 인코딩 전략 설정
			// "value", "name"및 "id"속성에는 특수 인코딩 전략 적용
			$strategy = in_array($key, ['value', 'name', 'id'], true) ? $this->attrEncStrategy : $this->encStrategy;
			$value = $this->encode($value, $strategy);

			// 속성은 키=값 형태로 표기합니다.
			$res .= ' '.$key.'="'.$value.'"';
		}
		$res .= '>';

		return $res;
	}

	/**
	 * 종료 테그
	 */
	protected function endToString() {
		$res = ($this->paired) ? '</'.$this->tagname.'>' : '';
		return $res;
	}

	/**
	 * 객체를 출력합니다.
	 */
	public function toString($destroy = true) {
		$res = $this->startToString(); // 시작테그
		$res .= $this->bodyToString();
		$res .= $this->endToString(); // 종료테그

		if ($this->hint !== null) {
			// 팝업 힌트 기능이 있는 경우, 추가함
			$res .= $this->hint->toString();
		}

		if ($destroy) {
			//출력후 객체를 삭제합니다.
			$this->destroy();
		}

		return $res;
	}

	protected function bodyToString() {
		// CObject toString 호출
		return parent::toString(false);
	}

	/**
	 * 아이템을 추가합니다.
	 */
	public function addItem($value, $enc=true) {
		// 추가 아이템이 문자열인 경우, 엔코딩 처리를 합니다.
		if ($enc && is_string($value)) {
			$value = $this->encode($value, $this->getEncStrategy());
		}

		// CObject 메소드 호출
		parent::addItem($value);
		return $this;
	}

	/**
	 * 테그 name 속성을 부여합니다.
	 */
	public function setName($value) {
		$this->setAttribute('name', $value);
		return $this;
	}

	public function getName() {
		return $this->getAttribute('name');
	}

	/**
	 * 클래스 속성을 부여합니다. 클래스는 복수로 설정합니다.
	 */
	public function addClass($class) 
	{
		if ($class !== null) {
			if (!array_key_exists('class', $this->attributes) || $this->attributes['class'] === '') {
				// class 속성값이 없는 경우 초기화
				$this->attributes['class'] = $class;
			}
			else {
				// class 속성문자열 추가
				$this->attributes['class'] .= ' '.$class;
			}
		}

		return $this;
	}

	public function removeClass($class)
	{
		if ($class !== null) {
			if (array_key_exists('class', $this->attributes)) {
				// class 문자열 공백으로 치환
				$this->attributes['class'] = str_replace($class, "", $this->attributes['class']);

				// class 속성이 비어 있는 경우, 항목 삭제
				if ($this->attributes['class'] === '') {
					unset($this->attributes['class']);
				}
			}
		}
		return $this;
	}

	/**
	 * 부여된 속성을 처리합니다.
	 */
	public function getAttribute($name) 
	{
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	public function setAttribute($name, $value) 
	{
		if (is_object($value)) {
			$value = unpack_object($value);
		}
		elseif (is_array($value)) {
			$value = html\CEncode::serialize($value);
		}
		$this->attributes[$name] = $value;
		return $this;
	}

	public function removeAttribute($name) 
	{
		unset($this->attributes[$name]);
		return $this;
	}

	/**
	 * 타이틀 속성을 부여합니다.
	 */
	public function setTitle($value) {
		$this->setAttribute('title', $value);
		return $this;
	}

	public function removeTitle()
	{
		unset($this->attributes['title']);
		return $this;
	}

	/**
	 * Id 속성을 관리 합니다.
	 */
	public function setId($id) 
	{
		$this->setAttribute('id', $id);
		return $this;
	}

	public function getId() 
	{
		return $this->getAttribute('id');
	}

	public function removeId() 
	{
		$this->removeAttribute('id');
		return $this;
	}



	/**
	 * Action 설정
	 */

	private function addAction($name, $value) {
		$this->attributes[$name] = $value;
		return $this;
	}

	public function onChange($script)
	{
		$this->addAction('onchange', $script);
		return $this;
	}

	public function onClick($script)
	{
		$this->addAction('onclick', $script);
		return $this;
	}

	public function onMouseover($script)
	{
		$this->addAction('onmouseover', $script);
		return $this;
	}

	public function onMouseout($script)
	{
		$this->addAction('onmouseout', $script);
		return $this;
	}

	public function onKeyup($script)
	{
		$this->addAction('onkeyup', $script);
		return $this;
	}

	public function onKeydown($script)
	{
		$this->addAction('onkeydown', $script);
		return $this;
	}

	/**
	 * Set or reset element 'aria-required' attribute.
	 *
	 * @param bool $is_required  Define aria-required attribute for element.
	 *
	 * @return $this
	 */
	public function setAriaRequired($is_required = true) {
		if ($is_required) {
			$this->setAttribute('aria-required', 'true');
		}
		else {
			$this->removeAttribute('aria-required');
		}

		return $this;
	}


	/**
	 * 인라인 스타일시트
	 */
	public function addStyle($value)
	{
		if (!isset($this->attributes['style'])) {
			// 스타일값 초기화
			$this->attributes['style'] = '';
		}

		if (isset($value)) {
			// 값 설정하기
			$this->attributes['style'] .= htmlspecialchars(strval($value));
		}
		else {
			unset($this->attributes['style']);
		}
		return $this;
	}

	public function setStyle($key, $value)
	{
		// 추후작성
		return $this;
	}

	public function removeStyle($key)
	{
		// 추후작성
		return $this;
	}

	public function changeStyle($key, $value)
	{
		// 추후작성
		return $this;
	}





	/**
	 * Adds a hint box to the element.
	 *
	 * @param string|array|CTag		$text				Hint content.
	 * @param string				$span_class			Wrap the content in a span element and assign this class
	 *													to the span.
	 * @param bool					$freeze_on_click	If set to true, it will be possible to "freeze" the hint box
	 *													via a mouse click.
	 * @param string				$styles				Custom css styles.
	 *													Syntax:
	 *														property1: value1; property2: value2; property(n): value(n)
	 *
	 * @return CTag
	 */
	public function setHint($text, $span_class = '', $freeze_on_click = true, $styles = '') {
		$this->hint = (new CDiv($text))
			->addClass('hint-box')
			->setAttribute('style', 'display: none;');

		$this->setAttribute('data-hintbox', '1');

		if ($span_class !== '') {
			$this->setAttribute('data-hintbox-class', $span_class);
		}
		if ($styles !== '') {
			$this->setAttribute('data-hintbox-style', $styles);
		}
		if ($freeze_on_click) {
			$this->setAttribute('data-hintbox-static', '1');
		}

		return $this;
	}

	/**
	 * Set data for menu popup.
	 *
	 * @param array $data
	 */
	public function setMenuPopup(array $data) {
		$this->setAttribute('data-menu-popup', $data);
		$this->setAttribute('aria-expanded', 'false');

		if (!$this->getAttribute('disabled')) {
			$this->setAttribute('aria-haspopup', 'true');
		}

		return $this;
	}

	



	public function error($value) {
		error('class('.get_class($this).') - '.$value);
		return 1;
	}

	public function getForm($method = 'post', $action = null, $enctype = null) {
		$form = (new CForm($method, $action, $enctype))
			->addItem($this);
		return $form;
	}





	/**
	 * Sanitizes a string according to the given strategy before outputting it to the browser.
	 *
	 * @param string	$value
	 * @param int		$strategy
	 *
	 * @return string
	 */
	protected function encode($value, $strategy = self::ENC_NOAMP) 
	{
		if ($strategy == self::ENC_NOAMP) {
			// Encodes all symbols in ENC_ALL except for '&'.
			// 문자열을 치환 합니다.
			$value = str_replace(['<', '>', '"'], ['&lt;', '&gt;', '&quot;'], $value);
		}
		else {
			$value = html\CEncode::encode($value);
		}

		return $value;
	}

	/**
	 * @param int $encStrategy
	 */
	public function setEncStrategy($encStrategy) {
		$this->encStrategy = $encStrategy;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getEncStrategy() {
		return $this->encStrategy;
	}


}
