# namaztimes
Api namaztimes.kz. Получаем список стран, регионов, городов

Подробнее про API читать по ссылке https://namaztimes.kz/ru/dev

# Пример использования

Получаем список стран

```php
use AlexanderLogachev\ApiNamaztimes;

(new ApiNamaztimes())->getCountries();
```

Получаем список регионов

```php
use AlexanderLogachev\ApiNamaztimes;

$countryID = 99; // ID страны из полученного списка методом getCountries

(new ApiNamaztimes())->getRegions($countryID);
```

Получаем список городов

```php
use AlexanderLogachev\ApiNamaztimes;

$regionID = 'Almaty'; // ID региона из полученного списка методом getRegions

(new ApiNamaztimes())->getCities($regionID);
```

# Формат данных

По умолчанию данные приходят в формате json, декодированы.

```php
$dataType = 'json'; // 'json | xml' - доступные форматы
$parseData = true; // true | false - декодировать или вернуть строку

new ApiNamaztimes($dataType, $parseData);
```

