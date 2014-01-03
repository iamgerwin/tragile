<?php

class Promoter extends Eloquent {

    protected $guarded = array();
    protected $table = 'promoter';
    public $primaryKey = 'PromoterId';
    public static $rules = array();
    public $timestamps = false;

}