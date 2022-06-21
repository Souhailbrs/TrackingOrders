
         <li>

             <a href="{{route('supporter.home')}}">
                 <div class="parent-icon">
                     <ion-icon name="home-sharp"></ion-icon>
                 </div>
                 <div class="menu-title">{{__('Supporter Dashboard')}} </div>

             </a>
         </li>
         <li>
             <a href="{{route('supporter.workDays')}}" >
                 <div class="parent-icon">
                     <ion-icon name="storefront-outline"></ion-icon>
                 </div>
                 <div class="menu-title">{{__('Work Days')}} </div>

             </a>
         </li>


         <li>
             <a href="{{route('supporter.getOrder')}}" >
                 <div class="parent-icon">
                     <ion-icon name="storefront-outline"></ion-icon>
                 </div>
                 <div class="menu-title">{{__('Get Order')}} </div>

             </a>
         </li>

         <li>
             <a href="{{route('supporter.orders.index',['state'=>'today','from'=>'1','to'=>'1'])}}" >
                 <div class="parent-icon">
                     <ion-icon name="storefront-outline"></ion-icon>
                 </div>
                 <div class="menu-title">{{__('View Orders')}} </div>

             </a>
         </li>

