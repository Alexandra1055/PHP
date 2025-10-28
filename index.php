<?php

require 'functions.php';

require 'router.php';

require 'DataBase.php';

$config = require('config.php');

$db = new DataBase($config['database']);
