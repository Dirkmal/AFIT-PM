<?php

use Illuminate\Database\Seeder;

class ProjectMemberSeedr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $projects = App\Project::all();

        App\User::all()->each(function ($user) use ($projects) {
            $user->projects()->attach(
                $projects->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
