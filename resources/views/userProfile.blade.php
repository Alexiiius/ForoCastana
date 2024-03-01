<x-app-layout>
    <!-- Perfil publico del usuario -->
    @if(Auth::user()->isAdmin() && Auth::user()->id != $user->id && !$user->isAdmin())
        @if(!$user->isBlocked())

            <!-- Boton de banear usuario -->
            <div class="mt-4" x-data="{ open: false }">
                <button @click="open = !open" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3" x-text="open ? '{{ __('Close') }}' : '{{ __('Admin Actions') }}'">
                </button>

                <div x-show="open" class="mt-2 ml-3">
                    <form method="POST" action="{{ route('user.ban', $user->id) }}" id="banuser" >
                        @csrf
                        <label for="reason" class="text-sm text-gray-500">{{ __('Reason') }}</label>
                        <input type="text" name="reason" placeholder="{{ __('Reason') }}" class="w-full p-2 border border-gray-300 rounded mb-4" required />
                        <label for="ban_end" class="text-sm text-gray-500">{{ __('Ban end date') }}</label>
                        <input type="date" name="ban_end" class="w-full p-2 border border-gray-300 rounded mb-4" required />
                        <x-mis-componentes.boton-alert 
                            text="{{ __('Ban User') }}" 
                            idsubmit="banuser"
                        />
                    </form>
                </div>
            </div>
            <x-input-error :messages="$errors->all()" class="mt-2 ml-4" />
        @else
            <!-- Boton de desbanear usuario -->
            <form method="POST" action="{{ route('user.unban', $user->id) }}" id="unbanuser" >
                @csrf
                <x-mis-componentes.boton-alert 
                    text="{{ __('Unban User') }}" 
                    idsubmit="unbanuser"
                />
            </form>
        @endif
    @endif

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-4">
            <div class="max-w-xl">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile of ') }} {{ $user->name }}
                </h2>
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="User Avatar" class="w-20 h-20 object-cover rounded-full border-2 border-blue-500 mb-2 mt-2" />
                <div class="text-sm text-gray-500">
                    {{ __('Name') }}: {{ $user->name }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ __('Email') }}: {{ $user->email }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ __('Language') }}: {{ $user->language }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ __('Role') }}: {{ $user->role }}
                </div>
            </div>
        </div>

</x-app-layout>