<x-app-layout>
    <div class="container mx-auto px-4 mt-4">

    <!-- Boton crear hilo -->
        <div class="mt-4" x-data="{ open: false }">
            <button @click="open = !open" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2" x-text="open ? '{{ __('Close') }}' : '{{ __('Create Thread') }}'">
            </button>
            <x-input-error :messages="$errors->all()" class="mt-2 mb-2" />

            <div x-show="open" class="mt-2">
                <form method="POST" action="{{ route('thread.store') }}">
                    @csrf
                    <input type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Enter the title') }}">
                    <textarea name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Enter your comment') }}"></textarea>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 mb-3">
                        {{ __('Submit') }}
                    </button>
                </form>
            </div>

        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-1/2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Threads') }}
                    </th>
                    <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Comments') }}
                    </th>
                    <th class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('Last Comment') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($threads as $thread)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-medium text-gray-900">
                                <a href="{{ route('thread.show', $thread->id) }}">{{ $thread->title  }}</a>
                                @if($thread->is_closed)
                                    <i class="fas fa-lock"></i>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ __('By') }}: 
                                @isset($thread->user)
                                    <a href="{{ route('user.show', $thread->user->id) }}">{{ $thread->user->name }}</a>
                                @else
                                    <span>{{ __('Deleted User') }}</span>
                                @endisset
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $thread->comments()->count() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($latestComment = $thread->latestComment())
                            <div class="text-sm text-gray-900">
                                @isset($latestComment->user)
                                    {{ $latestComment->user->name }}
                                @else
                                    {{ __('Deleted User') }}
                                @endisset
                            </div>
                                <div>{{ $latestComment->created_at->translatedFormat('d F Y H:i') }}</div>
                            @else
                                <div class="text-sm text-gray-900"> {{ __('There are no comments yet.') }}  </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Boton de logout -->
        <!-- <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Logout</button>
        </form> -->

        <div class="mt-4">
            {{ $threads->links() }}
        </div>
    </div>
</x-app-layout>