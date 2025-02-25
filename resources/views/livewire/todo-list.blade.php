<div class="max-w-2xl mx-auto mt-8 p-8 bg-white rounded-xl shadow-xl" x-data="{ showNotification: false }">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">My Tasks</h2>
        <div class="text-sm text-gray-500">
            {{ $todos->where('completed', true)->count() }}/{{ $todos->count() }} completed
        </div>
    </div>

    <form wire:submit.prevent="addTodo" class="mb-8">
        <div class="flex gap-3">
            <input type="text" wire:model="newTodo" x-on:keydown="showNotification = false"
                class="flex-1 px-6 py-3 bg-gray-50 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                placeholder="What needs to be done?">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                Add Task
            </button>
        </div>
        @error('newTodo')
            <div x-show="true" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-2 text-red-500 text-sm">
                {{ $message }}
            </div>
        @enderror
    </form>

    <div class="space-y-3">
        @foreach ($todos as $todo)
            <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200"
                x-data="{ hover: false }" x-on:mouseenter="hover = true" x-on:mouseleave="hover = false">
                <div class="flex items-center gap-4 flex-1">
                    <div class="relative">
                        <input type="checkbox" wire:click="toggleComplete({{ $todo->id }})"
                            @checked($todo->completed)
                            class="w-6 h-6 rounded-lg border-2 border-gray-300 focus:ring-blue-500 text-blue-600 transition-all duration-200 cursor-pointer">
                        <div x-show="hover && !{{ $todo->completed ? 'true' : 'false' }}" x-transition
                            class="absolute inset-0 bg-blue-100 rounded-lg opacity-30"></div>
                    </div>

                    <span
                        class="flex-1 {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-700' }} transition-all duration-200">
                        {{ $todo->content }}
                    </span>
                </div>

                <button wire:click="deleteTodo({{ $todo->id }})"
                    class="opacity-0 group-hover:opacity-100 p-2 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition-all duration-200"
                    x-transition>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endforeach

        @if ($todos->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p class="text-lg">No tasks yet</p>
                <p class="text-sm">Add a new task to get started</p>
            </div>
        @endif
    </div>

    <!-- Notification -->
    <div x-show="showNotification" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg">
        Task added successfully!
    </div>
</div>
