<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('project-form');

    $component->assertSee('');
});
