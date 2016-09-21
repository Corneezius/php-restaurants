<?php
    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function setType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getType()
        {
            return $this->type;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}')");
            $this->id = (int) $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine){
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type,$id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine){
                $cuisine_id = $cuisine->getId();
                if($cuisine_id == $search_id){
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        function getRestaurants()
        {
            $restaurants = array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
            var_dump($returned_restaurants);
            var_dump($this->getId());
            foreach ($returned_restaurants as $restaurant)
            {
                $name = $restaurant['name'];
                $stars = $restaurant['stars'];
                $hours = $restaurant['hours'];
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($id, $name, $stars, $hours, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }
    }
?>
