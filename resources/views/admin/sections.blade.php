 <div id="sidebar-menu" >
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('admin.home',['type_users'=>'all'])}}">
                <i class="fas fa-home"></i>
                <span> {{__('Admin Dashboard')}} </span>
            </a>
        </li>
             {{-- <a href="javascript: void(0);" class="has-arrow">
            <i class="fas fa-users"></i>
            <span> {{__('section.dashboard')}} </span>
        </a> --}}
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fas fa-users"></i>
                <span>Manage Users </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                {{--User Types--}}
{{--
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-user-cog"></i>
                        <span>User Types</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('usersTypes.index')}}">{{__('View All')}}</a></li>
                        <li><a href="{{route('usersTypes.create')}}">{{__('Add New Type')}}</a></li>
                    </ul>
                </li>
--}}
                {{--Privilages--}}
<!--                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-users-cog"></i>
                        <span>Privileges</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('usersPrivileges.index')}}">{{__('View All')}}</a></li>
                        <li><a href="{{route('usersPrivileges.create')}}">{{__('Add New Privilege')}}</a></li>
                    </ul>
                </li>-->
                {{--Manage Users--}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class=" fas fa-user-plus"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('users.get.type',['type'=>'sellers'])}}">{{__('View All')}}</a></li>
                        <li><a href="{{route('users.create')}}">{{__('Add New User')}}</a></li>
                    </ul>
                </li>
                <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class=" fas fa-user-plus"></i>
                            <span>Join Requests</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{route('show.requests',['avilable'])}}">{{__('Available')}}</a></li>
                            <li><a href="{{route('show.requests',['contacted'])}}">{{__('Contacted')}}</a></li>
<!--
                            <li><a href="{{route('show.requests',['penddingAccept'])}}">{{__('Pending Accept')}}</a></li>
-->

                        </ul>
                    </li>
            </ul>

        </li>
<!--
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-coins"></i>
                <span>Order Status</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="">{{__('View All')}}</a></li>
                <li><a href="">{{__('Add New Status')}}</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-coins"></i>
                <span>Packages</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('packages.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('packages.create')}}">{{__('Add New User')}}</a></li>
            </ul>
        </li>-->
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fas fa-hospital"></i>
                <span>Sells Channels</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Shops Type</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('shopTypes.index')}}">{{__('View All')}}</a></li>
                        <li><a href="{{route('shopTypes.create')}}">{{__('Add New Type')}}</a></li>
                    </ul>
                </li>
                <li><a href="{{route('sellChannels.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('sellChannels.create')}}">{{__('Add New Channel')}}</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Inventory</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('get.products')}}">{{__('Products')}}</a></li>
                <li><a href="{{route('get.shipments')}}">{{__('Shipments')}}</a></li>

                <li><a href="{{route('showRequests')}}">{{__('Requests')}}</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-layer-group"></i>
                <span>Orders</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('admin.orders.index',['state'=>'today','from'=>1,'to'=>1])}}">{{__('View All')}}</a></li>
            </ul>
        </li>



        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Countries</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('countries.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('countries.create')}}">{{__('Add New')}}</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Cities</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('cities.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('cities.create')}}">{{__('Add New')}}</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Zones</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('zones.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('zones.create')}}">{{__('Add New')}}</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Districts</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('districts.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('districts.create')}}">{{__('Add New')}}</a></li>
            </ul>
        </li>




    </ul>
</div>
