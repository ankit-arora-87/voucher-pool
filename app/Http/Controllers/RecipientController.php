<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;

class RecipientController extends Controller
{

	/**
	* To get all recipients
	*/
    public function showAllRecipients()
    {
        return response()->json(Recipient::all());
    }

}