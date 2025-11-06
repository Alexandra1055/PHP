<?php
use Illuminate\Support\Collection;

require BASE_PATH . '/../vendor/autoload.php';

$numbers= new Collection([
    1,2,3,4,5,6,7,8,9,10
]);

//si hacemos $numbers->filter(); usaremos array filter de php
