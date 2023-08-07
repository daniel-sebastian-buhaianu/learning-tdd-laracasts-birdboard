<x-app-layout>
    <header class="flex items-center py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="text-gray text-sm font-normal">My Projects</h2>

            <a href="{{ route('projects.create') }}" class="btn-primary">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded-lg shadow" style="height: 200px">
                    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>
    
                    <div class="text-gray">{{ Str::limit($project->description) }}</div>
                </div>
            </div>
         @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
</x-app-layout>