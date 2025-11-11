<?php


class Playlist
{
    public $name;
    public $songs;

    public function __construct($name, $songs)
    {
        $this->name = $name;
        $this->songs = $songs;
    }

}


$playlist = new Playlist("80s Headbangers", [
    'Black in Black',
    'Are you ready',
    'Hells Bells',
    'Highway to Hell'
]);

die(var_dump($playlist));
