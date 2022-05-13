<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ReplyEmail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $complains = Home::join('inquiries','inquiry_hs.reference_number',"=",'inquiries.reference_number')
                            ->select('inquiry_hs.reference_number','inquiry_hs.f_name','inquiry_hs.email','inquiry_hs.contact_number','inquiry_hs.mark_as_read','inquiries.description')
                            ->where('inquiries.is_agent','0')
                            ->whereRaw('inquiries.id = (select min(inquiries.id) from inquiries where inquiries.reference_number = inquiry_hs.reference_number )')
                            ->orderBy('inquiry_hs.mark_as_read','ASC')
                            ->orderBy('inquiry_hs.id', 'ASC')
                            ->paginate(2);
       
        
        return view('home',['complains'=>$complains]);
    }

    public function search_name(Request $request)
    {
        $complains = Home::join('inquiries','inquiry_hs.reference_number',"=",'inquiries.reference_number')
                            ->select('inquiry_hs.reference_number','inquiry_hs.f_name','inquiry_hs.email','inquiry_hs.contact_number','inquiry_hs.mark_as_read','inquiries.description')
                            ->where('inquiries.is_agent','0')
                            ->where('inquiry_hs.f_name','Like','%'.$request->name.'%')
                            ->whereRaw('inquiries.id = (select min(inquiries.id) from inquiries where inquiries.reference_number = inquiry_hs.reference_number )')
                            ->orderBy('inquiry_hs.mark_as_read','ASC')
                            ->orderBy('inquiry_hs.id', 'ASC')
                            ->get();

        $output='';
        $i=1;
        $att='';

        if(count($complains)>0){
            foreach ($complains as $complain) {
                $att='Attended';
                if($complain->mark_as_read==0){
                    $att='<button class="btn btn-warning" type="button"><span style="color: brown">NEW</span> <br>Attend</button>';
                }
    
                $output.='<tr>
                <td>
                '.$i.'
                </td>
                <td>
                '.$complain->reference_number.
                '
                </td>
                <td>
                '.$complain->f_name.
                '
                </td>
                <td>
                '.$complain->email.
                '
                </td>
                <td>
                '.$complain->contact_number.
                '
                </td>
                <td>
                '.$complain->description.
                '
                </td>
                <td>
                '.$att.'
                </td>
                <td>
                <button class="btn btn-info" type="button">View</button>
                </td>
                </tr>';
                $i++;    
            }
        }
        
        else{
            $output='<tr><td colspan="8">No Matching Records Found!</td></tr>';
        }

        return response($output);
    }

    public function ticket_details($id)
    {
        $complains = Home::join('inquiries','inquiry_hs.reference_number',"=",'inquiries.reference_number')
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
        return view('details',['complains'=>$complains]);
    }

    function add_reply(Request $request)
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
                'is_agent'=>true,
                'created_at' => Carbon::now(),
            ]);

            $affected = DB::table('inquiry_hs')
              ->where('reference_number', $request->input('ref'))
              ->update(['mark_as_read' => 1]);

            DB::commit();

            //data set for email 
            $data = [
                'name' => $request->input('name'),
                'reference_number'=>$request->input('ref'),
                'description'=>$request->input('message')
            ];

            Mail::to($request->input('email'))->send(new ReplyEmail($data));
            return redirect('ticket-details/'.$request->input('ref'));
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return redirect('ticket-details/'.$request->input('ref'))->with('erroMessage', 'Sorry! Something Went Wrong..');
        }
    } 
    
    
    
}
