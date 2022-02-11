@extends('main.main_master')
@section('content')


<div class="row">
    <div class="col-md-12 my-3">
        <div class="card card-default">
            <div class="card-header d-flex justify-content-between card-header-border-bottom">
                <h2>TRANSACTIONS</h2>
                <a href="{{ route('add.transaction') }}" class="btn btn-primary btn-lg text-white">NEW TRANSACTION</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">From</th>
                            <th scope="col">To</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Currency</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Updated_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $counter = 0;
                        ?>
                       
                        @foreach($InitialDatas as $data)
                        <tr>
                            <td scope="row">{{ $counter++ }}</td>
                            <td>{{ $data->sender_id }}</td>
                            <td>{{ $data->receiver_id }}</td>
                            <td class="text-success">{{ $data->USD }}</td>
                            <td>{{ $data->currency }}</td>
                            <td class="text-success">Initial Transaction</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->updated_at }}</td>
                        </tr>
                        @endforeach
                        

                        @foreach($allDatas as $data)
                        <tr>
                            <td scope="row">{{ $counter++ }}</td>
                            <td>{{ $data->sender->name }}</td>
                            <td>{{ $data->reciever->name }}</td>
                            <td>{{ $data->amount }}</td>
                            <td>{{ $data->currency }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->updated_at }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection