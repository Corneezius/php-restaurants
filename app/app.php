<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'=> __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/restaurants", function() use ($app){
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->post("/restaurants", function() use ($app){
        $id = null;
        $test = $_POST['cuisine_id'];
        $restaurant = new Restaurant($id, $_POST['name'], $_POST['stars'], $_POST['hours'], $test);
        $restaurant->save();
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->get("/create_restaurant", function() use ($app){
        return $app['twig']->render('create_restaurant.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/delete_restaurants", function() use ($app){
        Restaurant::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/cuisines", function() use ($app) {
      return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app) {
     $cuisine = new Cuisine($_POST['type']);
     $cuisine->save();
     return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });


    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/cuisines/{id}/edit", function($id) use ($app)
    {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisines.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get("/restaurants/{id}/edit", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    });

    $app->patch("/restaurants/{id}", function($id) use ($app) {
        $new_name = $_POST['new_name'];
        $new_stars = $_POST['new_stars'];
        $new_hours = $_POST['new_hours'];
        $restaurant = Restaurant::find($id);
        $restaurant->update($new_name, $new_stars, $new_hours);
        return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant, 'restaurants' => Restaurant::getAll()));
    });


    return $app;
?>
