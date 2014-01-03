<?php

class User extends Eloquent {

    protected $guarded = array();
    protected $table = 'users';
    public $primaryKey = 'UserId';
    public static $rules = array();
    public $timestamps = false;

}