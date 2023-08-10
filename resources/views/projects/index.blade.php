<x-app-layout>
    <header class="flex items-center py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-default text-sm font-normal">My Projects</h2>

            <a href="{{ route('projects.create') }}" class="btn-primary">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects._card')
            </div>
         @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
</x-app-layout>