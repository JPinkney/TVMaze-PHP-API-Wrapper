<?php

class Crew {

    public $type;

    function __construct($crew_data){
        $this->type = $crew_data['type'];
    }

};

class Episode {

    public $id;
    public $url;
    public $name;
    public $images;
    public $mediumImage;
    public $originalImage;
    public $season;
    public $number;
    public $airdate;
    public $airtime;
    public $airstamp;
    public $runtime;
    public $summary;

    function __construct($episode_data){
        $this->id = $episode_data['id'];
        $this->url = $episode_data['url'];
        $this->name = $episode_data['name'];
        $this->images = $episode_data['image'];
        $this->mediumImage = $episode_data['medium'];
        $this->originalImage = $episode_data['original'];
        $this->season = $episode_data['season'];
        $this->number = $episode_data['number'];
        $this->airdate = $episode_data['airdate'];
        $this->airtime = $episode_data['airtime'];
        $this->airstamp = $episode_data['airstamp'];
        $this->runtime = $episode_data['runtime'];
        $this->summary = strip_tags($episode_data['summary']);
    }

};

class Actor {

    public $id;
    public $url;
    public $name;
    public $images;
    public $mediumImage;
    public $originalImage;


    function __construct($actor_data){
        $this->id = $actor_data['id'];
        $this->url = $actor_data['url'];
        $this->name = $actor_data['name'];
        $this->images = $actor_data['image'];
        $this->mediumImage = $actor_data['medium'];
        $this->originalImage = $actor_data['original'];
    }

};

class Character extends Actor {

}

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

    /*
     *
     * This function is used to check whether or not the object contains any data
     *
     */
    function isEmpty(){
        return($this->id == null || $this->id == 0 && $this->url == null && $this->name == null);
    }

};

class TVMaze {

    CONST APIURL = 'http://api.tvmaze.com';

    /*
     *
     * Takes in a show name
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
    function singleSearch($show_name){

        $url = self::APIURL."/singlesearch/shows?q=".$show_name.'&embed=episodes';
        $shows = $this->getFile($url);

        $episode_list = array();
        foreach($shows['_embedded']['episodes'] as $episode){
            $ep = new Episode($episode);
            array_push($episode_list, $ep);
        }

        $TVShow = new TVShow($shows);

        return array($TVShow, $episode_list);
    }

    /*
     *
     * Allows show lookup by using TVRage or TheTVDB ID
     * site is the string of the website (either 'tvrage' or 'thetvdb') and the id is the id of the show on that respective site
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
     * Takes in an actors name and outputs their actor object
     *
     */
    function searchByPerson($name){
        $name = strtolower($name);
        $url = self::APIURL.'/search/people?q='.$name;
        $person = $this->getFile($url);
        return new Actor($person);
    }

    function searchBySchedule($country=null, $date=null){
        if($country != null && $date != null){
            $url = self::APIURL.'/schedule?country='.$country.'&date='.$date;
        }else if($country == null && $date != null){
            $url = self::APIURL.'/schedule';
        }else if($country != null && $date == null){
            $url = self::APIURL.'/schedule';
        }else{
            $url = self::APIURL.'/schedule';
        }

        $schedule = $this->getFile($url);

    }

    /*
     *
     * Takes in a show ID and outputs the TVShow Object
     *
     */
    function searchShowByShowID($ID, $embed_cast=null){
        if($embed_cast === true){
            $url = self::APIURL.'/shows/'.$ID.'?embed=cast';
        }else{
            $url = self::APIURL.'/shows/'.$ID;
        }

        $show = $this->getFile($url);

        $cast = array();
        foreach($show['_embedded']['cast'] as $person){
            $actor = new Actor($person['person']);
            $character = new Character($person['character']);
            array_push($cast, array($actor, $character));
        }

        $TVShow = new TVShow($show);

        return $embed_cast === true ? array($TVShow, $cast) : array($TVShow);
    }

    /*
     *
     * Takes in a show ID and outputs all the episode objects for that show in an array
     *
     */
    function searchEpisodesByShowID($ID){

        $url = self::APIURL.'/shows/'.$ID.'/episodes';

        $episodes = $this->getFile($url);

        $allEpisodes = array();
        foreach($episodes as $episode){
            $ep = new Episode($episode);
            array_push($allEpisodes, $ep);
        }

        return $allEpisodes;
    }

    /*
     *
     * Takes in a show ID and outputs all of the cast members in the form (actor, character)
     *
     */
    function getCastByShowID($ID){
        $url = self::APIURL.'/shows/'.$ID.'/cast';
        $people = $this->getFile($url);

        $cast = array();
        foreach($people as $person){
            $actor = new Actor($person['person']);
            $character = new Character($person['character']);
            array_push($cast, array($actor, $character));
        }

        return $cast;
    }

    /*
     *
     * Gets a list of all shows in the database. Page number is optional (caps display at 250 results)
     *
     */
    function searchAllShowsByPage($page=null){
        if($page == null){
            $url = self::APIURL.'/shows';
        }else{
            $url = self::APIURL.'/shows?page'.$page;
        }

        $shows = $this->getFile($url);

        $relevant_shows = array();
        foreach($shows as $series){
            $TVShow = new TVShow($series);
            array_push($relevant_shows, $TVShow);
        }
        return $relevant_shows;
    }

    /*
     *
     * Gets an actor by his ID
     *
     */
    function getPersonByID($ID){
        $url = self::APIURL.'/people/'.$ID;
        $show = $this->getFile($url);
        return new Actor($show);
    }

    /*
     *
     * Gets an array of all the shows a particular actor has been in
     *
     */
    function getCastCreditsByID($ID){
        $url = self::APIURL.'/people/'.$ID.'/castcredits?embed=show';
        $castCredit = $this->getFile($url);

        $shows_appeared = array();
        foreach($castCredit as $series){
            $TVShow = new TVShow($series['_embedded']['show']);
            array_push($shows_appeared, $TVShow);
        }
        return $shows_appeared;
    }

    /*
     *
     * Gets the position worked at the tv show in a tuple with the tvshow
     *
     */
    function getCrewCreditsByID($ID){
        $url = self::APIURL.'/people/'.$ID.'/crewcredits?embed=show';
        $crewCredit = $this->getFile($url);

        $shows_appeared = array();
        foreach($crewCredit as $series){
            $position = $series['type'];
            $TVShow = new TVShow($series['_embedded']['show']);
            array_push($shows_appeared, array($position, $TVShow));
        }
        return $shows_appeared;
    }

    /*
     *
     * Function used to get the data from the URL and return the results in an array
     *
     */
    public function getFile($url){
        $json = file_get_contents($url);
        $shows = json_decode($json, TRUE);

        return $shows;
    }
    
};

$TVMaze = new TVMaze();
$relevant_shows = $TVMaze->getFile('http://api.tvmaze.com/shows/1/episodes?specials=1');
//$relevant_shows = $TVMaze->getCrewCreditsByID(100);
echo "<pre>";
print_r($relevant_shows);
echo "</pre>";


?>