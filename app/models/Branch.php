<?php

class Branch extends Eloquent {

    protected $guarded = array();
    protected $table = 'branch';
    public $primaryKey = 'BranchId';
    public static $rules = array();
    public $timestamps = false;

}