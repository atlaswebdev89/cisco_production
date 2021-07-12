# Wifi List Projects for Brest
## Веб-приложение для учета установленных точек CiscoWifi

### Запуск приложения для разработки

С помощью gulp. Собираем проект
```js
gulp build
```
Запускаем отслеживание изменений в проекте
```js
gulp 
```
Запускаем docker контейнеры
```linux
gulp 
```
### Использование
*********************

Для начала необходимо добавить входящий вебхук в консоле управления bitrix24 

URI для добавления нового Лида

https://test.bitrix24.by/rest/1/q8khfywwh6a3c14n/crm.lead.add, где

> test -> $domain
>
> rest/1/q8khfywwh6a3c14n - $hook
>
> crm.lead.add - $uri_api


**Создание объекта класса. В конструкторе указываем необходимые данные**
```php
$client = new \atlasBitrixRestApi\ClientBitrix($domain, $hook, $uri_api);
```

**Или без конструктора**
```php
$client = new \atlasBitrixRestApi\ClientBitrix();
    $client->setDomain(test);
    $client->setHook("rest/1/q8khfywwh6a3c14n");
    $client->setUriApi("/crm.lead.add/");
```


Формируем массив данных для нового лида (обычно используются данные полей формы на сайте) 

```php
$data = [
        "TITLE" => "Запрос с сайта",
        "NAME" => "Дима",
        "SECOND_NAME" =>"Петрович",
        "LAST_NAME"=> "Смолов",
        "CURRENCY_ID" => "USD",
        "OPPORTUNITY" => 12500,
        "PHONE" => [ 
                        [ "VALUE" =>"+375111111111", "VALUE_TYPE" => "WORK"],
                    ],
        "EMAIL" => [
                        ['VALUE' => "mail@yandex.by", 'VALUE_TYPE' => 'HOME'],
                ],
        "COMMENTS" => "ПРИВЕТ НОВЫЙ ЛИД",
        "UTM_SOURCE" => "utm"
    ];
```

Полный список полей доступен в официальной документации

https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_fields.php

Выполняем запрос на создание в битрикс24 нового лида

```php
$response = $client->createLead($data); 
json_decode($response, true));
```

Ответ приходит в JSON. Необходимо обработать функцией json_decode

Перед тем как добавить новый лид в crm bitrix24 происходит проверка на наличие контакты с указаными номером телефона
и email адресом. Если контакт уже есть в bitrix24 то лид привязывается к существующему контакты и помечается в системе как 
повторный.

**Маска для проверки по номеру (для беларуси) должна соответствовать +375(99)999-99-99**

************  
### Доступные методы
************
**Получение списка контактов из битрикс24**

```php
$client->setUriApi("crm.contact.list");
$response=$client->getContacts();
```
*****************
**Получение списка контактов из битрикс24 используя фильтр**

```php
$filter_phone =[
                            "filter" => [
                                "PHONE" => "номер телефона",
                            ],
                            "select" => [
                                "ID"
                            ]
                        ];
$client->setUriApi("crm.contact.list");
$response=$client->getContacts(filter_phone);
```
Полное описание в официальной документации

https://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_list.php
******************

**Получение списка лидов из битрикс24**

```php
$client->setUriApi("crm.lead.list");
$response=$client->getLeads();
```
*************
