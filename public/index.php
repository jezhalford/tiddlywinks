<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Orm\Query;

$app = new Silex\Application();

$app->error(function (\Exception $e, $code) {
    throw $e;
});

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'debug' => true
));

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'rinky',
        'user'      => 'root',
        'password'  => 'password',
        'charset'   => 'utf8',
    ),
));

$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => __DIR__ . '/../tmp/proxies',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Rinky\Entity',
                'path' => __DIR__.'/../src/Rinky/Entity',
                ),
        ),
    ),
));

$app->get('/', function () use ($app) {

    $drinks = $app['orm.em']
        ->getRepository('Rinky\Entity\Drink')
        ->createQueryBuilder('r')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();

    $ingredients = $app['orm.em']
        ->getRepository('Rinky\Entity\Ingredient')
        ->createQueryBuilder('i')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();

    return $app['twig']->render('index.twig', array(
        'drinks' => $drinks,
        'ingredients' => $ingredients,
    ));
});

$app->get('/recipes/{drink}', function ($drink) use ($app) {

    return $app['twig']->render('recipe.twig', array(
        'drink' => $drink
    ));

})->convert('drink', function ($id) use ($app) {
    return $app['orm.em']
        ->find('Rinky\Entity\Drink', $app->escape($id));
});

$app->get('/ingredients/{ingredient}', function ($ingredient) use ($app) {

    return $app['twig']->render('ingredient.twig', array(
        'ingredient' => $ingredient
    ));

})->convert('ingredient', function ($id) use ($app) {
    return $app['orm.em']
        ->find('Rinky\Entity\Ingredient', $app->escape($id));
});

$app->get('/drinks', function () use ($app) {

    $drinks = $app['orm.em']
        ->getRepository('Rinky\Entity\Drink')
        ->findAll();

    return $app['twig']->render('drinks.twig', array(
        'drinks' => $drinks
    ));
});

$app->get('/ingredients', function () use ($app) {

    $ingredients = $app['orm.em']
        ->getRepository('Rinky\Entity\Ingredient')
        ->findAll();

    return $app['twig']->render('ingredients.twig', array(
        'ingredients' => $ingredients
    ));
});

$app->get('/ingredient-lookup', function (Request $request) use ($app) {

    $ingredients = $app['orm.em']
        ->getRepository('Rinky\Entity\Ingredient')
        ->createQueryBuilder('i')
        ->where('i.name LIKE :name')
        ->setParameter('name', '%' . $request->get('term') . '%')
        ->getQuery()
        ->getResult();

    $json = array();

    foreach($ingredients as $ingredient) {
        $json[] = array(
            'label' => $ingredient->getName(),
            'value' => $ingredient->getName(),
            'id' => $ingredient->getId()
            );
    }

    return new Response(json_encode($json), 200, array('Content-Type' => 'application/json'));

});

$app->get('/recipe-lookup', function (Request $request) use ($app) {

    $ingredients = explode(',', $request->get('ingredients'));

    $placeholders = array_fill(0, count($ingredients), '?');

    $sql = sprintf("SELECT r.name as recipe, r.id as id, COUNT(i.id) AS ingredients,
            (SELECT COUNT(sri.ingredient_id) FROM recipe_ingredient sri WHERE sri.recipe_id = r.id) as c
            FROM
            recipes r
            LEFT JOIN recipe_ingredient ri ON ri.recipe_id = r.id
            LEFT JOIN ingredients i ON ri.ingredient_id = i.id
            WHERE (%s)
            GROUP BY r.id HAVING ingredients = c
            ORDER BY i.id;", 'i.id = ' . implode(' OR i.id = ', $placeholders));

    $recipes = $app['db']->fetchAll($sql, $ingredients);

    return new Response(json_encode($recipes, true), 200, array('Content-Type' => 'application/json'));

});

$app->run();
