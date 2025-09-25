<div>
    <flux:modal name="task-form-modal" class="md:w-96" wire:close="onModalClose">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $form->id ? __('Edit Task') : __('Add Task')}}</flux:heading>
            </div>
        </div>

        <form method="task" wire:submit.prevent="save" class="mt-6 space-y-6">
            <flux:input wire:model="form.title" :label="__('Title')" type="text" required autocomplete="title" />

            <flux:select wire:model="form.status" :label="__('Status')" required placeholder="Choose stauts...">
                <flux:select.option value="todo">Todo</flux:select.option>
                <flux:select.option value="in_progress">In Progress</flux:select.option>
                <flux:select.option value="done">Done</flux:select.option>
            </flux:select>

            <flux:input wire:model="form.due_date" :label="__('Due Date')" type="date" />

            <flux:input wire:model="form.project_id" type="hidden" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="save-task-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="taskSaved">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </flux:modal>
</div>