<section id="avatar-update-status" >
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Avatar Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your avatar image.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.changeAvatar') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div>
            <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                {{ __('Avatar') }}
            </label>
            <input type="file" name="avatar">
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-[#b39c7e] dark:text-[#b39c7e]"
                >{{ __('Avatar updated.') }}</p>
            @endif
        </div>
    </form>
</section>