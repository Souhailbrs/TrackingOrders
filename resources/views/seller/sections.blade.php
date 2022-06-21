<?php
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

$type_users =  Auth::guard('seller')->user()->id;
?>
        <li>

            <a href="{{route('seller.home',['type_users'=>$type_users])}}">
                <div class="parent-icon">
                    <ion-icon name="home-sharp"></ion-icon>
                </div>
                <div class="menu-title">{{__('Seller Dashboard')}} </div>

            </a>
        </li>

        <li>
            <a href="javascript: void(0);" >
                <div class="parent-icon">
                    <ion-icon name="storefront-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__(' Sells Channels')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('seller.sellChannels.index')}}" >
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('seller.sellChannels.create')}}" >
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' Add New')}}</div>

                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" >
                <div class="parent-icon">
                    <ion-icon name="wallet-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__(' Inventory')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('seller.inventory.requests')}}" >
                        <div class="parent-icon">
                            <ion-icon name="arrow-redo-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' My Requests')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('seller.inventories.index')}}" >
                        <div class="parent-icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('seller.inventories.create')}}" >
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' Add To Inventory')}}</div>

                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="javascript: void(0);" >
                <div class="parent-icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__(' Products')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('seller.products.index')}}" >
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' My Products')}}</div>

                    </a>
                </li>

                <li>
                    <a href="{{route('seller.products.create')}}" >
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' Add New Product')}}</div>

                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" >
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__(' Orders')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('seller.orders.index')}}" >
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' View All')}}</div>

                    </a>
                </li>

                <li>
                    <a href="{{route('seller.orders.create')}}" >
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__(' Add New Order')}}</div>

                    </a>
                </li>
            </ul>
        </li>

