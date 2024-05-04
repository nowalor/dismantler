
<div class="table">
    <table class="table table-hover">
        <thead style="background-color:#b3b2b2; color: #000000; border-radius: 10px;">
            <tr>
                <th scope="col">Part Information</th>
                <th scope="col">Article Number</th>
                <th scope="col">Odometer (KM)</th>
                <th scope="col">Model Year</th>
                <th scope="col">Quality</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parts as $part)
            <x-part-item :part="$part"/>
            @empty
            <tr>
                <td colspan="6">No parts were found matching this query</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
