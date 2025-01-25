<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" :value="__('Current Password')">
            <x-input name="current_password" type="password" :attr="['class' => 'form-control mt-1 block w-full', 'autocomplete' => 'current-password']"/>
        </div>

        <div>
            <label for="update_password_password" :value="__('New Password')"> 
            <x-input name="password" type="password" :attr="['class' => ' form-control mt-1 block w-full', 'autocomplete' => 'new-password']"/>
        </div>

        <div>
            <label for="update_password_password_confirmation" :value="__('Confirm Password')">
            <x-input name="password_confirmation" type="password" :attr="['class' => ' form-control mt-1 block w-full', 'autocomplete' => 'new-password']"/>
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn-primary" type="submit">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
