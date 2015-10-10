<?php

/*
 *
 * This always need to be required when using this API
 * 
 */
require 'TVMazeIncludes.php';


/*
 * Create a new TVMaze Object called TVMaze that will allow us to access all the api's functionality
 */
$TVMaze = new TVMaze;

/*
 * List of some methods that you can use. Others will be included in more formal documentation
 */
$TVMaze->search("Arrow");
$TVMaze->singleSearch("The Walking Dead");
$TVMaze->getShowBySiteID("TVRage", 33272);

?>