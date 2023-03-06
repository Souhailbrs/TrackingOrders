<li>
    <a href="{{route('admin.home',['type_users'=>'all'])}}">
        <div class="parent-icon">
            <ion-icon name="home-sharp"></ion-icon>
        </div>
        @if(Auth::guard('admin')->check())
            @if(Auth::guard('admin')->user()->is_super_admin)
                <div class="menu-title">{{__('Super Admin Dashboard')}} </div>
            @else
                <div class="menu-title">{{__('Admin Dashboard')}} </div>
            @endif
        @endif
    </a>
</li>


<li>
    <a href="javascript:;">
        <div class="parent-icon">
            <ion-icon name="people-outline"></ion-icon>
        </div>
        <div class="menu-title">Manage Users</div>

    </a>
    <ul>
        <li>
            <a href="javascript: void(0);">
                <span>Users</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{route('users.get.type',['type'=>'sellers'])}}">
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('users.create')}}">
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Add New User')}}</div>

                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript: void(0);">
                <span>Join Requests</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                <li>
                    <a href="{{route('show.requests',['avilable'])}}">
                        <div class="parent-icon">
                            <ion-icon name="mail-unread-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Available')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('show.requests',['contacted'])}}">
                        <div class="parent-icon">
                            <ion-icon name="call-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Contacted')}}</div>

                    </a>
                </li>


            </ul>
        </li>

    </ul>
</li>

<li>
    <a href="javascript:;">
        <div class="parent-icon">
            <ion-icon name="storefront-outline"></ion-icon>
        </div>
        <div class="menu-title">Sells Channels</div>

    </a>
    <ul>
        <li>
            <a href="javascript: void(0);" class="">
                <span>Shops Type</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{route('shopTypes.index')}}">
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('shopTypes.create')}}">
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Add New Type')}}</div>

                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{route('sellChannels.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('sellChannels.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New Channel')}}</div>

            </a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <div class="parent-icon">
            <ion-icon name="wallet-outline"></ion-icon>
        </div>
        <div class="menu-title">Inventory</div>

    </a>
    <ul>

        <li>
            <a href="{{route('get.products')}}">
                <div class="parent-icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Products')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('get.shipments')}}">
                <div class="parent-icon">
                    <ion-icon name="receipt-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Shipments')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('showRequests')}}">
                <div class="parent-icon">
                    <ion-icon name="arrow-redo-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Requests')}}</div>

            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="cube-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__(' Orders ')}} </div>
    </a>
    <ul>

        <li>
            <a href="{{route('admin.orders.index',['state'=>'today','from'=>1,'to'=>1,'country_id'=>\App\Models\Country::where('title_en','Mauritania')->first()->id])}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Mauritania')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('admin.orders.index',['state'=>'today','from'=>1,'to'=>1,'country_id'=>\App\Models\Country::where('title_en','Tunisie')->first()->id])}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Tunisie')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('admin.orders.index',['state'=>'today','from'=>1,'to'=>1])}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
    </ul>
</li>
@if(Auth::guard('admin')->check())

    @if(Auth::guard('admin')->user()->is_super_admin)

        <li>
            <a href="javascript: void(0);">
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Countries')}} </div>

            </a>
            <ul>

                <li>
                    <a href="{{route('countries.index')}}">
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('View All')}}</div>

                    </a>
                </li>
                <li>
                    <a href="{{route('countries.create')}}">
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                        <div class="menu-title">{{__('Add New')}}</div>

                    </a>
                </li>
            </ul>
        </li>
    @endif
@endif
<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="earth-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Cities')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('cities.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('cities.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="earth-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Zones')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('zones.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('zones.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>
    </ul>
</li>

<li>
    <a href="javascript: void(0);">
        <div class="parent-icon">
            <ion-icon name="earth-outline"></ion-icon>
        </div>
        <div class="menu-title">{{__('Districts')}} </div>

    </a>
    <ul>

        <li>
            <a href="{{route('districts.index')}}">
                <div class="parent-icon">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('View All')}}</div>

            </a>
        </li>
        <li>
            <a href="{{route('districts.create')}}">
                <div class="parent-icon">
                    <ion-icon name="add-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Add New')}}</div>

            </a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <div class="parent-icon">
            <ion-icon name="wallet-outline"></ion-icon>
        </div>
        <div class="menu-title">Reports</div>

    </a>
    <ul>

        <li>
            <a href="{{route('earningsCountries')}}">
                <div class="parent-icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </div>
                <div class="menu-title">{{__('Earnings')}}</div>

            </a>
        </li>

    </ul>
</li>

    <li>
        <a href="javascript:;">
            <div class="parent-icon">
                <ion-icon name="settings-outline"></ion-icon>
            </div>
            <div class="menu-title">Settings</div>

        </a>
        <ul>

            <li>
                <a href="{{route('admin.orders.settings.countries')}}">
                    <div class="parent-icon">
                        <ion-icon name="cube-outline"></ion-icon>
                    </div>
                    <div class="menu-title">{{__(' Order Settings ')}}</div>
                </a>
            </li>

        </ul>
    </li>
