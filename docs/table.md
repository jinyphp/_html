# 테이블 빌더
---
html 테이블을 생성합니다.

## 객체생성

```php
$Html = new \Jiny\Html\Table;
```

### 데이터 설정하기
배열 데이터를 설정합니다.

생성자를 통한 데이터 설정
```php
$Html = new \Jiny\Html\Table($data);
```

setter 메소드를 이용한 설정
```php
$Html->setData($data);
```

### 헬퍼함수를 통한 객체 생성과 데이터 설정
`new` 키워드를 통하지 않고 싱클턴 타입의 객체 생성 헬퍼함수를 제공합니다.

```php
$html = \jiny\html\table($rows);
```

## 테이블 출력하기
데이터값, 설정값에 따라서 테이블을 생성합니다.

```php
echo $Html->build();
```
또는 객체의 `__toString()` 메소드를 이용하여 직접 출력할 수도 있습니다.

```php
echo $Html;
```

### view에서 출력코드 삽입하기
table 클래스의 메서드를 싱글턴 방식으로 컨트롤러 안에서 생성, 설정을 미리 하였다면,
html 문서내에서 빌더헬프 함수를 호출하여 테이블을 출력할 수 있습니다.

```html
<div>
    <!--리스트목록/Table Builder 헬퍼함수-->
    <!--매개변수로, 부트스트랩 클래스 타입 전달-->
    <?= \jiny\html\table\build(['class'=>"table table-hover"]); ?>
</div>
```

## 출력필드 설정
배열키를 이용하여 선택된 값만 테이블로 출력을 할 수 있습니다.

```php
$Html->displayfield(["id","firstname"]);
```
설정한 필드만 테이블로 생성됩니다. 만일, 출력필드를 생략하는 경우 전체 필드가 출력됩니다.

## 타이블명
thead 테그를 이용하여 테이블의 컬럼 타이틀을 출력할 수 있습니다. 기본값으로 컬럼명을 사용합니다.
만일, 컬럼명을 변경하고자 할때에는 별로도 설정을 합니다.

```php
$Html->displayfield(["id","firstname","email"])->theadTitle(['id'=>"번호",'firstname'=>"성명",'email'=>"이메일"]);
```

또는

```php
$field = ['id'=>"번호",'firstname'=>"성명",'email'=>"이메일"];
$Html->displayfield($field)->theadTitle($field);
```

## 링크설정
각각의 출력데이터별로 a테그 링크를 설정할 수 있습니다.

```php
$Html->setHref($key, $value);
```

### 동적 링크 설정

```php
$Html->setHref("email", "/members/{id}");
```

변동되는 동적값은 중괄고`{}`를 이용하여 배열의 키값을 선택하면, 선택된 열의 값으로 대체 됩니다.


## 클래스 및 id 설정하기

build 메소드를 이용하여 테이브를 생성할때 속성배열을 인자값으로 전달합니다.

```php
$table->build(['class'=>"table table-hover"]);
```