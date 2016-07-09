<?php 
namespace Academic\Http\Controllers;

use Academic\Services\GoogleService;

use Session;

class HomeController extends Controller {

	public function __construct() {
		$service = new GoogleService();
        $client = $service->getClient();
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

}
