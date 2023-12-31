<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
        Invite a User
    </h3>

    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" id="email" class="border border-gray rounded w-full py-2 px-3" placeholder="Email address">
        </div>

        <button type="submit" class="btn-primary">Invite</button>
    </form>

    @include('_errors', ['bag' => 'invitations'])
</div>