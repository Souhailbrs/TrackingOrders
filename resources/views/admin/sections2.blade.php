<div id="sidebar-menu" >
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('admin.home',['type_users'=>'all'])}}" >
                <div class="menu-title">{{__('Admin Dashboard')}} </div>
                <div class="parent-icon">
                    <ion-icon name="home-sharp"></ion-icon>
                </div>
            </a>
        </li>


        <li>
            <a href="javascript:;" >
                <div class="menu-title">Manage Users</div>
                <div class="parent-icon">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </a>
            <ul>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-user-plus"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{route('users.get.type',['type'=>'sellers'])}}" >
                                <div class="menu-title">{{__('View All')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('users.create')}}" >
                                <div class="menu-title">{{__('Add New User')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-user-plus"></i>
                        <span>Join Requests</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{route('show.requests',['avilable'])}}" >
                                <div class="menu-title">{{__('Available')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="mail-unread-outline"></ion-icon>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('show.requests',['contacted'])}}" >
                                <div class="menu-title">{{__('Contacted')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="call-outline"></ion-icon>                                </div>
                            </a>
                        </li>



                    </ul>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript:;" >
                <div class="menu-title">Sells Channels</div>
                <div class="parent-icon">
                    <ion-icon name="storefront-outline"></ion-icon>
                </div>
            </a>
            <ul>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-user-plus"></i>
                        <span>Shops Type</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{route('shopTypes.index')}}" >
                                <div class="menu-title">{{__('View All')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('shopTypes.create')}}" >
                                <div class="menu-title">{{__('Add New Type')}}</div>
                                <div class="parent-icon">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="{{route('sellChannels.index')}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('sellChannels.create')}}" >
                        <div class="menu-title">{{__('Add New Channel')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript:;" >
                <div class="menu-title">Inventory</div>
                <div class="parent-icon">
                    <ion-icon name="wallet-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('get.products')}}" >
                        <div class="menu-title">{{__('Products')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="cube-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('get.shipments')}}" >
                        <div class="menu-title">{{__('Shipments')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('showRequests')}}" >
                        <div class="menu-title">{{__('Requests')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="arrow-redo-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" >
                <div class="menu-title">{{__('Orders')}} </div>
                <div class="parent-icon">
                    <ion-icon name="cube-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('admin.orders.index',['state'=>'today','from'=>1,'to'=>1])}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="javascript: void(0);" >
                <div class="menu-title">{{__('Countries')}} </div>
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('countries.index')}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('countries.create')}}" >
                        <div class="menu-title">{{__('Add New')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" >
                <div class="menu-title">{{__('Cities')}} </div>
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('cities.index')}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('cities.create')}}" >
                        <div class="menu-title">{{__('Add New')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" >
                <div class="menu-title">{{__('Zones')}} </div>
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('zones.index')}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('zones.create')}}" >
                        <div class="menu-title">{{__('Add New')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" >
                <div class="menu-title">{{__('Districts')}} </div>
                <div class="parent-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                </div>
            </a>
            <ul>

                <li>
                    <a href="{{route('districts.index')}}" >
                        <div class="menu-title">{{__('View All')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('districts.create')}}" >
                        <div class="menu-title">{{__('Add New')}}</div>
                        <div class="parent-icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </a>
                </li>
            </ul>
        </li>



    </ul>
</div>
