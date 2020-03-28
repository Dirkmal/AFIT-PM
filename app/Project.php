<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = [
        'title', 'summary', 'status', 'due_date'
    ];

    protected $attributes = [
        'status' => false
    ];

    public function members() {
        return $this->belongsToMany('App\User', 'project_member', 'project_id', 'user_id');
    }
}
