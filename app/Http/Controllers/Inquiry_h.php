<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ComplainEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class Inquiry_h extends Controller
{   

    public function index()
    {
        return view('welcome');
    }

    function add_inquiry(Request $request)
    {   
        //validate variables
        $request->validate([
            'name'=>'required',
            'email_id'=>'required|email',
            'contact_number'=>'required|numeric|digits:10',
            'description'=>'required',
        ]);

        //make unique reference number
        $ref_number = 'CMP'.rand(0,99999999);
        
        //insert to db
        DB::beginTransaction();
        try {
            $query=DB::table('inquiry_hs')->insert([
                'f_name'=>$request->input('name'),
                'email'=>$request->input('email_id'),
                'contact_number'=>$request->input('contact_number'),
                'reference_number'=>$ref_number,
                'created_at' => Carbon::now(),
            ]);

            $query1=DB::table('inquiries')->insert([
                'reference_number'=>$ref_number,
                'description'=>$request->input('description'),
                'is_agent'=>false,
                'created_at' => Carbon::now(),
            ]);

            DB::commit();

            //data set for email 
            $data = [
                'name' => $request->input('name'),
                'reference_number'=>$ref_number
            ];

            Mail::to($request->input('email_id'))->send(new ComplainEmail($data));
            return redirect('/')->with('successMessage', 'Request Successfully Submitted! - Your Reference Number : '.$ref_number);
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return redirect('/')->with('erroMessage', 'Sorry! Something Went Wrong..');
        }
        
    }

    function search_inquiry(Request $request)
    {
        $request->validate([
            'reference_number'=>'required'
        ]);

        $id = $request->input('reference_number');

        $complains = DB::table('inquiry_hs')
                            ->join('inquiries','inquiry_hs.reference_number',"=",'inquiries.reference_number')
                            ->select('inquiry_hs.reference_number','inquiry_hs.f_name','inquiries.description','inquiries.is_agent','inquiry_hs.email')
                            ->where('inquiries.reference_number',$id)
                            ->groupBy('inquiries.is_agent')
                            ->groupBy('inquiry_hs.reference_number')
                            ->groupBy('inquiry_hs.email')
                            ->groupBy('inquiry_hs.f_name')
                            ->groupBy('inquiries.description')
                            ->orderBy('inquiries.id','ASC')
                            ->get();
                            
        //return view('details');
        return view('customerReply',['complains'=>$complains]);
    }
    
    function add_customer_reply(Request $request)
    {   
        //validate variables
        $request->validate([
            'ref'=>'required',
            'message'=>'required'
        ]);

        DB::beginTransaction();
        try {
            
            $query=DB::table('inquiries')->insert([
                'reference_number'=>$request->input('ref'),
                'description'=>$request->input('message'),
                'is_agent'=>false,
                'created_at' => Carbon::now(),
            ]);

            DB::commit();
            return Redirect::route('search_inquiry_id', $request->input('ref'));
            
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return redirect('ticket-details/'.$request->input('ref'))->with('erroMessage', 'Sorry! Something Went Wrong..');
        }
    } 

    function search_inquiry_id($id)
    {

        $complains = DB::table('inquiry_hs')
                            ->join('inquiries','inquiry_hs.reference_number',"=",'inquiries.reference_number')
                            ->select('inquiry_hs.reference_number','inquiry_hs.f_name','inquiries.description','inquiries.is_agent','inquiry_hs.email')
                            ->where('inquiries.reference_number',$id)
                            ->groupBy('inquiries.is_agent')
                            ->groupBy('inquiry_hs.reference_number')
                            ->groupBy('inquiry_hs.email')
                            ->groupBy('inquiry_hs.f_name')
                            ->groupBy('inquiries.description')
                            ->orderBy('inquiries.id','ASC')
                            ->get();
                            
        //return view('details');
        return view('customerReply',['complains'=>$complains]);
    }
}

