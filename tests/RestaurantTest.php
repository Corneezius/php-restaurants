<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Restaurant.php';
    require_once 'src/Cuisine.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        // Test 1
        function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }
        // Test 2
        function  test_getCuisineId()
        {
            $id = null;
            $type = "Pub";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();
        }
        // Test 3
        function test_save()
        {

            //Arrange
            $type = "Pub";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);

            //Act
            $test_restaurant->save();


            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }
        // Test 4
        function test_getAll()
        {
            //Arrange
            $id = null;
            $type = "Pub";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Food place";
            $stars = 5;
            $cuisine_id = $test_cuisine->getId();
            $hours = "1pm to 2pm";
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant($id, $name2, $stars2, $hours2, $cuisine_id);
            $test_restaurant2->save();


            //Act
            $result = Restaurant::getAll();



            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }
        // Test 5
        function test_deleteAll()
        {
            //Arrange
            $id = null;
            $type = "Pub";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Food place";
            $stars = 5;
            $cuisine_id = $test_cuisine->getId();
            $hours = "1pm to 2pm";
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant($id, $name2, $stars2, $hours2, $cuisine_id);
            $test_restaurant2->save();

            // Act
            Restaurant::deleteAll();

            // Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }
        // Test 6
        function test_getId()
        {
            // Arrange
            $id = null;
            $type = "Pub";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Food place";
            $stars = 5;
            $cuisine_id = $test_cuisine->getId();
            $hours = "1pm to 2pm";
            $id = 1;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);

            // Act
            $result = $test_restaurant->getId();

            // assert
            $this->assertEquals(true, is_numeric($result));
        }
        // Test 7
        function test_find()
        {
            // Arrange
            $id = null;
            $type = "Pub";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Food place";
            $stars = 5;
            $cuisine_id = $test_cuisine->getId();
            $hours = "1pm to 2pm";
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant($id, $name2, $stars2, $hours2, $cuisine_id);
            $test_restaurant2->save();

            // Act
            $id = $test_restaurant->getId();
            $result = Restaurant::find($id);

            // Assert
            $this->assertEquals($test_restaurant, $result);
        }

    }

 ?>
