<div x-data="{statusFilter: ''}">
    <div class="mb-4 flex items-center justify-between">
        <flux:modal.trigger name="project-form-modal">
            <flux:button variant="primary" type="button" size="xs" icon="plus">
                {{__('Add Project')}}
            </flux:button>
        </flux:modal.trigger>

        <div>
            <flux:select x-model="statusFilter" :placeholder="__('Choose status...')" size="xs">
                <flux:select.option value="">{{ __('All') }}</flux:select.option>

                @foreach ($taskStatuses as $value => $label)
                    <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>

    @unless ($projects->isEmpty())
        @foreach($projects as $project)
            <div class="border-b border-neutral-200 px-4 py-2 last:border-0 dark:border-neutral-700" :key="$project->id"
                x-data="{ open: true }">
                <div class="mb-1 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-blue-600">
                        {{ $project->name }}
                    </h3>
                    <div class="flex items-center gap-2">
                        <flux:modal.trigger name="task-form-modal">
                            <flux:button variant="primary" color="green" type="button" size="xs" icon="plus"
                                wire:click="$dispatch('addTask', { 'project_id': {{ $project->id }} })">
                                {{__('Add Task')}}
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:button variant="primary" color="blue" type="button" size="xs" icon="pencil"
                            wire:click="$dispatch('editProject', { 'project_id': {{ $project->id }} })">
                            {{__('Edit')}}
                        </flux:button>

                        <flux:button variant="primary" color="red" type="button" size="xs" icon="trash"
                            wire:click="deleteProject({{ $project->id }})">
                            {{__('Delete')}}
                        </flux:button>

                        <flux:button color="neutral" type="button" :tooltip="__('Toggle Tasks')" size="xs" icon="chevron-down"
                            class="transition-transform duration-200" x-on:click="open = ! open"
                            x-bind:class="{ 'rotate-180': open }">
                            <span class="sr-only">{{ __('Toggle Tasks') }}</span>
                        </flux:button>
                    </div>
                </div>

                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $project->description }}
                </p>

                @if($project->tasks->isNotEmpty())
                    <div class="mt-2" x-show="open">
                        <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            {{ __('Tasks') }}
                        </h4>

                        <table class="mt-1 w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1">{{ __('Title') }}</th>
                                    <th class="px-2 py-1">{{ __('Status') }}</th>
                                    <th class="px-2 py-1">{{ __('Due Date') }}</th>
                                    <th class="px-2 py-1">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->tasks as $task)
                                    <tr x-show="!statusFilter || statusFilter === '{{ $task->status }}'">
                                        <td class="px-2 py-1">{{ $task->title }}</td>
                                        <td class="px-2 py-1">
                                            {{ $taskStatuses[$task->status] }}
                                        </td>
                                        <td class="px-2 py-1">
                                            {{ $task->due_date ? $task->due_date->format('M d, Y') : __('No due date') }}
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="flex items-center gap-2">
                                                <flux:button variant="primary" color="blue" type="button" size="xs" icon="pencil"
                                                    wire:click="$dispatch('editTask', { 'task_id': {{ $task->id }} })">
                                                    {{__('Edit')}}
                                                </flux:button>

                                                <flux:button variant="primary" color="red" type="button" size="xs" icon="trash"
                                                    wire:click="deleteTask({{ $task->id }})">
                                                    {{__('Delete')}}
                                                </flux:button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach

        <div class="mt-4">
            {{ $projects->links() }}
        </div>
    @else
        <p class="p-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
            {{ __('You have no projects yet.') }}
        </p>
    @endunless

    <livewire:project-form-modal />
    <livewire:task-form-modal />
</div>