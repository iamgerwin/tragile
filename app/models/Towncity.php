<?php

class Towncity extends Eloquent {

    protected $guarded = array();
    protected $table = 'towncity';
    public $primaryKey = 'TownCityId';
    public static $rules = array();
    public $timestamps = false;

}