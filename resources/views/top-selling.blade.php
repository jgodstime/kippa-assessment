@extends('layouts.master')
@section('title', 'Top Selling')


@section('content')


<div class="container">
    <div class="row mt-5">
        <h1>Top Selling</h1>
    </div>

    <div class="row">
        <table class="table  table-hover">
        <thead>
            <tr>
            <th>Top</th>
            <th>Distributor Name</th>
            <th>Total Sale</th>

            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @forelse ($topSellings as $topSelling)
            <tr>

                <th>{{ $count++  }}</th>
                <th>{{ $topSelling->full_name }}</th>

                <th>{{ $topSelling->sales }}</th>

            </tr>
            @empty

            @endforelse


        </tbody>
        </table>

    </div>
    <div class="row mb-5">
        {{ $topSellings->links() }}
    </div>
</div>



@endsection


