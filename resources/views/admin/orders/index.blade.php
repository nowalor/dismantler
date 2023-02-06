@extends('app')
@section('title', 'Admin - Orders')

@section('content')
    <div class="container">
        <div class="col-4">
            <h1>Orders</h1>

            <form action="{{  route('admin.orders.index') }}">
                <div class="pb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="all">All</option>
                        @foreach($statuses as $statusLabel => $statusValue)
                            <option value="{{ $statusLabel }}" {{ $statusLabel == request('status') ? 'selected' : '' }}>
                                {{ $statusValue }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
        <div class="col-12 pt-4">
            @if(session()->has('order-deleted'))
                <div class="alert alert-danger">
                    {{ session()->get('order-deleted') }}
                </div>
            @endif

                @if(session()->has('order-updated'))
                    <div class="alert alert-success">
                        {{ session()->get('order-updated') }}
                    </div>
                @endif

            <div class="card">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Part name</th>
                                <th>Dismantle company</th>
                                <th>Buyer name</th>
                                <th>Buyer email</th>
                                <th>Part price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->carPart->name }}</td>
                                <td> {{ $order->dismantleCompany->name }} </td>
                                <td>{{ $order->buyer_name }}</td>
                                <td>{{ $order->buyer_email }}</td>
                                <td>{{ $order->part_price }}</td>
                                <td>{{ $statuses[$order->status] }}</td>
                                <th class="d-flex gap-1">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">View</a>
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-success btn-sm">Delivered</button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
