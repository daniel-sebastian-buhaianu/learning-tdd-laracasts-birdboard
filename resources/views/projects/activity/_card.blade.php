<div class="card mt-3">
    <ul class="text-sm">
        @foreach ($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-2' }}">
                @include("projects.activity._{$activity->description}")
                <span class="text-gray">{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>