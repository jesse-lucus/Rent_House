<?php

namespace App\Http\Controllers\POC;

use App\Http\Controllers\Controller;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Agent;

class ApiTestController extends Controller
{

	public function __construct() {
		$this->allitapc();
	}
    public function index(Request $request)
    {
        $service = new DocumentService;

        $documents = $service->getDocuments();

        dd($documents);
    }
}
