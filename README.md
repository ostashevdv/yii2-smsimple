Yii2-smsimple
==============
Данное расширение позволяет отправлять смс сообщения через сервис smsimple.ru
Расширение является оберткой над [api](http://www.smsimple.ru/api)

#Установка
Запуститите команду
```
composer require --prefer-dist ostashevdv/yii2-smsimple
```

или добавьте в секцию require вашего `composer.json` файла

```
"ostashevdv/yii2-image": "dev-master"
```

#Конфигурация
После установки раширения, его необходимо с конфигурировать. Пропишите в секцию components вашего конфига:
```php
return [
  ...
  'components' => [
    'sms' => [
      'class' => '\ostashevdv\smsimple\SMSimple',
      'username' => 'Ваше имя пользователя в smsimple.ru',
      'password' => 'Ваш пароль',
      'origin_id' => 'Подпись по умолчанию (имя отправителя)'
    ]
  ],
]
```

#Использование
отправка смс 1 получателю:
```php
try {
  Yii::$app->sms->connect();
  Yii::$app->sms->send('7-123-123-12-12', 'hello world');
} catch(\ostashevdv\smsimple\SMSimpleException $e) {}
```
отправка смс нескольким получателям
```php
try {
  Yii::$app->sms->connect();
  Yii::$app->sms->send(['7-111-111-11-11', '72222222222', '83333333333'], 'foo');
  $message_id = Yii::$app->sms->send('74441111111, 7-111-111-11-11, 82222222222', 'bar');
} catch(\ostashevdv\smsimple\SMSimpleException $e) {}
```
проверка статуса рассылки:
```php
$status = Yii::$app->sms->check_delivery($message_id);
```

[больше примеров](http://www.smsimple.ru/api)
