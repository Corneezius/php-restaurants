<?php

    class Restaurant
    {
        private $name;
        private $stars;
        private $hours;
        private $id;
        private $cuisine_id;

        function __construct($id = null, $name, $stars, $hours, $cuisine_id)
        {
            $this->name = $name;
            $this->stars = $stars;
            $this->hours = $hours;
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;

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

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function update($new_name, $new_stars, $new_hours)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);

            $GLOBALS['DB']->exec("UPDATE restaurants SET stars = '{$new_stars}' WHERE id = {$this->getId()};");
            $this->setStars($new_stars);

            $GLOBALS['DB']->exec("UPDATE restaurants SET hours = '{$new_hours}' WHERE id = {$this->getId()};");
            $this->setHours($new_hours);

        }



        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, stars, hours, cuisine_id) VALUES ('{$this->getName()}', {$this->getStars()}, '{$this->getHours()}', {$this->getCuisineId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
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
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);
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
