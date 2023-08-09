<x-app-layout>
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray text-sm font-normal">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>

            <a href="{{ $project->path() }}/edit" class="btn-primary">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                
                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" class="w-full editable-text-input {{ $task->completed ? 'text-gray' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input placeholder="Add a new task..." class="w-full editable-text-input" name="body">
                        </form>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>

                    {{-- general notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <textarea
                            name="notes" 
                            class="card w-full editable-text-input mb-1" 
                            style="min-height: 200px" 
                            placeholder="General notes here..."
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="btn-primary">Save</button>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
               @include('projects._card')

               @include('projects.activity._card')
            </div>
        </div>
    </main>
</x-app-layout>