@extends('main.main_master')
@section('content')
    <?php 
        $authUser = Auth::user()->name;
    ?>
<div class="card card-default mx-auto mt-2" style=" width: 40rem;">
    <div class="card-header card-header-border-bottom">
        <h2>Create Transaction</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-primary ml-auto">All Transactions</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('store.transaction') }}">
             @csrf
            <div class="form-group">
                <label for="senderName">Sender Name</label>
                <input type="name" name="name" value="{{ $authUser }}" class="form-control" id="exampleFormControlInput1" placeholder="">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="reciever">Select Reciever</label>
                <select class="form-control" name="receiver_id" id="exampleFormControlSelect12">
                    <option default>select name</option>
                    @foreach($allData as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                    @error('receiver_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
            </div>
            <div class="form-group">
                <label for="sourcecurrency">Source Currency</label>
                <select class="form-control" name="source_currency" id="exampleFormControlSelect12">
                    <option value="NGN">NGN</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
                @error('source_currency')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Target Currency</label>
                <select class="form-control" name="target_currency" id="exampleFormControlSelect12">
                    <option value="NGN">NGN</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
                @error('target_currency')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="amount">Enter Amount</label>
                <input type="number" name="amount" class="form-control" id="exampleFormControlInput1" placeholder="">
                @error('amount')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-footer pt-1 mt-4">
                <button type="submit" class="btn btn-primary btn-default">Send Now</button>
            </div>
        </form>
    </div>
</div>

@endsection