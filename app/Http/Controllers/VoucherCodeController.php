<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Recipient;
use App\Models\VoucherCode;
use App\Models\VoucherCodeRedemption;
use Validator;

class VoucherCodeController extends Controller
{
	/**
	* To fetch all assigned voucher codes for a recipient (not used)
	* params - email
	*/
    public function showAssignedVoucherCodes(Request $request)
    {
		$isValidRule = Validator::make($request->all(),[
			'email' => 'required|email|max:255|exists:recipients',
			]);
		if(!$isValidRule->fails()){
			return response()->json(VoucherCode::assignedVoucherCodes($request->input('email')));
		}
		else{
			return response()->json($isValidRule->errors());
		}
    }
	
	/**
	* To generate voucher code from provided offer, email (recipient) & expiration date
	* params - email, offer_id, expiration_date
	*/
	public function generateVoucherCode(Request $request){
		
		$isValidRule = Validator::make($request->all(),[
        'email' => 'required|email|max:255|exists:recipients',
        'offer_id' => 'required|int|exists:offers,id',
		'expiration_date' => 'required|date'
		]);
		if(!$isValidRule->fails()){
			$isVoucherCodeGenerated = VoucherCode::generateVoucherCode($request);
			if($isVoucherCodeGenerated){
				return response()->json(['message' => 'Voucher code generated successfully.']);
			}
			else{
				return response()->json(['message' => 'Voucher code not generated.'], 400);
			}
		}
		else{
			return response()->json($isValidRule->errors());
		}
	}
	
	/**
	* To redeem voucher for a specific recipient (email)
	* params - email, voucher_code
	*/
	public function redeemVoucherCode(Request $request){
		$isValidRule = Validator::make($request->all(),[
			'email' => 'required|email|max:255|exists:recipients',
			'voucher_code' => ['required','exists:voucher_codes,code',
			function($attribute, $value, $fail) use ($request) {
				$voucher_codes_validity = DB::table('voucher_code_assignment as vca')
						->join('voucher_codes as vc', 'vca.voucher_code_id', '=', 'vc.id')
						->join('recipients as r', 'vca.recipient_id', '=', 'r.id')
						->where(['r.email' => $request->input('email'), 'vc.code' => $value])
						->count();
			return ($voucher_codes_validity > 0)?true:$fail(':attribute is not valid.');
        },
		function($attribute, $value, $fail) use ($request) {
				$voucher_codes_utilized = DB::table('voucher_code_assignment as vca')
						->join('voucher_codes as vc', 'vca.voucher_code_id', '=', 'vc.id')
						->join('recipients as r', 'vca.recipient_id', '=', 'r.id')
						->join('voucher_code_redemption as vcr', ['vca.voucher_code_id' => 'vcr.voucher_code_id', 
						'vca.recipient_id' => 'vcr.recipient_id'])
						->where(['r.email' => $request->input('email'), 'vc.code' => $value])
						->count();		
			return ($voucher_codes_utilized == 0)?true:$fail(':attribute is already utilized.');
		}
		]]);
			if(!$isValidRule->fails()){
				$isVoucherCodeRedeemed = VoucherCodeRedemption::redeemVoucherCode($request);
				if($isVoucherCodeRedeemed){
					return response()->json(['message' => 'Voucher code redeemed successfully.']);
				}
				else{
					return response()->json(['message' => 'Voucher code not redeemed.'], 400);
				}
			}
			else{
				return response()->json($isValidRule->errors());
			}	
	}

}