<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'arrangement_fee', 
        'interest_rate',
        'term',
        'frequency',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function repayments()
    {
    	return $this->hasMany(Repayment::class);
    }
}
