<div class="row">
    @foreach($parts as $part)
        <x-part-item :part="$part"/>
    @endforeach
</div>
