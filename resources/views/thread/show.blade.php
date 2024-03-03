<x-app-layout>
    <!-- Título de la página -->
    @section('title', $thread->title)

    <div class="container mx-auto px-4 mt-4 flex flex-col">

        <!-- Logica de mostrar acciones -->
        @php
            $isUserAdminOrThreadCreator = Auth::user()->isAdmin() || ($thread->user->id ?? null) == Auth::id() ;
            $actions = [
                ['condition' => $isUserAdminOrThreadCreator && !$thread->isClosed(), 'route' => 'thread.close', 'text' =>  __('Close Thread')],
                ['condition' => $isUserAdminOrThreadCreator && $thread->isClosed(), 'route' => 'thread.open', 'text' =>  __('Open Thread')],
                ['condition' => $isUserAdminOrThreadCreator, 'route' => 'thread.delete', 'text' => __('Delete Thread')],
            ];
            $confirmationMessage = __("are_you_sure");
        @endphp

        <!-- Contenedor de los botones -->
        <div class="flex mt-auto">

            <!-- Boton de volver -->
            <div class="flex flex-wrap">
                <a href="{{ route('main') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 mb-2">
                    {{ __('Back') }}
                </a>
            </div>

            <!-- Botones de acciones con formularios de envio -->
            <div class="flex flex-wrap ml-auto">
                @foreach ($actions as $action)
                    @if ($action['condition'])
                        <!-- <form method="POST" action="{{ route($action['route'], $thread->id) }}" onsubmit="return confirm('{{ $confirmationMessage }}');" class="mr-2 mb-2 mt-2 mb-2">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ $action['text'] }}
                            </button>
                        </form> -->
                        <x-mis-componentes.script-aler-component 
                            :route="route($action['route'], $thread->id)"
                            :buttonText="$action['text']"
                        />
                    @endif
                @endforeach
            </div>

        </div>

        <!-- Comentarios y hilo -->
        <div class="bg-[#f5f0d5] shadow overflow-hidden sm:rounded-lg mb-4 mt-5">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h2 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $thread->title }}
                </h2>
                @if($thread->is_closed)
                    <i class="fas fa-lock text-red-500"></i>
                @endif
            </div>
            <div class="border-t border-gray-200">
                <dl>
                @foreach ($comments->sortBy('created_at') as $index => $comment)
                    <div class="{{ $index % 2 == 0 ? 'bg-blue-50' : 'bg-green-50' }} px-4 py-5 rounded-lg shadow-md grid grid-cols-12 gap-4 sm:px-6 mb-4">
                        <dt class="text-sm font-medium text-gray-700 col-span-2 flex items-center space-x-4">
                            <img src="{{ asset('storage/avatars/' . ($comment->user->avatar ?? 1 )) }}" alt="User Avatar" class="w-20 h-20 object-cover rounded-full border-2 border-blue-500" />
                            <div>
                                @isset($comment->user)
                                    <a href="{{ route('user.show', $comment->user->id) }}" class="text-lg text-blue-700 font-semibold">{{ $comment->user->name }}</a>
                                @else
                                    <span class="text-lg text-blue-700 font-semibold">{{ __('Deleted User') }}</span>
                                @endisset
                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 col-span-10 bg-white p-4 rounded-lg shadow-sm">
                            {{ $comment->content }}
                        </dd>
                        <div class="flex justify-end">
                            @if ($comment->user_id == Auth::id() || Auth::user()->isAdmin())
                                <form method="POST" action="{{ route('comment.delete', $comment) }}" onsubmit="return confirm('{{ __('are_you_sure') }}');" class="mr-2 mb-2 mt-2 mb-2" id="eliminarcomment">
                                    @csrf
                                    @method('DELETE')
                                        <x-mis-componentes.boton-alert 
                                        text="{{ __('Delete') }} "
                                        idsubmit="eliminarcomment"
                                        />
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                </dl>
            </div>
        </div>

        <!-- Boton de crear comentario -->
        @if (!$thread->isClosed())
            <div class="mt-4" x-data="{ open: false }">
                <button @click="open = !open" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" x-text="open ? '{{ __('Close') }}' : '{{ __('Add Comment') }}'">
                </button>

                <div x-show="open" class="mt-2">
                    <form method="POST" action="{{ route('comment.store', $thread->id) }}">
                        @csrf
                        <textarea name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Enter your comment') }}"></textarea>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 mb-3">
                            {{ __('Submit') }}
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Todos los errores tanto de validacion como de sesion -->
        <x-input-error :messages="$errors->all()" class="mt-2" />

        <!-- Paginacion de comentarios -->
        {{ $comments->links() }}
    </div>
</x-app-layout>