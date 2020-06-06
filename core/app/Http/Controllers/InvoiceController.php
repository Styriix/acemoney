<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

   public function index()
     {
         $invoice = Invoice::first();
         if($invoice == null)
         {
             $default = [
                 'contac' => 'THESOFTKING',
                 'bank' => 'Name of bank'
             ];
             Invoice::create($default);
             $invoice = Invoice::first();
         }

         return view('admin.website.invoice', compact('invoice'));
     }

    public function update(Request $request)
      {
         $invoice = Invoice::first();

          $this->validate($request,
                 [
                  'contac' => 'required',
                  'bank' => 'required'
                  ]);

          $invoice['contac'] = $request->contac;
          $invoice['bank'] = $request->bank;
        
          $invoice->save();

          return back()->with('success', 'Invoice Settings Updated Successfully!');
      }

}
