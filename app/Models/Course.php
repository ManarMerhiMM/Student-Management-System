<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'name',
        'instructor_name',
        'description',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
