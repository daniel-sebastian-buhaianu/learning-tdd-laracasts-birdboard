@if (count($activity->changes['after']) == 1)
    {{ $activity->user->name }} updated the project's {{ key($activity->changes['after']) }}.
@else
    {{ $activity->user->name }} updated the project.
@endif