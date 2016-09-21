<?php

    class Restaurant
    {
        private $name;
        private $stars;
        private $hours;
        private $id;


        function __construct($id = null, $name, $stars, $hours)
        {
            $this->name = $name;
            $this->stars = $stars;
            $this->hours = $hours;
            $this->id = $id;

        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setStars($new_stars)
        {
            $this->stars = (int) $new_stars;
        }

        function setHours($new_hours)
        {
            $this->hours = (string) $new_hours;
        }

        function getName()
        {
            return $this->name;
        }

        function getStars()
        {
            return $this->stars;
        }

        function getHours()
        {
            return $this->hours;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, stars, hours) VALUES ('{$this->getName()}', {$this->getStars()}, '{$this->getHours()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant)
            {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $stars = $restaurant['stars'];
                $hours = $restaurant['hours'];
                $new_restaurant = new Restaurant($id, $name, $stars, $hours);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach ($restaurants as $restaurant)
            {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id)
                {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
    }




 ?>
