<?php

class TVShow {

    public $id;
    public $url;
    public $name;
    public $type;
    public $language;
    public $genres;
    public $status;
    public $runtime;
    public $premiered;
    public $rating;
    public $weight;
    public $network_array;
    public $network;
    public $webChannel;
    public $externalIDs;
    public $images;
    public $summary;
    public $nextAirDate;
    public $airTime;
    public $airDay;

    function __construct($show_data){

        $this->id = (int) $show_data['id'];
        $this->url = $show_data['url'];
        $this->name = $show_data['name'];
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
        $this->images = $show_data['image'];
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

    function isEmpty(){
        return($this->id == null || $this->id == 0 && $this->url == null && $this->name == null);
    }

};

class TVMaze {

    CONST APIURL = 'http://api.tvmaze.com';

    /*
     *
     * Takes in a show name with optional modifiers (episodes)
     * Outputs array of all the related shows for that given name
     *
     */
    function search($show_name){
        $url = self::APIURL."/search/shows?q=".$show_name;

        $shows = $this->getFile($url);

        $relevant_shows = array();
        foreach($shows as $series){
            $TVShow = new TVShow($series['show']);
            array_push($relevant_shows, $TVShow);
        }
        return $relevant_shows;
    }

    /*
     *
     * Takes in a show name with optional modifiers (episodes)
     * Outputs array of the MOST related shows for that given name
     *
     */
    function singleSearch($show_name, $modifier=null){
        if($modifier == null){
            $url = self::APIURL."/singlesearch/shows?q=".$show_name;
        }else{
            $url = self::APIURL."/singlesearch/shows?q=".$show_name.'&embed='.$modifier;
        }

        $shows = $this->getFile($url);
        return new TVShow($shows);
    }

    /*
     *
     * Allows show lookup by using TVRage or TheTVDB ID
     *
     */
    function lookupByID($site, $ID){
        $site = strtolower($site);
        $url = self::APIURL.'/lookup/shows?'.$site.'='.$ID;
        $show = $this->getFile($url);
        return new TVShow($show);
    }

    /*
     *
     * THIS FUNCTION IS NOT FULLY IMPLEMENTED YET. WE NEED TO MAKE A PERSON CLASS OR SOMETHING
     *
     */
    function searchByPerson($name){
        $name = strtolower($name);
        $url = self::APIURL.'/search/people?q='.$name;
        $show = $this->getFile($url);
        return new TVShow($show);
    }

    /*
     *
     * Function used to get the data from the URL and return the results in an array
     *
     */
    private function getFile($url){
        $json = file_get_contents($url);
        $shows = json_decode($json, TRUE);

        return $shows;
    }

};

$TVMaze = new TVMaze();
$relevant_shows = $TVMaze->lookupByID('TVRAGE', 24493);

echo "<pre>";
print_r($relevant_shows);
echo "</pre>";


?>