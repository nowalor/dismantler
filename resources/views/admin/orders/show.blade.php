@extends('app')
@section('title', 'Admin - Orders - ' . $order->id)
@section('content')
    <div class="container">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Test
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-select">
                                @foreach($statuses as $statusLabel=> $statusValue)
                                    <option
                                        value="{{ $statusLabel }}" {{ $order->status == $statusLabel ? 'selected' : '' }}>{{ $statusValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
