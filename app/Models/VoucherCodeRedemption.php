<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Recipient;
use App\Models\VoucherCode;

class VoucherCodeRedemption extends Model
{
	protected $table = "voucher_code_redemption";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'voucher_code_id', 'recipient_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['redeemed_at', 'created_at', 'updated_at'];
	
	
	/**
     * Get the recipients for the voucher code.
     */
    public function recipients()
    {
        return $this->belongsTo('App\Models\Recipient');
    }
	
	/**
     * Get the voucher code for the voucher code.
     */
    public function voucherCodes()
    {
        return $this->belongsTo('App\Models\VoucherCode');
    }	
	
	/**
	* To redeem voucher code
	*/
	static public function redeemVoucherCode($request){
		
		DB::beginTransaction();
		try{
			$voucher_code_redeemed = DB::table('voucher_code_redemption')->insert([
				'voucher_code_id' => VoucherCode::where(['code' => $request->input('voucher_code')])->first()->id,
				'recipient_id' => Recipient::where(['email' => $request->input('email')])->first()->id
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

