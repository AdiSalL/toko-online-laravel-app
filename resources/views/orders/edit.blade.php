@extends("layouts.global")

@section("title") Edit Order @endsection

@section("content")
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        <form action="{{routes('orders.update', [$order->id])}}" class="shadow-sm bg-white p-3" method="POST">
            @csrf

            <input type="hidden" name="_method" value="PUT">

            <label for="invoice_number">Invoice number</label><br>
            <input type="text" class="form-control" value="{{$order->invoice_number}}" disabled> <br>

            <label for="">Buyer</label><br>
<input disabled class="form-control" type="text" value="{{$order-
>user->name}}">
<br>
<label for="created_at">Order date</label><br>
<input type="text" class="form-control" value="{{$order->created_at}}"
disabled >
    <br>
            
        </form>
    </div>

@endsection