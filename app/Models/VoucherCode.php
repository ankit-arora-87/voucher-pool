<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Recipient;
use App\Models\VoucherCodeAssignment;

class VoucherCode extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'expired_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
	/**
     * Get the assigned voucher codes.
     */
    public function voucherCodeAssignment()
    {
        return $this->hasMany('App\Models\VoucherCodeAssignment');
    }
	
	/**
     * Get the redeemed voucher codes of recipients.
     */
    public function voucherCodeRedemption()
    {
        return $this->hasMany('App\Models\VoucherCodeRedemption');
    }
	
	/**
     * Get all the assigned voucher codes for recipient.
     */
    static public function assignedVoucherCodes($email)
    {
        
		$voucher_codes = DB::table('voucher_code_assignment as vca')
					->select(['vc.code', 'vc.expired_at', 'o.name as offer', 'o.discount'])
					->join('voucher_codes as vc', 'vca.voucher_code_id', '=', 'vc.id')
					->join('offers as o', 'vca.offer_id', '=', 'o.id')
					->join('recipients as r', 'vca.recipient_id', '=', 'r.id')
					->where(['r.email' => $email])
					->get();
		return $voucher_codes;
    }


	/**
	* To generate voucher code
	*/
	static public function generateVoucherCode($request){
		
		DB::beginTransaction();
		$voucher_code_bytes = random_bytes(8);
		$voucher_code = bin2hex($voucher_code_bytes);
		try{
			$new_voucher_code = DB::table('voucher_codes')->insert([
				'code' => $voucher_code,
				'expired_at' => $request->input('expiration_date')
			]);
		
			$new_voucher_code_assignment = DB::table('voucher_code_assignment')->insert([
				'voucher_code_id' => DB::getPdo()->lastInsertId(),
				'offer_id' => $request->input('offer_id'),
				'recipient_id' => Recipient::where(['email' => $request->input('email')])->first()->id,
				'no_of_usage' => 1
			]);
			DB::commit();
			return true;
		}
		catch(\Exception $e){
			DB::rollback();
			return false;
		}
	}
}