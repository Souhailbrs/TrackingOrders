 <div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class=" list-unstyled" id="side-menu">
        <li>
            <a href="{{route('delivery.home',['filter'=>'today'])}}">
                <i class="fas fa-home"></i>
                <span> {{__('delivery Dashboard')}} </span>
            </a>
        </li>


        <li>
            <a href="{{route('delivery.home',['filter'=>'today'])}}" >
                <i class=" fas fa-layer-group"></i>
                <span>Today Orders</span>
            </a>
        </li>

        <li>
            <a href="{{route('delivery.home',['filter'=>'finishedToday'])}}" >
                <i class=" fas fa-layer-group"></i>
                <span>Finished Today</span>
            </a>
        </li>
        <li>
            <a href="{{route('delivery.home',['filter'=>'yesterday'])}}" >
                <i class=" fas fa-layer-group"></i>
                <span>Yesterday Orders</span>
            </a>
        </li>

        <li>
            <a href="{{route('delivery.home',['filter'=>'old'])}}" >
                <i class=" fas fa-layer-group"></i>
                <span>Old Orders</span>
            </a>
        </li>



        <li>
            <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}">
                <i class="fas fa-language"></i>
                <span> Arabic </span>
            </a>

        </li>
        <li>
            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                <i class="fas fa-language"></i>
                <span> English </span>
            </a>

        </li>
    </ul>
</div>
