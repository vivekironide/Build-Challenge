<?php

use App\Models\Task;
use Livewire\Volt\Component;

new class extends Component {

    public string $title = '';

    public function addTask(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $this->title,
        ]);

        $this->reset('title');
    }

    public function toggle(int $id): void
    {
        $task = Task::findOrFail($id);
        $task->update(['completed' => ! $task->completed]);
    }

    public function with(): array
    {
        return [
            'tasks' => Task::latest()->get(),
        ];
    }

}; ?>

<div>
    <form wire:submit="addTask">
        <input wire:model="title" type="text" placeholder="New task…" />
        <button type="submit">Add</button>
    </form>

    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <ul>
        @foreach ($tasks as $task)
            <li>
                <input
                    type="checkbox"
                    wire:click="toggle({{ $task->id }})"
                    @checked($task->completed)
                />
                {{ $task->title }}
            </li>
        @endforeach
    </ul>
</div>
