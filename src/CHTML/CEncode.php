<?php
/*
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**/

namespace Jiny\Html\CHTML;


class CEncode 
{

	/**
	 * HTML 코드에서 사용할 값을 인코딩합니다. 
	 * 주어진 값이 배열이면 값은 재귀 적으로 인코딩됩니다.
	 *
	 * @static
	 *
	 * @param mixed $data
	 *
	 * @return mixed
	 */
	public static function encode($data)
	{
		if (is_array($data)) {
			$rs = [];
			foreach ($data as $key => $value) {
				$rs[$key] = self::encode($value);
			}

			return $rs;
		}

		return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * HTML 엔티티가 이스케이프 된 JSON 문자열로 데이터를 인코딩합니다.
	 *
	 * @static
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public static function serialize(array $data) 
	{
		return self::encode(json_encode($data));
	}
}
