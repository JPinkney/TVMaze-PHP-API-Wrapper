<?php
/**
 * Creator: joshpinkney
 * Date: 9/15/15
 * Time: 2:16 PM
 */

namespace JPinkney\TVMaze;

/**
 * Class TVProduction
 *
 * @package JPinkney\TVMaze
 */
class TVProduction {

	/**
	 * @var
	 */
	public $id;
	/**
	 * @var
	 */
	public $url;
	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $images;
	/**
	 * @var
	 */
	public $mediumImage;
	/**
	 * @var
	 */
	public $originalImage;

	/**
	 * @param $production_data
	 */
	public function __construct($production_data){
		$this->id = isset($production_data['id']) ? $production_data['id'] : null;
		$this->url = isset($production_data['url']) ? $production_data['url'] : null;
		$this->name = isset($production_data['name']) ? $production_data['name'] : null;
		$this->images = isset($production_data['image']) ? $production_data['image'] : null;
		$this->mediumImage = isset($production_data['image']['medium']) ? $production_data['image']['medium'] : null;
		$this->originalImage = isset($production_data['image']['original']) ? $production_data['image']['original'] : null;
	}

}
