<div>
    <flux:modal name="project-form-modal" class="md:w-96" wire:close="onModalClose">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $form->id ? __('Edit Project') : __('Add Project')}}</flux:heading>
            </div>
        </div>

        <form method="project" wire:submit.prevent="save" class="mt-6 space-y-6">
            <flux:input wire:model="form.name" :label="__('Name')" type="text" required autocomplete="name" />
            
            <flux:textarea wire:model="form.description" :label="__('Description')" rows="auto" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="save-project-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="projectSaved">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </flux:modal>
</div>