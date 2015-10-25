<?php

/**
 * User: jpinkney
 * Date: 9/15/15
 * Time: 2:15 PM
 */

namespace JPinkney;

/**
 * This is the file that you are going to include in each of your new projects
 */

use JPinkney\TVMaze\TVMaze;

/* - Enable these when desired and pass options through __construct
use JPinkney\TVMaze\TVProduction;
use JPinkney\TVMaze\TVShow;
use JPinkney\TVMaze\Actor;
use JPinkney\TVMaze\Character;
use JPinkney\TVMaze\Crew;
use JPinkney\TVMaze\Episode;
*/

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
		$defaults = [];
		$options += $defaults;

		$this->TVMaze = new TVMaze();
	}
}

?>
