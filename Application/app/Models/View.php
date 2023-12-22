<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    /**
     * Get the current user entries
     *
     * @return $id
     */
    public function scopeCurrentUser($query)
    {
        $query->where('user_id', userAuthInfo()->id);
    }
    public $timestamps = false;
    /**
     * Users entries
     *
     * @return $id
     */
    public function scopeUserEntry($query)
    {
        $query->where('user_id', '!=', null);
    }

    /**
     * Guests entries
     *

     */


    /**
     * None expired
     *
 
     */


    /**
     * Expired file entries
     *
  
     */


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'date',
        
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
