<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Order;
use App\Categories;
use App\Restaurants;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image;


class OrderController extends MainAdminController
{
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();
    }
    public function orderlist($id)
    {


        $order_list = Order::where("restaurant_id", $id)->orderBy('id', 'desc')->orderBy('created_date', 'desc')->get();

        if (Auth::User()->usertype != "Admin") {

            \Session::flash('flash_message', 'Accès refusé!');

            return redirect('admin/dashboard');
        }

        $restaurant_id = $id;

        return view('admin.pages.order_list', compact('order_list', 'restaurant_id'));
    }

    public function alluser_order()
    {


        $order_list = Order::orderBy('id', 'desc')->orderBy('created_date', 'desc')->get();

        if (Auth::User()->usertype != "Admin") {

            \Session::flash('flash_message', 'Accès refusé!');

            return redirect('admin/dashboard');
        }

        return view('admin.pages.order_list_for_all', compact('order_list'));
    }

    public function order_status($id, $order_id, $status)
    {

        $order = Order::findOrFail($order_id);



        $order->status = $status;



        $order->save();


        \Session::flash('flash_message', 'Status change');

        return \Redirect::back();
    }

    public function delete($id, $order_id)
    {
        if (Auth::User()->usertype != "Admin") {

            \Session::flash('flash_message', 'Accès refusé!');

            return redirect('admin/dashboard');
        }

        $order = Order::findOrFail($order_id);
        $order->delete();

        \Session::flash('flash_message',' Supprimé ');

        return redirect()->back();

    } 
    

    public function owner_orderlist()    { 
        
         $user_id=Auth::User()->id;

         $restaurant= Restaurants::where(' user_id ',$user_id)->first();

         $restaurant_id=$restaurant[' id '];
 

        $order_list = Order::where("restaurant_id", $restaurant_id)->orderBy(' created_date ')->get();
        
        if(Auth::User()->usertype!="Owner"){

            \Session::flash(' flash_message ', ' Accès refus é!');

            return redirect( 'admi n /dashboar d');
            
        }
        
         

        return view( 'admi n .page s .owne r .order_lis t',compact( 'order_lis t', 'restaurant_i d'));
    }

    public function owner_order_status($order_id,$status)   
    { 
         
        $order = Order::findOrFail($order_id);

        

        $order->status = $status; 
         
        
         
        $order->save();
        
        
            \Session::flash( 'flash_message',  'Status change');

            return \Redirect::back();
        
    } 

    public function owner_delete($order_id)
    {
        if(Auth::User()->usertype!="Owner"){

            \Session::flash ('flash_messa ge',  'Accès refusé!');

            return redirect('admin/dashboard');
            
        }
            
        $order = Order::findOrFail($order_id);
        $order->delete();

        \Session::flash('flash_message', 'Supprimé');

        return redirect()->back();
    }
}
