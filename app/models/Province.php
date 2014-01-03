<?php

class Province extends Eloquent {

    protected $guarded = array();
    protected $table = 'province';
    public $primaryKey = 'ProvinceId';
    public static $rules = array();
    public $timestamps = false;

}