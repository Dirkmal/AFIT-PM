<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // title: string;
	// summary: string;
	// status: Status;
	// deadline: Date;
	// pending_tasks: number;
	// completed_tasks: number;
	// task_total: number;
	// date_created: string;
	// due_date: string;
    // members: User[];
    const CREATED_AT = 'date_created';
    protected $fillable = [
        'title', 'summary', 'status', 'deadline', 'due_date'
    ];

    protected $attributes = [
        'status' => false
    ]
}
