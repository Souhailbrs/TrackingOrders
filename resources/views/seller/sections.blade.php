 <div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('seller.home',['type_users'=>$type_users])}}">
                <i class="fas fa-home"></i>
                <span> {{__('Seller Dashboard')}} </span>
            </a>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fas fa-hospital"></i>
                <span>Sells Channels</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                <li><a href="{{route('seller.sellChannels.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('seller.sellChannels.create')}}">{{__('Add New Channel')}}</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Inventory</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">


                <li><a href="{{route('seller.inventory.requests')}}">{{__('My Requests')}}</a></li>
                <li><a href="{{route('seller.inventories.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('seller.inventories.create')}}">{{__('Add To Inventory')}}</a></li>


            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-home"></i>
                <span>Products</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('seller.products.index')}}">{{__('My Products')}}</a></li>
                <li><a href="{{route('seller.products.create')}}">{{__('Add New Product')}}</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-layer-group"></i>
                <span>Orders</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('seller.orders.index')}}">{{__('View All')}}</a></li>
                <li><a href="{{route('seller.orders.create')}}">{{__('Add New Order')}}</a></li>
            </ul>
        </li>






    </ul>
</div>
