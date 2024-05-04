<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="companies";

    public function employee(){
        return $this->hasMany(Employee::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($company) {
            $company->employee()->delete();
        });
    }
}
