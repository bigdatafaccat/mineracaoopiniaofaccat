<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Mongo extends Eloquent
{

    protected $connection = 'mongodb';

}
