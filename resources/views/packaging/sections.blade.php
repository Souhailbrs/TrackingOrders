 <div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('packaging.home')}}">
                <i class="fas fa-home"></i>
                <span> {{__('Packaging Dashboard')}} </span>
            </a>
        </li>

        <li>
            <a href="{{route('packaging.wrapping.index',[''])}}" >
                <i class="fas fa-book"></i>
                <span>Print Labels</span>
            </a>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-layer-group"></i>
                <span>Sent Orders</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('packaging.wrapping.sentOrders',['day'=>'today','filter'=>'all'])}}">{{__('Today Order')}}</a></li>
                <li><a href="{{route('packaging.wrapping.sentOrders',['day'=>'all','filter'=>'all'])}}">{{__('All Orders')}}</a></li>
            </ul>
        </li>





    </ul>
</div>
