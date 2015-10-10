<?php
/**
 * Creator: joshpinkney
 * Date: 9/15/15
 * Time: 2:16 PM
 */

class TVProduction {

    function __construct($production_data){
        $this->id = $production_data['id'];
        $this->url = $production_data['url'];
        $this->name = $production_data['name'];
        $this->images = $production_data['image'];
        $this->mediumImage = $production_data['image']['medium'];
        $this->originalImage = $production_data['image']['original'];
    }

};

?>