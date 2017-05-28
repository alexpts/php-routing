# php-routing

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/89812ecc-babb-441e-acca-466c87e03a54/big.png)](https://insight.sensiolabs.com/projects/89812ecc-babb-441e-acca-466c87e03a54)

[![Build Status](https://travis-ci.org/alexpts/php-routing.svg?branch=master)](https://travis-ci.org/alexpts/php-routing)
[![Code Coverage](https://scrutinizer-ci.com/g/alexpts/php-routing/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alexpts/php-routing/?branch=master)
[![Code Climate](https://codeclimate.com/github/alexpts/php-routing/badges/gpa.svg)](https://codeclimate.com/github/alexpts/php-routing)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexpts/php-routing/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexpts/php-routing/?branch=master)


Простой роутер с поддержкой PSR-7 и middelware на уровне роута.

#### Возможности
- Простой захват параметров из url
- Использование RegExp для описания роута
- Гибкие группировки для захвата параметров
- Приоритеты роутов
- Middlewares на уровне роутов
- Высокая скорость работы
- Указание дефолтного роута
- Адаптирован для работы с REST

#### Простой роутинг
```php
use PTS\Routing\Route;
use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\RouteService;
use Psr\Http\Message\RequestInterface;

$route = new Route('/', function(){});
$collection = new CollectionRoute();
$collection->add('main', $route);
$matcher = new Matcher(new RouteService());

$activeRoute = $matcher->match($this->coll, '/')->current();
$response = $activeRoute($request); // PSR-7 request
```

#### Захват параметров из url ####
Захваченные параметры могут быть переданы в качестве аргументов в обработчик.
Параметры начинающиеся с символа `_` игнорируются. Они нужны для технических нужд.

```php
use PTS\Routing\Route;
use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\RouteService;
use Psr\Http\Message\RequestInterface;

$route = new Route('/users/{userId}/', function($userId){
    return $userId;
});
$route->pushMiddleware(new CallWithMatchParams);

$collection = new CollectionRoute();
$collection->add('user', $route);
$matcher = new Matcher(new RouteService());

$activeRoute = $matcher->match($this->coll, '/users/4/')->current();

```
