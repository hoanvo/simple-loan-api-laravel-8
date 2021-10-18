<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repayment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_amount',
        'balance',
        'payment_date',
    ];

    public $timestamps = false;


    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function loan()
    {
    	return $this->belongsTo(Loan::class);
    }
}
