@extends('layouts.master')
@section('title', 'Welcome')


@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<div class="container">
    <div class="row mt-5">
        <h1>Welcome back </h1>
        <a class="mb-3" href="{{ route('top.selling') }}">See top selling</a>
    </div>
    <div class="row">
        <div class="col-md-7">
            <form class="d-flex">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="" class="form-control">
                    </div>
                </div>
                 <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="" class="form-control">
                    </div>
                </div>
                  <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">First name, last name...</label>
                       <input class="typeahead form-control" id="search" name="user" type="text">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3 mt-4">
                       <button class="btn btn-primary">Filter</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <div class="row">
        <table class="table  table-hover">
        <thead>
            <tr>
            <th>Invoice</th>
            <th>Purchaser</th>
            <th>Distributor</th>
            <th>Refered Distributor</th>
            <th>Order Date</th>
            <th>Order Total</th>
            <th>Percentage</th>
            <th>Commission</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <th>{{ $order->invoice_number }}</th>
                <th>{{ $order?->purchaser->full_name }}</th>
                <th>{{ $order?->purchaser?->referrer?->is_distributor === true  ? $order?->purchaser?->referrer?->full_name  : ''}}</th>
                <th>{{ ($order?->purchaser?->referrer_count)}}</th>
                <th>{{ $order->order_date }}</th>
                <th>{{ $order->order_total }}</th>
                <th>{{ $order->percentage }}%</th>
                <th>{{ $order->commission }}</th>
                <td>
                    <a class="" onclick="showOrderItemsModal('{{ $order->id }}', '{{$order->invoice_number}}')"href="javascript:void(0)">View Items</a>
                </td>
            </tr>
            @empty

            @endforelse


        </tbody>
        </table>

    </div>
    <div class="row mb-5">
        {{ $orders->links() }}
    </div>
</div>



    <!-- Update testimonial modal -->
    <div class="modal fade " id="orderItemsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-4 text-dark" id="invoice_number">Order Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div class="row">
                               <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                 <tbody>

                                 </tbody>
                                <tbody id="ordered-items">

                                </table>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primaryi-outline" data-bs-dismiss="modal">Cancel</button>
                        {{-- <button type="submit" class="btn btn-primaryi">Save Changes</button> --}}
                    </div>

            </div>
        </div>
    </div>


<script type="text/javascript">


    function showOrderItemsModal(orderId, invoiceNumber) {

        $('#ordered-items').empty();

        document.getElementById('invoice_number').innerHTML = 'Invoice: '+invoiceNumber;

        $(document).ready( function () {
            $.ajax({
                url: `/api/order-items/${orderId}`,
                type: "GET",
                cache: true,
                success: function(response){



                    $.each(response, function (key, value) {

                        $('#ordered-items').append(`
                        <tr>
                            <td>${value.product.sku}</td>
                            <td>${value.product.name}</td>
                            <td>${value.product.price}</td>
                            <td>${value.qantity}</td>
                            <td>$${value.qantity * value.product.price} </td>
                        </tr>
                        `);
                    })
                }

            });
        });

        $('#orderItemsModal').modal('show')
    }


    // Auto complete
    var path = "/api/users";

    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#search').val(ui.item.label);
           console.log(ui.item);
           return false;
        }
      });

</script>

@endsection


