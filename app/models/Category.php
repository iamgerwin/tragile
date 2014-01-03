<?php

class Category extends Eloquent {

    protected $guarded = array();
    protected $table = 'category';
    public $primaryKey = 'CategoryId';
    public static $rules = array();
    public $timestamps = false;

}