@extends("app")

@section('head_title', 'Order Details' .' | '.getcong('site_name') )

@section('head_url', Request::url())
@section('extra-js')
   
@endsection
@section("content")
 
<div class="sub-banner" style="background:url({{ URL::asset('upload/'.getcong('page_bg_image')) }}) no-repeat center top;">
    <div class="overlay">
      <div class="container">
        <h1>VOTRE COMMANDE Details</h1>
      </div>
    </div>
  </div>

 <div class="restaurant_list_detail">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sm-7 col-xs-12">
          <div class="box_style_2" id="order_process">
          <h2 class="inner">VOTRE COMMANDE Details</h2>
          {!! Form::open(array('url' => 'order_details','class'=>'','id'=>'payment-form','role'=>'form')) !!} 

            <div class="message">
                        <!--{!! Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) !!}-->
                                    @if (count($errors) > 0)
                          <div class="alert alert-danger">
                          
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                                    
        </div>
        @if(Session::has('flash_message'))
            <div class="alert alert-success">             
                {{ Session::get('flash_message') }}
            </div>
        @endif

          <div class="form-group">
            <label>Prénom</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}" placeholder="Prénom">
          </div>
          <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" id="last_name" value="{{$user->last_name}}" name="last_name" placeholder="Nom">
          </div>
          <div class="form-group">
            <label>Telephone/mobile</label>
            <input type="text" id="mobile" name="mobile" value="{{$user->mobile}}" class="form-control" placeholder="Telephone/mobile">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Your email">
          </div>           
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>City</label>
                <input type="text" id="city" name="city" value="{{$user->city}}" class="form-control" placeholder="Your city">
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Postal code</label>
                <input type="text" id="postal_code" name="postal_code" value="{{$user->postal_code}}" class="form-control" placeholder=" Your postal code">
              </div>
            </div>
          </div>
          <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group ">
              <label for="" class="col-sm-3 control-label">payez en ligne</label>
              <div class="col-sm-9">
                  <input class="form-check-input" type="checkbox" value="1" id="Online" >
              </div>
          </div>
          </div>
          </div>
          <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Nom sur carte</label>
                <input type="text" class="form-control" id="cc-name" placeholder="" >
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Numéros de Carte de crédit</label>
                <input type="text" class="form-control" id="cc-number" placeholder=""  value="4242424242424242">
              </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="cc-expiration">Expiration</label>
                  <input type="text" class="form-control" id="cc-expiration" placeholder="" required="" value="12/22">
                
                </div>
                <div class="col-md-3 mb-3">
                  <label for="cc-expiration">CVV</label>
                  <input type="text" class="form-control" id="cc-cvv" placeholder="" required="" value="123">
                  
                </div>
              </div>
            <div class="row">
          <div class="form-group">
             
          </div>
          </div>
          <hr>
          {{-- <div class="row">
            <div class="col-md-12">
              <label>Adresse</label>
              <textarea class="form-control" style="height:150px" placeholder="Address" name="address" id="address">{{$user->address}}</textarea>
            </div>

          </div> --}}
          <div class="form-group ">
                        
              <label for="" class="col-sm-3 control-label">Adresse</label>
              <div class="col-sm-9">
                  {{-- <textarea name="restaurant_address" id="restaurant_address" cols="60" rows="3" class="form-control">{{ isset($restaurant->restaurant_address) ? $restaurant->restaurant_address : null }}</textarea> --}}
              </div>
          
          {{-- {{ html()->label("adresse")->class(' col-md-2 form-control-label')->for('full_address') }} --}}
          
          <input type="text" id="address-input" name="address" value="{{$user->address}}" class="form-control map-input">
          <input type="hidden" name="address_latitude" id="address-latitude" value="{{ isset($restaurant->address_latitude) ? $restaurant->address_latitude : null }}" />
          <input type="hidden" name="address_longitude" id="address-longitude" value="{{ isset($restaurant->address_longitude) ? $restaurant->address_longitude : null }}" />
      </div>
          <div id="address-map-container" style="width:100%;height:400px; ">
                    <div style="width: 100%; height: 100%" id="address-map"></div>
          </div>
          

        </div>
        
        <!-- End box_style_1 --> 
        </div>
    <div class="col-md-3 col-sm-5 col-xs-12 side-bar">   
    <div id="cart_box">
          <h3>VOTRE COMMANDE <i class="icon_cart_alt pull-right"></i></h3>
          
          <table class="table table_summary">
            <tbody>
              @foreach(\App\Cart::where('user_id',Auth::id())->orderBy('id')->get() as $n=>$cart_item)
              <tr>
                <td><a href="{{URL::to('delete_item/'.$cart_item->id)}}" class="remove_item"><i class="fa fa-minus-circle"></i></a> <strong>{{$cart_item->quantity}}x</strong> {{$cart_item->item_name}} </td>
                <td><strong class="pull-right">{{getcong('currency_symbol')}}{{$cart_item->item_price}}</strong></td>
              </tr>
              @endforeach
               
            </tbody>
          </table>
           
          <!-- Edn options 2 -->
          
          <hr>
          @if(DB::table('cart')->where('user_id', Auth::id())->sum('item_price')>0)
          <table class="table table_summary">
            <tbody>
              
              <tr>
                <td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}{{$price = DB::table('cart')
                ->where('user_id', Auth::id())
                ->sum('item_price')}}</span></td>
              </tr>
            </tbody>
          </table>
          <hr>
          <button type="submit" class="btn_full">Confirmez VOTRE COMMANDE</button>
        </div>

          {!! Form::close() !!} 
          @else
            <a class="btn_full" href="#">panier vide</a> </div>
          @endif
        <!-- End cart_box -->                                                                               
    <div id="help" class="box_style_2"> 
      <i class="fa fa-life-bouy"></i>
        <h4>{{getcong_widgets('need_help_title')}}</h4>
        <a href="tel://{{getcong_widgets('need_help_phone')}}" class="phone">{{getcong_widgets('need_help_phone')}}</a> <small>{{getcong_widgets('need_help_time')}}</small> 
      </div>
        </div>
                
      </div>
    </div>
  </div>
 

@endsection


