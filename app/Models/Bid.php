<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['email_id', 'subject', 'description', 'status'];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class)->withTimestamps();
    }

    public function classifications()
{
    return $this->belongsToMany(Classification::class)->withTimestamps();
}

 public function assignClassifications(Bid $bid, Email $email)
    {
        $subject = strtolower($email->subject);
        $classificationIds = [];

        // Example rules
        if (str_contains($subject, 'road')) {
            $classificationIds[] = Classification::firstOrCreate([
                'name' => 'Road Project',
                'type' => 'project_type'
            ])->id;
        }

        if (str_contains($subject, 'million')) {
            $classificationIds[] = Classification::firstOrCreate([
                'name' => 'High Value',
                'type' => 'value_range'
            ])->id;
        }

        if (str_contains($email->from_email, 'contractorx.com')) {
            $classificationIds[] = Classification::firstOrCreate([
                'name' => 'Contractor X',
                'type' => 'contractor'
            ])->id;
        }

        if ($classificationIds) {
            $bid->classifications()->syncWithoutDetaching($classificationIds);
        }
    }
}
