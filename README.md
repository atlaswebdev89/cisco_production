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
```
docker-composer up -d
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



