<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;
use AmrShawky\LaravelCurrency\Facade\Currency;

class TransactionController extends Controller
{
    public function showAllTransaction()
    {
        $userId = Auth::user()->id;
        // get initial transaction created
        $data['InitialDatas'] = Transactions::where('sender_id', NULL)->where('userId', $userId)->get();
        $data['allDatas'] = Transactions::with(['sender', 'reciever'])->Where('userId', $userId)->where('sender_id', '!=', NULL)->get();

        // dd($data['allDatas']->toArray());
        return view('dashboard', $data);
    }

    public function addTransaction()
    {
        $data['allData'] = User::all()->except(Auth::id());
        return view('transaction.create', $data);
    }

    public function StoreTransaction(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Validate request
            $request->validate(
                [
                    'amount' => 'required|numeric|min:0',
                    'source_currency' => 'required',
                    'target_currency' => 'required'
                ],
                [
                    'source_currency.required' => 'Please select source currency',
                    'target_currency.required' => 'Please select target currency',
                ]
            );



            $authUser = Auth::user()->id;
            $reciever = User::find($request->receiver_id);
            $source_currency = $request->source_currency;
            $target_currency = $request->target_currency;
            $amount = $request->amount;

            // Get Send Last Transaction
            $lastItemSender = Transactions::where('userId', Auth::user()->id)->orderBy('id', 'DESC')->first();
            // dd($lastItemSender->toArray());
            $sender = new Transactions();
            if ($request->source_currency == 'USD') {
                $sender->USD = $lastItemSender->USD - $request->amount;
                $sender->NGN = $lastItemSender->NGN;
                $sender->EUR = $lastItemSender->EUR;
            } elseif ($request->source_currency == 'NGN') {
                $sender->NGN = $lastItemSender->NGN - $request->amount;
                $sender->EUR =  $lastItemSender->EUR;
                $sender->USD = $lastItemSender->USD;
            } elseif ($request->source_currency == 'EUR') {
                $sender->EUR = $lastItemSender->EUR - $request->amount;
                $sender->USD = $lastItemSender->USD;
                $sender->NGN =  $lastItemSender->NGN;
            }
            $sender->userId = Auth::user()->id;
            $sender->sender_id = Auth::user()->id;
            $sender->receiver_id = $request->receiver_id;
            $sender->amount = $request->amount;
            $sender->currency = $request->source_currency;
            $sender->status = 'Success';
            $sender->save();

            // convert to target_currency with lastest exchange rate;
            $converted =  Currency::convert()
                ->from($source_currency)
                ->to($target_currency)
                ->amount($amount)
                ->round(2)
                ->get();
            // create a new transaction for the receiver;
            $receiver = new Transactions();
            $lastItemReciever = Transactions::where('userId', $request->receiver_id)->orderBy('id', 'DESC')->first();
            if ($request->target_currency == 'USD') {
                $receiver->USD = $converted;
                $receiver->EUR = $lastItemReciever->EUR;
                $receiver->NGN = $lastItemReciever->NGN;
            } elseif ($request->target_currency == 'NGN') {
                $receiver->NGN = $converted;
                $receiver->EUR = $lastItemReciever->EUR;
                $receiver->USD = $lastItemReciever->USD;
            } elseif ($request->target_currency == 'EUR') {
                $receiver->EUR = $converted;
                $receiver->NGN = $lastItemReciever->NGN;
                $receiver->USD = $lastItemReciever->USD;
            }
            $receiver->userId = $request->receiver_id;
            $receiver->sender_id = Auth::user()->id;
            $receiver->receiver_id = $request->receiver_id;
            $receiver->amount = $converted;
            $receiver->currency = $request->target_currency;
            $receiver->status = 'success';
            $receiver->save();
        });

        $notification = array(
            'message' => 'Transaction Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }
}
