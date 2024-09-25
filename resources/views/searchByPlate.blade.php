<form action="{{ route('search-by-plate') }}" method="POST">
    @csrf
    <label>Licence plate*</label>
    <br/>
    <input type="text" name="search">
    <br/>
    <button>Submit</button>
</form>
