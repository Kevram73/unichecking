<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

}
