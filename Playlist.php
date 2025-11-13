<?php


class Playlist
{
    public $name;
    public $songs;

    public function __construct(public string $name, public array $songs)
    {
        //$this->name = $name;
        //$this->songs = $songs;
    }

}

class Song{
    public function __construct(public string $name, public string $artist ){

    }
}


/*
$playlist = new Playlist("80s Headbangers", [
    'Black in Black',
    'Are you ready',
    'Hells Bells',
    'Highway to Hell'
]);
*/

$songs = [
    new Song('My Heart Will Go On','Celine Dion')
];

$playlist = new Playlist('90s Movie Soundtracks',$songs);

var_dump($playlist->songs[0]->artist);