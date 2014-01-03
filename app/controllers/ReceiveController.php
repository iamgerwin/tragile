<?php

class ReceiveController extends BaseController {

    public function postTest()
    {

    }

    public function postCapture()
    {
 	#from
 	#msg
 	#ts
 	$input = Input::all();
 	Tragile::insertInbox($input['from'],$input['msg']);

 	$reply = Sms::interpretMessage($input['msg'],$input['from']);

 	$c = count($reply);
 	if(!is_array($reply)) {
 		return Sms::sendIt($input['from'],$reply);
 	}

 	for($i= ($c -1);$i>=0;$i--)
 	{
 		$r[] = Sms::sendIt($input['from'],$reply[$i]);
 	}
 	return implode("\n", $r);
    }

}