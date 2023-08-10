@if ($errors->{ $bag ?? 'default' }->any())
    <div class="w-full mt-3">
        <ul class="text-red-600 text-sm">
            @foreach ($errors->{ $bag ?? 'default' }->all() as $error)  
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif