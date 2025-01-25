<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button class="btn btn-danger" type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </button>

    <div x-data="{ show: false }" x-show="show" x-on:open-modal.window="if ($event.detail === 'confirm-user-deletion') show = true" x-on:close.window="show = false" x-on:keydown.escape.window="show = false" style="display: none;">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" value="{{ __('Password') }}" class="sr-only">

                <x-input name="password" type="password" :attr="['class' => 'form-control mt-1 block w-3/4', 'placeholder' => __('Password')]"/>
            </div>

            <div class="mt-6 flex justify-end">
                <button class="btn btn-secondary" type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button class="btn btn-danger ms-3" type="submit">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </div>
</section>
