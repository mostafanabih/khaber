<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentWithOffer extends Model
{
    protected $table = 'appointment_with_offers';
    protected $fillable=[
        'patient_name','phone','offer_id'
    ];

   
}
