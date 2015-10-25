<?php

namespace JPinkney;

/**
 * This is the file that you are going to include in each of your new projects
 */

use JPinkney\TVMaze\TVMaze;
use JPinkney\TVMaze\TVProduction;
use JPinkney\TVMaze\TVShow;
use JPinkney\TVMaze\Actor;
use JPinkney\TVMaze\Character;
use JPinkney\TVMaze\Crew;
use JPinkney\TVMaze\Episode;

/**
 * Class Client
 *
 * @package JPinkney
 */
class Client
{
	/**
	 * @var TVMaze
	 */
	public $TVMaze;

	/**
	 * @param array $options
	 */
	public function __construct($options = array())
	{
		$this->TVMaze = new TVMaze();
	}
}

?>
