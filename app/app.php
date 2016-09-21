<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'=> __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->post("/restaurant", function() use ($app){
        $restaurant = new Restaurant($_POST['name'], $_POST['stars'], $_POST['hours']);
        $restaurant->save();
        return $app['twig']->render('create_restaurant.html.twig', array('newrestaurant' => $restaurant));
    });

    $app->("/delete_restaurant", function() use ($app){
        Restaurant::deleteAll();
        return $app['twig']->render('delete_restaurant.html.twig')
    });

    return $app;
?>
