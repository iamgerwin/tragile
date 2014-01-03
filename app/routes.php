<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::controller('send', 'SendController');
Route::controller('receive','ReceiveController');

Route::get('test',function()
{
	//inquire dealer[], branch[dealerid], promoter[dealerid,branchid],category,model[optionalCategoryId]
	//dd( Sms::interpretMessage('as'));	
	//sellout
	//$now = date(Gerwin::conDate('11-19-13'));
	//echo date('d', strtotime($now));
//print_r(Sms::interpretMessage('sellout 1919,emp-19,888,11-19-13;1212#xyz,1111#abc'));
	print_r(Sms::interpretMessage('sellout 1919,emp-19,888,11-19-13;0111#g3r'));
});

Route::get('pdf', function()
{
	    $html = '<html><body>'
	            . '<p>Put your html here, or generate it with your favourite '
	            . 'templating system.</p>'
	            . '</body></html>';
	    $file = PDF::load($html, 'A4', 'portrait')->download('my_pdf');

	$ftp = ftp_connect('fiametta.ph','21','180');
	ftp_login('fiametta.ph','kelvin@fiametta.ph','kelvin14');

	$ret = ftp_nb_put($ftp, '/', $file, FTP_BINARY, FTP_AUTORESUME);
	while (FTP_MOREDATA == $ret)
	{
	  // display progress bar, or someting
	  $ret = ftp_nb_continue($ftp);
	}

});

