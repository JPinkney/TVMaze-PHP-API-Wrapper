<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 9/15/15
 * Time: 2:13 PM
 */

namespace JPinkney\TVMaze;

/**
 * Class Episode
 *
 * @package JPinkney\TVMaze
 */
class Episode extends TVProduction {

	/**
	 * @var
	 */
	public $season;
	/**
	 * @var
	 */
	public $number;
	/**
	 * @var
	 */
	public $airdate;
	/**
	 * @var
	 */
	public $airtime;
	/**
	 * @var
	 */
	public $airstamp;
	/**
	 * @var
	 */
	public $runtime;
	/**
	 * @var string
	 */
	public $summary;

	/**
	 * @param $episode_data
	 */
	public function __construct($episode_data){
		parent::__construct($episode_data);
		$this->season = isset($episode_data['season']) ? $episode_data['season'] : null;
		$this->number = isset($episode_data['number']) ? $episode_data['number'] : null;
		$this->airdate = isset($episode_data['airdate']) ? $episode_data['airdate'] : null;
		$this->airtime = isset($episode_data['airtime']) ? $episode_data['airtime'] : null;
		$this->airstamp = isset($episode_data['airstamp']) ? $episode_data['airstamp'] : null;
		$this->runtime = isset($episode_data['runtime']) ? $episode_data['runtime'] : null;
		$this->summary = isset($episode_data['summary']) ? strip_tags($episode_data['summary']) : null;
	}

}
