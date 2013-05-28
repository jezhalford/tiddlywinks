<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

$app->get('ingredient-lookup', function (Request $request) use ($app) {
    $sql = "SELECT * FROM `ingredients` WHERE `name` LIKE CONCAT(?, '%')";
    $ingredients = $app['db']->fetchAll($sql, array($request->get('q')));

    return new Response(json_encode($ingredients), 200, array('Content-Type' => 'application/json'));

});

$app->run();
