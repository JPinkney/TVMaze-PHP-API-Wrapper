<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 9/15/15
 * Time: 2:16 PM
 */

namespace JPinkney\TVMaze;

//Check back here if we can move the episode data to the episode class later
/**
 * Class TVShow
 *
 * @package JPinkney\TVMaze
 */
class TVShow extends TVProduction{

	/**
	 * @var
	 */
	public $type;

	/**
	 * @var
	 */
	public $language;

	/**
	 * @var
	 */
	public $genres;

	/**
	 * @var
	 */
	public $status;

	/**
	 * @var
	 */
	public $runtime;

	/**
	 * @var
	 */
	public $premiered;

	/**
	 * @var
	 */
	public $rating;

	/**
	 * @var
	 */
	public $weight;

	/**
	 * @var
	 */
	public $network_array;

	/**
	 * @var
	 */
	public $network;

	/**
	 * @var
	 */
	public $webChannel;

	/**
	 * @var
	 */
	public $externalIDs;

	/**
	 * @var string
	 */
	public $summary;

	/**
	 * @var
	 */
	public $nextAirDate;

	/**
	 * @var bool|string
	 */
	public $airTime;

	/**
	 * @var bool|string
	 */
	public $airDay;

	/**
	 * @var
	 */
	public $akas;

	/**
	 * @var
	 */
	public $country;

	/**
	 * @param $show_data
	 */
	public function __construct($show_data){
		parent::__construct($show_data);
		$this->type = isset($show_data['type']) ? $show_data['type'] : null;
		$this->language = isset($show_data['language']) ? $show_data['language'] : null;
		$this->genres = isset($show_data['genres']) ? $show_data['genres'] : null;
		$this->status = isset($show_data['status']) ? $show_data['status'] : null;
		$this->runtime = isset($show_data['runtime']) ? $show_data['runtime'] : null;
		$this->premiered = isset($show_data['premiered']) ? $show_data['premiered'] : null;
		$this->rating = isset($show_data['rating']) ? $show_data['rating'] : null;
		$this->weight = isset($show_data['weight']) ? $show_data['weight'] : null;
		$this->network_array = isset($show_data['network']) ? $show_data['network'] : null;
		$this->network = isset($show_data['network']['name']) ? $show_data['network']['name'] : null;
		$this->webChannel = isset($show_data['webChannel']) ? $show_data['webChannel'] : null;
		$this->country = isset($show_data['network']['country']['code']) ? $show_data['network']['country']['code'] : null;
		if ($show_data['webChannel'] !== null && $show_data['webChannel']['country'] !== null) {
			$this->country = $show_data['webChannel']['country']['code'];
		}
		$this->externalIDs = isset($show_data['externals']) ? $show_data['externals'] : null;
		$this->summary = isset($show_data['summary']) ? strip_tags($show_data['summary']) : null;
		$this->akas = (isset($show_data['_embedded']['akas']) ? $show_data['_embedded']['akas'] : null);

		$current_date = date('Y-m-d');
		if (!empty($show_data['_embedded']['episodes'])) {
			foreach ($show_data['_embedded']['episodes'] as $episode) {
				if ($episode['airdate'] >= $current_date) {
					$this->nextAirDate = $episode['airdate'];
					$this->airTime = date('g:i A', $episode['airtime']);
					$this->airDay = date('l', strtotime($episode['airdate']));
					break;
				}
			}
		}

	}

	/**
	 * This function is used to check whether or not the object contains any data
	 *
	 *
	 * @return bool
	 */
	public function isEmpty(){
		return($this->id == null || ($this->id == 0 && $this->url == null && $this->name == null));
	}

}
