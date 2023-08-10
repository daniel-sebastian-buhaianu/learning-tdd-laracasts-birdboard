@csrf

<div class="flex flex-col items-center">
    <div class="w-full mb-4">
        <label for="title" class="text-lg">Title</label>
        <p>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="w-full"
                placeholder="My next awesome project"
                value="{{ $project->title }}"
                required
            >
        </p>
    </div>

    <div class="w-full">
        <label for="description" class="text-lg">Description</label>
        <p>
            <textarea 
                name="description" 
                id="description"
                class="w-full"
                rows="5"
                placeholder="I should start learning piano."
                required
            >{{ $project->description }}</textarea>
        </p>
    </div>

    <div class="w-full mt-1">
        <button class="btn-primary">{{ $btnText }}</button>
        <a href="/projects" class="text-sm underline ml-1">Cancel</a>
    </div>
   
    @include('_errors')
</div>