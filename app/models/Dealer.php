<?php

class Dealer extends Eloquent {

    protected $guarded = array();
    protected $table = 'dealer';
    public $primaryKey = 'DealerId';
    public static $rules = array();
    public $timestamps = false;

	public static function getDealerIdName()
	{
		$self = new Dealer();
		return $self->DealerId;
	}

}