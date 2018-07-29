<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'discount'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
	/**
     * Get the assigned voucher codes of offers.
     */
    public function voucherCodeAssignment()
    {
        return $this->hasMany('App\Models\VoucherCodeAssignment');
    }
}