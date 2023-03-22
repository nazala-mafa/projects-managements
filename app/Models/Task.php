<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'deadline',
        'user_assign',
        'image'
    ];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_assign', 'id');
    }
}