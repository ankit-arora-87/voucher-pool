<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
	/**
     * Get the assigned voucher codes of recipients.
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
	
}