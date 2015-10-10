<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 9/15/15
 * Time: 2:13 PM
 */

class Episode extends TVProduction {

    function __construct($episode_data){
        parent::__construct($episode_data);
        $this->season = $episode_data['season'];
        $this->number = $episode_data['number'];
        $this->airdate = $episode_data['airdate'];
        $this->airtime = $episode_data['airtime'];
        $this->airstamp = $episode_data['airstamp'];
        $this->runtime = $episode_data['runtime'];
        $this->summary = strip_tags($episode_data['summary']);
    }

};

?>