
        <li>

            <a href="{{route('packaging.home')}}">
                <div class="parent-icon">
                    <ion-icon name="home-sharp"></ion-icon>
                </div>
                <div class="menu-title">{{__('Packaging Dashboard')}} </div>

            </a>
        </li>

        <li>
            <a href="{{route('packaging.wrapping.index',['state'=>'today','from'=>'1','to'=>'1'])}}" >
                <div class="parent-icon">
                    <ion-icon name="print-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Print Labels')}} </div>

            </a>
        </li>
        <li>
            <a href="javascript: void(0);" >
                <div class="parent-icon">
                    <ion-icon name="send-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Sent Orders')}} </div>

            </a>
            <ul>

                <li>

                    <a href="{{route('packaging.wrapping.sentOrders',['day'=>'today','filter'=>'all'])}}" >
                        <div class="parent-icon">
                            <ion-icon name="today-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Today Orders')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('packaging.wrapping.sentOrders',['day'=>'all','filter'=>'all'])}}" >
                        <div class="parent-icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('All Orders')}}</div>

                    </a>
                </li>
            </ul>
        </li>







