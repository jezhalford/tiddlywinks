<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->error(function (\Exception $e, $code) {
    throw $e;
});

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'debug' => true
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'rinky',
        'user'      => 'root',
        'password'  => 'password',
        'charset'   => 'utf8',
    ),
));

$app->get('/', function () use ($app) {

    $sql = "SELECT * FROM `recipes` LIMIT 8";
    $recipes = $app['db']->fetchAll($sql);


    return $app['twig']->render('index.twig', array(
        'recipes' => $recipes
    ));
});

$app->run();
