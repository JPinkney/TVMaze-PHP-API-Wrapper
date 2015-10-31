# TVMaze-PHP-API-Wrapper

An easier way to interact with TVMaze's endpoints. Developed in PHP.

Goal

 * The goal of this API Wrapper is to turn TVMaze's endpoints into something more object orientated and readable
 * Provide a simple, open source project that anybody can contribute to

Pre-reqs

 * Before attempting to use this wrapper make sure you require 'TVMazeIncludes.php'; at the top of your php file.

Supported Methods:

```php
   function search -> Return all tv shows relating to the given input
```
```php
   function singleSearch -> Return the most relevant tv show to the given input
```
```php
   function getShowBySiteID -> Allows show lookup by using TVRage or TheTVDB ID
```
```php
   function getPersonByName -> Return all possible actors relating to the given input
```
```php
   function getSchedule -> Return all the shows in the given country and/or date
```
```php
   function getShowByShowID -> Return all information about a show given the show ID
```
```php
   function getEpisodesByShowID -> Return all episodes for a show given the show ID
```
```php
   function getCastByShowID -> Return the cast for a show given the show ID
```
```php
   function getAllShowsByPage -> Return a master list of TVMaze's shows given the page number
```
```php
   function getPersonByID -> Return an actor given their ID
```
```php
   function getCastCreditsByID -> Return an array of all the shows a particular actor has been in
```
```php
   function getCrewCreditsByID -> Return an array of all the positions a particular actor has been in
```

### Open Source Projects using this

 * [nZEDb](https://github.com/nZEDb/nZEDb) Website Link: http://www.nzedb.com/
