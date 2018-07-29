<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherCodeAssignment extends Model
{
	protected $table = "voucher_code_assignment";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'offer_id', 'recipient_id', 'voucher_code_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
	/**
     * Get the offers for the voucher code.
     */
    public function offers()
    {
        return $this->belongsTo('App\Models\Offer');
    }
	
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
}

