<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $guarded=false;
    protected $table='chats';
    protected $with=['edge'];

    public function edge(){
        return $this->belongsTo(Edge::class, 'edge_id', 'id');
    }
}
