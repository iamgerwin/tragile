<?php
class Gerwin {
	public static function randomString($length = 6)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	public static function conDate($date)
	{
		$d = explode('-', $date);
	  	return date("Y-m-d H:i:s", mktime(0, 0, 0, $d['0'], $d['1'], $d['2']));
	}
	public static function fromToDate($date){
		$dateInput = date(Gerwin::conDate($date));
		$lastDate = date('Y-m-t H:i:s', strtotime($dateInput));
		if(date('d', strtotime($dateInput)) > 15) {
			$r['to'] =$lastDate;
			$r['from'] =date('Y-m-16 H:i:s', strtotime($dateInput));
		} else {
			$r['to'] =date('Y-m-15 H:i:s', strtotime($dateInput));
			$r['from'] =date('Y-m-01 H:i:s', strtotime($dateInput));
		}
		return $r;
	}
	public static function selloutValidation($msg)
	{
	//ssr sellout promoterId,employeeId,sidr,dateSold;modelId#serial,modelId#serial	

		//Employee Id Validation
		//greater tha dateSold to now
		
		$e1 = explode(';', $msg); #2
		$e2 = explode(',', $e1[0]); #4 promoterId, employeeId, sidr,dateSold
		if(!isset($e2[0])){
			return 'insufficient data promoterId';
		}
		if(!isset($e2[1])){
			return 'insufficient data employeeID';
		}
		if(!isset($e2[2])){
			return 'insufficient data SIDR';
		}
		if(!isset($e2[3])){
			return 'insufficient data dateSold';
		}
		$e3 = explode(',', $e1[1]); #!2
		for($i=count($e3)-1;$i>=0;$i--) {
			$e4[] = explode('#', $e3[$i]); #2 modelId, serial $e4[$g][0] $e4[$g][1]
		}
		$g = 0;
		$pInfo= Promoter::where('PromoterId',$e2[0])->count();
		if($pInfo == 0) {
			return 'none existing promoterId '.$e2[0];
		}

		while(count($e4) > $g) {
			if(!isset($e4[$g][0])) {
				return 'insufficient data modelid';
			}
			$modelInfo = Model::where('ModelId',$e4[$g][0])->count();
			$srpInfo = Srpmodel::where('ModelId',$e4[$g][0])->count();
			if($modelInfo == 0) {
				return 'none existing modelId '.$e4[$g][0];
			}
			if($srpInfo == 0) {
				return 'none existing Srpprice for modelId '.$e4[$g][0];
			}
			if(!isset($e4[$g][1])) {
				return 'insufficient data serial';
			}
		$g++;
		}
		return 1;
	}
}