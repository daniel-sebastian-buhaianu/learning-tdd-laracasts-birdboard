<x-app-layout>
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray text-sm font-normal">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>

            <a href="{{ route('projects.create') }}" class="btn-primary">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">{{ $task->body }}</div>
                    @endforeach
                </div>
                
                <div class="">
                    <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>
                    <textarea class="card w-full !border-transparent focus:ring-0" style="min-height: 200px">general notes here...</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
               @include('projects.card')
            </div>
        </div>
    </main>
</x-app-layout>