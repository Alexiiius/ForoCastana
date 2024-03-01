<section id="language-update-status" >
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Language Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your preferred language.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.changeLang') }}" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div>
            <x-input-label for="language" :value="__('Language')" />

            <select id="language" name="language" class="mt-1 block w-full">
                <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                <option value="es" {{ $user->language == 'es' ? 'selected' : '' }}>{{ __('Spanish') }}</option>
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('language')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'language-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-[#b39c7e] dark:text-[#b39c7e]"
                >{{ __('Language updated.') }}</p>
            @endif
        </div>
    </form>
</section>