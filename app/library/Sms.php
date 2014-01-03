<?php

class Sms {
	
	public static function sendIt($to= '09323729873',$msg)
	{
		if(count($to) == 0)
		{
			$to = '09323729873';
		}
		                    $mcproGateway = 'http://122.52.163.202/mcproManager/public/gateway';            
		                    $postData = [
		                            "Keyword" => "GQksA",
		                            "To" => $to,
		                            "Msg" => $msg
		                        ];

		                         	$ch = curl_init($mcproGateway);
				            curl_setopt($ch, CURLOPT_POST, true);
				            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
				            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec($ch); 	            
	}

	public static function interpretMessage($msg,$from = '09323729873')
	{
		$arr = explode(' ',$msg);
		$key = strtoupper(array_shift($arr));

			if($key == 'INQUIRE') {
				$key2  = strtoupper(array_shift($arr));
				if($key2 == 'DEALER') {
					$i = Sms::inquireDealer();
					if($i == NULL){
						return 'none existing dealer';
					} else {
						return Sms::inquireDealer();
					}
				}
				else if($key2 == 'BRANCH') {
					if(!isset($arr[0])){
						return 'error insufficient data';
					}
					$i = Sms::inquireBranch($arr[0]);
					if($i == null) {
						return 'none existing branch';
					} else {
						return Sms::inquireBranch($arr[0]);
					}
				}
				else if($key2 == 'PROMOTER') {
					if(!isset($arr[0]) || !isset($arr[1])){
						return 'error insufficient data';
					}
					$i = Sms::inquirePromoter($arr[0],$arr[1]);
					if($i == null){
						return 'none existing promoter';
					} else {
						return Sms::inquirePromoter($arr[0],$arr[1]);
					}
				}
				else if($key2 == 'MODEL') {
					if(!isset($arr[0])){$k=null;}
					else{$k=$arr[0];}
					$i =  Sms::inquireModel($k);
					if($i == null){
						return 'none exisitng model';
					} else {
						return Sms::inquireModel($k);
					}
				}
				else if($key2 == 'CATEGORY') {
					$i = Sms::inquireCategory();
					if($i == null) {
						return 'none existing category';
					} else {
						return  Sms::inquireCategory();
					}
					
				}
				else
					return 'unknown inquiry';
			}
			else if($key == 'SELLOUT') {
				$msg = implode(' ', $arr);
				return Tragile::addSellout($msg);
			}
			else if($key == 'CANCELSELLOUT') {
				$msg = implode(' ', $arr);
				return Tragile::cancelSellout($msg);
			}
			else if($key == 'REPORT') {
				$header = 'Report from: '.$from."\nContent:";
				$msg = implode(' ', $arr);
				$msg = "$header $msg";
				echo Sms::sendIt('09323729873',$msg);
				die();
			}
			else {
				return 'unknown keyword';
			}
	}
	public static function inquireDealer()
	{
		$count = Dealer::count();
		if($count == 0){return NULL;}
		$txtc = ceil($count /60);
		$at = $txtc;
		$a = 1;
		$txts = 1;
		while($txtc > 0) {
			$ds =  Dealer::skip($txts)->take(60)->get(['DealerId','Dealer']);
				$data  = "List of Dealers $a of $at\n";
				foreach($ds as $d) {
					$data .="$d->DealerId - $d->Dealer\n";
				}
			$a++;
			$txts += 60;
			$txtc--;
		   $r[] = $data;
		}
		return $r;
	}
	public static function inquireCategory()
	{
		$count = Category::count();
		if($count == 0){return NULL;}
		$txtc = ceil($count /60);
		$at = $txtc;
		$a = 1;
		$txts = 1;
		while($txtc > 0) {
			$ds =  Category::skip($txts)->take(60)->get(['CategoryId','Category']);
				$data  = "List of Category $a of $at\n";
				foreach($ds as $d) {
					$data .="$d->CategoryId - $d->Category\n";
				}
			$a++;
			$txts += 60;
			$txtc--;
		   $r[] = $data;
		}
		return $r;
	}
	public static function inquireModel($categoryId = null)
	{
		if($categoryId == null){
			$count = Model::count();
			if($count == 0){return NULL;}
			$txtc = ceil($count /60);
			$at = $txtc;
			$a = 1;
			$txts = 1;
			while($txtc > 0) {
				
					$ds =  Model::skip($txts)->take(60)->get(['ModelId','Model']);
					$data  = "List of All Model $a of $at\n";
					foreach($ds as $d) {
						$data .="$d->ModelId - $d->Model\n";
					}
				$a++;
				$txts += 60;
				$txtc--;
			   $r[] = $data;
			}
			return $r;
		} else {
			$count = Model::where('CategoryId',$categoryId)->count();
			if($count == 0){return NULL;}
			$txtc = ceil($count /60);
			$at = $txtc;
			$a = 1;
			$txts = 1;
			while($txtc > 0) {
					$ds =  Model::where('CategoryId',$categoryId)->skip($txts)->take(60)->get(['ModelId','Model']);
					$cat = Category::find($categoryId);
					$data  = "List of Model of $cat->Category $a of $at\n";
					foreach($ds as $d) {
						$data .="$d->ModelId - $d->Model\n";
					}
				$a++;
				$txts += 60;
				$txtc--;
			   $r[] = $data;
			}

			return $r;
		}
	}
	public static function inquireBranch($dealerId = null)
	{
		$count = Branch::where('DealerId',$dealerId)->count();
		if($count == 0){return NULL;}
		$txtc = ceil($count /60);
		$at = $txtc;
		$a = 1;
		$txts = 0;
		$deal = Dealer::find($dealerId);
		while($txtc != 0) {
			$ds =  Branch::where('DealerId',$dealerId)->skip($txts)->take(60)->get(['BranchId','Branch']);
				$data  = "List of Branches of $deal->Dealer - $a of $at\n";
				foreach($ds as $d) {
					$data .="$d->BranchId - $d->Branch\n";
				}
			$a++;
			$txts += 60;
			$txtc--;
		   $r[] = $data;
		}
		return $r;
	}
	public static function inquirePromoter($dealerId = null,$branchId = null)
	{
		$count = Promoter::where('DealerId',$dealerId)->where('BranchId',$branchId)->count();
		if($count == 0){return NULL;}
		$txtc = ceil($count /60);
		$at = $txtc;
		$a = 1;
		$txts = 0;
		$deal = Dealer::find($dealerId);
		$bran = Branch::find($branchId);
		while($txtc != 0) {
			$ds =  Promoter::where('DealerId',$dealerId)->where('BranchId',$branchId)->skip($txts)->take(60)->get(['PromoterId','LastName','FirstName']);
				$data  = "List of Promoters of $deal->Dealer,$bran->Branch - $a of $at\n";
				foreach($ds as $d) {
					$data .="$d->PromoterId - $d->LastName, $d->FirstName\n";
				}
			$a++;
			$txts += 60;
			$txtc--;
		   $r[] = $data;
		}
		return $r;
	}
}