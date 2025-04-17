@extends('app')
@section('title', 'Admin - Fenix stats')
@section('content')
    <div class="col-6 mx-auto pt-4">
        <div class="card">
            <div class="card-header">Statistics</div>
            <div class="card-body">
               <p>
                   <span class="fw-bolder">
                       Processed parts:
                   </span>
                   <span class="fw-lighter fst-italic">{{ $stats['resolvedParts'] }}</span>
               </p>

                <p>
                   <span class="fw-bolder">
                       Sellable parts(to increase these add more part types to excel):
                   </span>
                    <span class="fw-lighter fst-italic">{{ $stats['sellableParts'] }}</span>
                </p>

                <p>
                   <span class="fw-bolder">
                       Unsellable parts:
                   </span>
                    <span class="fw-lighter fst-italic">{{ $stats['unSellableParts'] }}</span>
                </p>

                <p>
                   <span class="fw-bolder">
                       Sellable with processed image:
                   </span>
                    <span class="fw-lighter fst-italic">{{ $stats['sellable'] }}</span>
                </p>

               <p>
                   <span class="fw-bolder">
                       Unsellable sbr part codes(to decrease add more part types to excel):
                   </span>
                    <span class="fw-lighter fst-italic">{{ $stats['unSellablePartTypeCounts'] }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection
