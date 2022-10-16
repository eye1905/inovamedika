<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MedicalTreatment extends Model
{
    use HasFactory;
    protected $table = "medical_treatments";
    protected $primaryKey = "medical_id";

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'staff_id', 'staff_id');
    }

    public function pasien()
    {
        return $this->belongsTo('App\Models\Patients', 'patient_id', 'patient_id');
    }
}
