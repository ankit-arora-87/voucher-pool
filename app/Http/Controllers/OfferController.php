<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
	/**
	* To get all offers
	*/
    public function showAllOffers()
    {
        return response()->json(Offer::all());
    }

}