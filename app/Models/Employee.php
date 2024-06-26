<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "employees";

    protected $fillable = ['fname','lname','email','company_id','phone'];

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
