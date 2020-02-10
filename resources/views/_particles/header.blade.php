  <div class="top-bar">
    <div class="container">
      <ul class="left-bar-side">
        <li><p><i class="fa fa-envelope-o"></i><a href="mailto:{{getcong('site_email')}}">{{getcong('site_email')}}</a></p></li>
      </ul>
     
    </div>
  </div>
  <header class="sticky">
    <div class="container">
      <div class="logo"> <a href="{{ URL::to('/') }}"><img src="{{ URL::asset('upload/'.getcong('site_logo')) }}" alt="" ></a> </div>
      <nav class="animenu">
      <button class="animenu_toggle"> 
         <span class="animenu_toggle_bar"></span> 
         <span class="animenu_toggle_bar"></span> 
         <span class="animenu_toggle_bar"></span> 
      </button>
      <ul class="animenu_nav">
            <li> <a href="{{ URL::to('/') }}">accueil</a></li>
            <li><a href="{{URL::to('restaurants')}}">Restaurants</a></li>
            <li><a href="{{URL::to('orders')}}">mes commandes</a></li>
            @if(Auth::check() and Auth::user()->usertype=='User')

             <li> <a href="javascript:void(0);">Mon compte<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('profile') }}">modifier le Profile</a></li>
                <li><a href="{{ URL::to('change_pass') }}">Changer Mot de passe</a></li>
                <li><a href="{{URL::to('myorder')}}">Ma commande</a></li>
                <li><a href="{{ URL::to('logout') }}">se déconnecter</a></li>                
              </ul>
            </li>
            @elseif(Auth::check() and Auth::user()->usertype=='Owner')
              <li> <a href="javascript:void(0);">Mon compte<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ URL::to('logout') }}">se déconnecter</a></li>                
              </ul>
            </li>
            @elseif(Auth::check() and Auth::user()->usertype=='Admin')
              <li> <a href="javascript:void(0);">Mon compte<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ URL::to('logout') }}">se déconnecter</a></li>                
              </ul>
            </li>

              
            @else
 
            <li><a href="{{ URL::to('login') }}">Login</a></li>
            <li><a href="{{ URL::to('register') }}">Créer un compte</a></li>

            @endif

            <li><a href="{{ URL::to('about') }}">À PROPOS DE NOUS</a></li>
            <li><a href="{{ URL::to('contact') }}">Contact</a></li>              
          </ul>
       
       
    </nav>
    </div>
  </header>
   