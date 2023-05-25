<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Candidato extends Model
{
    use HasFactory;

    protected $table = 'Candidato';

    protected $fillable = [
        'name',
        'source',
        'owner',
        'created_by',
    ];

    protected $hidden = [        
        'updated_at',
    ];


    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner');
    }


}
