<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'reporter_id',
        'made_timestamp',
        'last_update_on',
        'assignee_id',
    ];

    // Relaties
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
