<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10 flex justify-center">
        <a href="/" class="btn btn-ghost px-0">
            <div class="flex items-center">
                <div class="w-10 mr-2">
                    <img src="https://placehold.co/400x400/3b82f6/white?text=IM" alt="Logo" class="w-full rounded-lg">
                </div>
                <span class="text-xl font-bold text-primary">Imobiliária<span
                        class="text-secondary">Premium</span></span>
            </div>
        </a>
    </div>

    <x-form wire:submit="login">
        <x-input placeholder="E-mail" wire:model="email" icon="o-envelope" />
        <x-input placeholder="Password" wire:model="password" type="password" icon="o-key" />

        <x-slot:actions>
            <x-button label="Create an account" class="btn-ghost" link="/register" />
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>
