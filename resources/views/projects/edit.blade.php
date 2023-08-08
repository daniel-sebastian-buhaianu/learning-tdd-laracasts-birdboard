<x-app-layout>
    <div class="bg-white p-5 mx-auto shadow rounded" style="width: 500px">
        <p class="text-2xl text-center mb-4">Edit Your Project</p>
        <form 
            method="POST" 
            action="{{ $project->path() }}"
        >
            @method('PATCH')

            @include('projects._form', ['btnText' => 'Update'])
        </form>
    </div>
</x-app-layout>