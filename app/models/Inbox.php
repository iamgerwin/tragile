<?php

class Inbox extends Eloquent {

    protected $guarded = array();
    protected $table = 'inbox';
    public $primaryKey = 'id';
    public static $rules = array();
    public $timestamps = false;

}