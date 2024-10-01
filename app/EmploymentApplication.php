<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentApplication extends Model
{
    protected $fillable=[
        'name','phone','job_title','certificate_file'
    ];

    
}
