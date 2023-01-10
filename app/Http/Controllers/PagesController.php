<?php

namespace App\Http\Controllers;

use Illuminate\http\Request;
use Dcblogdev\MsGraph\Facades\MsGraph;

class PagesController extends Controller
{
	public function app(){
		dd(MsGraph::get('me'));
	}
}