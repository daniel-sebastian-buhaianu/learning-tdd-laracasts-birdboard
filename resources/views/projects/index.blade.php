<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>
    
    <div class="flex items-center">
        <p class="text-2xl mr-auto">Birdboard</p>
        <a href="{{ route('projects.create') }}">New Project</a>
    </div>

    <ul class="list-disc pl-3 pt-1">
        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}" class="text-blue-600 visited:text-purple-600 hover:underline">{{ $project->title }}</a>
            </li>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul>
</x-app-layout>