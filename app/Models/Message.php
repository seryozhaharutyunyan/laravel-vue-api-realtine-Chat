<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table='messages';
    public $timestamps=false;
    protected $guarded=false;
    protected $with=['user'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
