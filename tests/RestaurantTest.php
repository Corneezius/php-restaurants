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

        function tearDown()
        {
            Restaurant::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $id = null;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours);

            //Act
            $test_restaurant->save();


            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $id = null;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant ($id, $name2, $stars2, $hours2);
            $test_restaurant2->save();


            //Act
            $result = Restaurant::getAll();



            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $id = null;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant ($id, $name2, $stars2, $hours2);
            $test_restaurant2->save();

            // Act
            Restaurant::deleteAll();

            // Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            // Arrange
            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $id = 1;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours);

            // Act
            $result = $test_restaurant->getId();

            // assert
            $this->assertEquals(1, $result);
        }

        function test_find()
        {
            // Arrange
            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $id = null;
            $test_restaurant = new Restaurant($id, $name, $stars, $hours);
            $test_restaurant->save();
            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant ($id, $name2, $stars2, $hours2);
            $test_restaurant2->save();

            // Act
            $id = $test_restaurant->getId();
            $result = Restaurant::find($id);

            // Assert
            $this->assertEquals($test_restaurant, $result);
        }
    }

 ?>
