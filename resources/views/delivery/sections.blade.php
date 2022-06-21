

        <li>
            <a href="{{route('delivery.home',['filter'=>'today'])}}">
                <div class="parent-icon">
                    <ion-icon name="home-sharp"></ion-icon>
                </div>
                <div class="menu-title">{{__('orders.Delivery_Dashboard')}} </div>

            </a>
        </li>


        <li>
            <a href="{{route('delivery.home',['filter'=>'today'])}}" >
                <div class="parent-icon">
                    <ion-icon name="hourglass-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('orders.today_orders')}} </div>

            </a>

        </li>


        <li>
            <a href="{{route('delivery.home',['filter'=>'finishedToday'])}}" >
                <div class="parent-icon">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('orders.finished_orders')}} </div>

            </a>

        </li>

        <li>
            <a href="{{route('delivery.home',['filter'=>'yesterday'])}}" >
                <div class="parent-icon">
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('orders.yesterday_orders')}} </div>

            </a>

        </li>

        <li>
            <a href="{{route('delivery.home',['filter'=>'old'])}}" >
                <div class="parent-icon">
                    <ion-icon name="folder-open-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('orders.old_orders')}} </div>

            </a>

        </li>


