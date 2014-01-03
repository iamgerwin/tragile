<?php

class Tragile {
	
	public static function addSellout($msg)
	{
		//ssr sellout promoterId,employeeId,sidr,dateSold;modelId#serial,modelId#serial
		$g = Gerwin::selloutValidation($msg);
		if($g != 1){
			return $g;
		}
		
		$e1 = explode(';', $msg); #2
		$e2 = explode(',', $e1[0]); #4 promoterId, employeeId, sidr,dateSold
		$e3 = explode(',', $e1[1]); #!2
		for($i=count($e3)-1;$i>=0;$i--) {
			$e4[] = explode('#', $e3[$i]); #2 modelId, serial $e4[$g][0] $e4[$g][1]
		}
		$g = 0;
		$pInfo= Promoter::find($e2[0]);
		
		$now = date("Y-m-d H:i:s");
		$ds = $e2[3];
		$dateSold = Gerwin::conDate($ds);
		$dateRange = Gerwin::fromToDate($ds);

		while(count($e4) > $g) {
			$model = Model::find($e4[$g][0]);
			$srp = Srpmodel::where('ModelId',$e4[$g][0])->pluck('SRPPrice');
			if($e2[2] == 'na'|| $e2[2] == '' ){
				$e2[2]= Gerwin::randomString();
			}
			Sellout::insert([
				'DealerId' => $pInfo->DealerId,
				'BranchId' => $pInfo->BranchId,
				'PromoterId' => $e2[0],
				'ModelId' => $e4[$g][0],
				'Serial' => $e4[$g][1],
				'SIDR'=> $e2[2],
				'ItemPrice' => $model->Price,
				'SRPPrice' => $srp,
				'Category'=> $model->CategoryId,
				'Remarks'=> 'sms',
				'DateSold' => $dateSold,
				'DateCoveredFrom' => $dateRange['from'],
				'DateCoveredTo' => $dateRange['to'],
				'Delivery' => 1,
				'UserId'=> $e2[1],
				'DateEntry'=> $now
				]);
		$g++;
		}
		return "Successfully added sellout SIDR: ".$e2[2];
	}
	public static function cancelSellout($msg)
	{
		//ssr cancelsellout sidr,promoterid,employeeid
		$e1= explode(',', $msg);
		$check = Sellout::where('SIDR',$e1[0])->where('UserId',$e1[2])->where('PromoterId',$e1[1])->count();

		if($check != 0) {
			Sellout::where('SIDR',$e1[0])->where('UserId',$e1[2])->where('PromoterId',$e1[1])->delete();
			return 'Successfully deleted SIDR: '.$e1[0];
		} else {
			return 'No existing SIDR: '.$e1[0].' of PromoterId '.$e1[1].' EmployeeId '.$e1[2];
		}	
	}
	public static function helpReport($msg)
	{
		return $msg;
	}
	private static function _insertSellout($dealerId, $branchId, $promoterId, $modelId, $serial, $sidr, $itemPrice, $srpPrice, $category, $remarks, $dateSold, $dateCoveredFrom, $dateCoveredTo, $delivery, $userId, $dateEntry)
	{

	}
	private static function _deleteSellout($sidr)
	{

	}
	public static function insertInbox($from,$msg)
	{
		$now = date("Y-m-d H:i:s");
		return Inbox::insert([
			'from' =>$from,
			'content' =>$msg,
			'datereceive' => $now
			]);
	}
}