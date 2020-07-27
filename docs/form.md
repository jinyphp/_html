## 폼 객체 생성
자동적으로 폼을 생성할 수 있는 객체를 생성합니다.

```php
$form = new \Jiny\Html\Form;
```

## 폼 설정하기
자동적으로 폼을 생성하기 위해서는 폼의 속성등을 설정해 주어야 합니다.
별도로 제공하는 세터 메소드를 이용하여 속성을 지정할 수 있습니다.

```php
$form->setName("abcd")->setAction("/forms")
```

또는, 객체의 생성시 배열인자를 통하여 자동설정을 할 수 있습니다.

```php
$form = \jiny\htmlForm(['name'=>"abcd", 'action'=>"/forms"]);
```

또는 json 파일 설정을 통하여 자동으로 속성을 설정할 수 있습니다.

```json
{
    "name":"abcd",
    "action":"/forms",
    "method":"POST",
    "fields":[
        {
            "type":"hidden",
            "mode":"list"
        },
        {
            "label":"이름",
            "type":"text",
            "name":"firstname",
            "id":"first"
        }
    ]
}
```

설정한 json 파일을 읽어서 자동으로 설정합니다.

```php
echo "폼 자동생성 테스트";
$conf = \json_decode(\file_get_contents("..".DIRECTORY_SEPARATOR.__CLASS__.".json"),true);
$body = \jiny\htmlForm($conf)->build();
```

## 요소 빌드하기
생성한 폼객체에 폼의 요소들 추가 생성할 수 있습니다.

```php
$form->hidden(['mode'=>"list"]);
$form->text(['label'=>"이름", 'name'=>"firstname", 'id'=>"fist"]);
```
     
## 폼 빌드하기
폼의 모든 속성과 요소 설정이 완료된 후에는 최종 html 코드를 생성합니다.

```php
$body = $form->build($conf['fields']);
return $body;
```

## 생성된 폼요소 html에 삽입하기

컨트롤러에서 생성한 폼요소를 html에서 쉽게 삽입할 수 있는 helper 함수를 제공합니다.

```php
<?= \jiny\htmlFormBody(); ?>
```
