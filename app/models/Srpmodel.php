<?php

class Srpmodel extends Eloquent {

    protected $guarded = array();
    protected $table = 'srpmodel';
    public $primaryKey = 'SRPId';
    public static $rules = array();
    public $timestamps = false;

}