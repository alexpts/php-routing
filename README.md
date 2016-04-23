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
- Монтирование роутов в группу
- Middlewares на уровне группы роутов
- Любые пользовательские проверки перед вызовом роута посредством расширений
- Высокая скорость работы
- Указание дефолтного роута

#### Простой роутинг
``````php
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

`````