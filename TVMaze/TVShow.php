<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 9/15/15
 * Time: 2:16 PM
 */

//Check back here if we can move the episode data to the episode class later
class TVShow extends TVProduction{

    function __construct($show_data){
        parent::__construct($show_data);
        $this->type = $show_data['type'];
        $this->language = $show_data['language'];
        $this->genres = $show_data['genres'];
        $this->status = $show_data['status'];
        $this->runtime = $show_data['runtime'];
        $this->premiered = $show_data['premiered'];
        $this->rating = $show_data['rating'];
        $this->weight = $show_data['weight'];
        $this->network_array = $show_data['network'];
        $this->network = $show_data['network']['name'];
        $this->webChannel = $show_data['webChannel'];
        $this->externalIDs = $show_data['externals'];
        $this->summary = strip_tags($show_data['summary']);

        $current_date = date("Y-m-d");
        foreach($show_data['_embedded']['episodes'] as $episode){
            if($episode['airdate'] >= $current_date){
                $this->nextAirDate = $episode['airdate'];
                $this->airTime = date("g:i A", $episode['airtime']);
                $this->airDay =  date('l', strtotime($episode['airdate']));
                break;
            }
        }

    }

    /*
     *
     * This function is used to check whether or not the object contains any data
     *
     */
    function isEmpty(){
        return($this->id == null || $this->id == 0 && $this->url == null && $this->name == null);
    }

};




?>