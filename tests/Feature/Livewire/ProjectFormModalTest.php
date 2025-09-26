<?php

use App\Livewire\ProjectFormModal;
use Livewire\Livewire;
use App\Models\User;

it('renders successfully', function () {
    Livewire::test(ProjectFormModal::class)
        ->assertStatus(200);
});

it('creates  a project when the save method is called with valid data', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(ProjectFormModal::class)
            ->set('form.name', 'My Test Project')
            ->set('form.description', 'Project description')
            ->call('save')
            ->assertDispatched('projectSaved');

        $this->assertDatabaseHas('projects', [
            'name' => 'My Test Project',
            'description' => 'Project description',
        ]);

});

it('updates a project when the save method is called with an existing project ID', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = \App\Models\Project::factory()->for($user)->create([
            'name' => 'Old Project Name',
            'description' => 'Old description',
        ]);

        Livewire::test(ProjectFormModal::class, ['project' => $project])
            ->set('form.id', $project->id) // important for hitting update branch
            ->set('form.name', 'Updated Project')
            ->set('form.description', 'Updated description')
            ->call('save')
            ->assertDispatched('projectSaved');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ]);
});