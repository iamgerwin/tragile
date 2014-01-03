<?php

class Sellout extends Eloquent {

    protected $guarded = array();
    protected $table = 'sellout';
    public $primaryKey = 'SellOutId';
    public static $rules = array();
    public $timestamps = false;

}