<div class="row">
    @forelse($parts as $part)
        <x-part-item :part="$part"/>
    @empty
        <p>No parts where found matching this query</p>
    @endforelse
</div>
