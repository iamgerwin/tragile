<?php

class Region extends Eloquent {

    protected $guarded = array();
    protected $table = 'region';
    public $primaryKey = 'RegionId';
    public static $rules = array();
    public $timestamps = false;

}