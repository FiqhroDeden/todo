<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;

class TodoList extends Component
{
    public $todos;
    public $newTodo = '';

    public function mount()
    {
        $this->todos = Todo::orderBy('created_at', 'desc')->get();
    }

    public function addTodo()
    {
        $this->validate([
            'newTodo' => 'required|min:3'
        ]);

        Todo::create([
            'content' => $this->newTodo,
            'completed' => false
        ]);

        $this->newTodo = '';
        $this->todos = Todo::orderBy('created_at', 'desc')->get();

        // Dispatch browser event for Alpine.js
        $this->dispatch('todo-added');
    }

    public function toggleComplete($todoId)
    {
        $todo = Todo::find($todoId);
        $todo->completed = !$todo->completed;
        $todo->save();

        $this->todos = Todo::orderBy('created_at', 'desc')->get();
    }

    public function deleteTodo($todoId)
    {
        Todo::find($todoId)->delete();
        $this->todos = Todo::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
