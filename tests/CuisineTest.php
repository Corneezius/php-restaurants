<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }
        //
        // function test_getName()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $test_Cuisine = new Cuisine($type);
        //
        //     //Act
        //     $result = $test_Cuisine->getType();
        //
        //     //Assert
        //     $this->assertEquals($type, $result);
        // }
        //
        // function test_getId()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $id = 1;
        //     $test_Cuisine = new Cuisine($type, $id);
        //
        //     //Act
        //     $result = $test_Cuisine->getId();
        //
        //     //Assert
        //     $this->assertEquals(true, is_numeric($result));
        // }
        //
        // function test_save()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $test_Cuisine = new Cuisine($type);
        //     $test_Cuisine->save();
        //
        //     //Act
        //     $result = Cuisine::getAll();
        //
        //     //Assert
        //     $this->assertEquals($test_Cuisine, $result[0]);
        // }
        //
        // function test_getAll()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $type2 = "Chinese";
        //     $test_Cuisine = new Cuisine($type);
        //     $test_Cuisine->save();
        //     $test_Cuisine2 = new Cuisine($type2);
        //     $test_Cuisine2->save();
        //
        //     //Act
        //     $result = Cuisine::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        // }
        //
        // function test_deleteAll()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $type2 = "Chinese";
        //     $test_Cuisine = new Cuisine($type);
        //     $test_Cuisine->save();
        //     $test_Cuisine2 = new Cuisine($type2);
        //     $test_Cuisine2->save();
        //
        //     //Act
        //     Cuisine::deleteAll();
        //     $result = Cuisine::getAll();
        //
        //     //Assert
        //     $this->assertEquals([], $result);
        // }
        //
        // function test_find()
        // {
        //     //Arrange
        //     $type = "Pub";
        //     $type2 = "Chinese";
        //     $test_Cuisine = new Cuisine($type);
        //     $test_Cuisine->save();
        //     $test_Cuisine2 = new Cuisine($type2);
        //     $test_Cuisine2->save();
        //
        //     //Act
        //     $result = Cuisine::find($test_Cuisine->getId());
        //
        //     //Assert
        //     $this->assertEquals($test_Cuisine, $result);
        // }

        function test_get_restaurant()
        {
            //Arrange
            $type ="Pub";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $name = "Food place";
            $stars = 5;
            $hours = "1pm to 2pm";
            $test_restaurant = new Restaurant($id, $name, $stars, $hours, $test_cuisine_id);
            $test_restaurant->save();

            $name2 = "Ducks and Booze";
            $stars2 = 3;
            $hours2 = "2am to 7am";
            $test_restaurant2 = new Restaurant($id, $name2, $stars2, $hours2, $test_cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }
    }
?>
