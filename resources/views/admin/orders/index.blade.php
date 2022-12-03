@extends('app')
@section('title', 'Admin - Orders')

@section('content')
    <div class="container">
        <div class="col-12 pt-4">
            @if(session()->has('order-deleted'))
                <div class="alert alert-danger">
                    {{ session()->get('order-deleted') }}
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
                                <th>Delivered</th>
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
                                <td>{{ $order->is_part_delivered ? '✅' : '❌' }}</td>
                                <th class="d-flex gap-1">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">View</a>
                                    <form>
                                        <button class="btn btn-success btn-sm">Delivered</button>
                                    </form>
                                    <form method="post" action="{{ route('admin.orders.destroy', $order) }}">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button class="btn btn-danger btn-sm">Delete</button>
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
