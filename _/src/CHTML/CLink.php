<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;

use \Jiny\Html\CHTML\CTag;

class CLink extends CTag {

	private	$use_sid = false;
	private	$confirm_message = '';
	private $url;

	public function __construct($item = null, $url = null)
	{
		// a 테그를 생성합니다.
		parent::__construct('a', true);

		if ($item !== null) {
			$this->addItem($item);
		}
		$this->url = $url;
	}

	/*
	 * Add a "sid" argument into the URL.
	 * POST method will be used for the "sid" argument.
	 */
	public function addSID() {
		$this->use_sid = true;
		return $this;
	}

	/*
	 * 컴펌 확인 메시지
	 */
	public function addConfirmation($value) {
		$this->confirm_message = $value;
		return $this;
	}

	/**
	 * target 속성을 지정합니다.
	 */
	public function setTarget($value = null) {
		$this->attributes['target'] = $value;
		return $this;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * 오버라이드 : a 링크를 출력합니다.
	 */
	public function toString($destroy = true) {
		$url = $this->url;

		if ($url === null) {
			$this->setAttribute('role', 'button');
		}

		/*
		if ($this->use_sid) {
			if (array_key_exists(ZBX_SESSION_NAME, $_COOKIE)) {
				$url .= (strpos($url, '&') !== false || strpos($url, '?') !== false) ? '&' : '?';
				$url .= 'sid='.substr(CSessionHelper::getId(), 16, 16);
			}
			$confirm_script = ($this->confirm_message !== '')
				? 'Confirm('.CHtml::encode(json_encode($this->confirm_message)).') && '
				: '';
			$this->onClick("javascript: return ".$confirm_script."redirect('".$url."', 'post', 'sid', true)");
			$this->setAttribute('href', 'javascript:void(0)');
		}
		else {
			$this->setAttribute('href', ($url == null) ? 'javascript:void(0)' : $url);

			if ($this->confirm_message !== '') {
				$this->onClick('javascript: return Confirm('.json_encode($this->confirm_message).');');
			}
		}
		*/

		return parent::toString($destroy);
	}
}
