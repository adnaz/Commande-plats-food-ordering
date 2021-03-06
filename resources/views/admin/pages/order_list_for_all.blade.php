@extends("admin.admin_app")

@section("content")
<div id="main">
	<div class="page-header">
		
		
		<h2>toute la liste de commande</h2>
         
	</div>
	@if(Session::has('flash_message'))
				    <div class="alert alert-success">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
	@endif
     
<div class="panel panel-default panel-shadow">
    <div class="panel-body">
         
        <table id="order_data_table" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Date</th>
                <th>Nom</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Restaurants </th>
                <th>Nom Menu</th>
                <th>quantité</th>
                <th>prix Item </th>
                <th>Prix Total </th>
                <th>Status</th>                           
                <th class="text-center width-100">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($order_list as $i => $order)
            <tr>
                <td>{{ date('m-d-Y',$order->created_date)}}</td>
                <td>{{ \App\User::getUserFullname($order->user_id) }}</td>
                <td>{{ \App\User::getUserInfo($order->user_id)->mobile }}</td>
                <td>{{ \App\User::getUserInfo($order->user_id)->email }}</td>
                <td>{{ \App\User::getUserInfo($order->user_id)->address }}</td>
                <td><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id) }}" class="text-regular">{{ \App\Restaurants::getRestaurantsInfo($order->restaurant_id)->restaurant_name }}</a>
                </td>
                <td>{{ $order->item_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{getcong('currency_symbol')}}{{ \App\Menu::getMenunfo($order->item_id)->price }}</td>
                <td>{{getcong('currency_symbol')}}{{ $order->item_price }}</td>
                <td>{{ $order->status }}</td>
                <td class="text-center">
                <div class="btn-group">
                                <button type="button" class="btn btn-default-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Actions <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                    <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/En attente') }}"><i class="md md-lock"></i> En attente</a></li>
                                    <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/En traitement') }}"><i class="md md-loop"></i>  En traitement</a></li>
                                    <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Completer') }}"><i class="md md-done"></i> Completer</a></li>
                                    <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Annuler') }}"><i class="md md-cancel"></i> Annuler</a></li>
                                    <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id) }}"><i class="md md-delete"></i> suprimmer</a></li>
                                </ul>
                            </div> 
                
            </td>
                
                 
            </tr>
           @endforeach
             
            </tbody>
        </table>
         
        <script type="text/javascript">
            $(document).ready(function() {
            
                $('#order_data_table').dataTable({
                    "order": [[ 0, "desc" ]]
                });

            } );
         </script>

    </div>
    <div class="clearfix"></div>
</div>

</div>

@endsection