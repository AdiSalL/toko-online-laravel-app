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
            <label for="created_at">Order Date</label><br>
            <input type="text" class="form-control" value="{{$order->created_at}}">
            <br>

            <label for="">Books ({{$order->totalQuantity}})</label>
            <ul>
                @foreach($order->books as $book)
                    <li>{{$book->title}} <b>({{$book->pivot->quantity}})</b></li>
                @endforeach
            </ul>

            <label for="">Total Price</label>
            <input type="text" class="form-control" value="{{$order->total_price}}" disabled>

            <label for="status">Status</label><br>
            <select name="status" id="status" class="form-control">
                <option value="SUBMIT" {{$order->status == "SUBMIT" ? "selected" : ""}}>
                    SUBMIT
                </option>
                <option value="SUBMIT" {{$order->status == "PROCESS" ? "selected" : ""}}>
                    PROCESS
                </option><option value="SUBMIT" {{$order->status == "FINISH" ? "selected" : ""}}>
                    FINISH
                </option><option value="SUBMIT" {{$order->status == "CANCEL" ? "selected" : ""}}>
                    CANCEL
                </option>
            </select>
            <br>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>

@endsection