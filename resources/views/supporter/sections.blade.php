 <div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('supporter.home')}}">
                <i class="fas fa-home"></i>
                <span> {{__('Call Center  Dashboard')}} </span>
            </a>
        </li>



<!--
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class=" fas fa-school"></i>
                <span>Today Work</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('supporter.workState',['state'=>'start'])}}">{{__('Start Work')}}</a></li>
                <li><a href="{{route('supporter.workState',['state'=>'end'])}}">{{__('End Work')}}</a></li>
            </ul>
        </li>-->
        <li>
            <a href="{{route('supporter.getOrder')}}" >
                <i class="fas fa-box-open	"></i>
                <span>{{__('Get Order')}}</span>
            </a>
        </li>



        <li>
            <a href="{{route('supporter.orders.index',['state'=>'today','from'=>'1','to'=>'1'])}}" >
                <i class=" fas fa-boxes	"></i>
                <span>{{__('View Orders')}}</span>
            </a>
        </li>


    </ul>
</div>
