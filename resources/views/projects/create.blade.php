<x-app-layout>
    <div class="bg-white p-5 mx-auto shadow rounded" style="width: 500px">
        <p class="text-2xl text-center mb-4">Let's start something new</p>
        <form 
            method="POST" 
            action="/projects"
        >
            @include('projects._form', [
                'project' => new App\Models\Project,
                'btnText' => 'Create',
            ])
        </form>
    </div>
</x-app-layout>