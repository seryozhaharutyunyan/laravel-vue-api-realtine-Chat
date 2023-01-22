<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edge extends Model
{
    use HasFactory;

    protected $table='edges';
    public $timestamps=false;
    protected $guarded=false;
    protected $with=['country'];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
