<?php

class Model extends Eloquent {

    protected $guarded = array();
    protected $table = 'model';
    public $primaryKey = 'ModelId';
    public static $rules = array();
    public $timestamps = false;

}