			<header class="logo-env">
			    <!-- logo -->
			    <div class="logo">
			        <a href="/">
			            <img src="{{asset('assets/images/logo1.png')}}" alt="" />
			        </a>
			    </div>
			    <!-- logo collapse icon -->
			    <div class="sidebar-collapse">
			        <a href="#" class="sidebar-collapse-icon with-animation">
			            <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
			            <i class="entypo-menu"></i>
			        </a>
			    </div>
			    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			    <div class="sidebar-mobile-menu visible-xs">
			        <a href="#" class="with-animation">
			            <!-- add class "with-animation" to support animation -->
			            <i class="entypo-menu"></i>
			        </a>
			    </div>
			</header>
			<ul id="main-menu" class="">

			    @if(Auth::user()->typeID == 1)
			    <li>
			        <a href="#"><i class="entypo-users"></i><span>ACCOUNTS</span></a>
			        <ul>
			            <li>
			                <a href="/accounts/create"><span>Add New</span></a>
			            </li>
			            <li>
			                <a href="/accounts"><span>View</span></a>
			            </li>
			        </ul>
			    </li>
			    <li>

			        <a href="#"><i class="entypo-doc-text"></i><span>ROOMS</span></a>
			        <ul>
			            <li>
			                <a href="/rooms/create"><span>Add New</span></a>
			            </li>
			            <li>
			                <a href="/rooms"><span>View</span></a>
			            </li>
			            <li>
			                <a href="{{url('setTime/calendar')}}">Time Schedule Setup</a>
			            </li>
			        </ul>
			    </li>
			    <li>
			        <a href="#"><i class="entypo-flow-branch"></i><span>ROLES</span></a>
			        <ul>
			            <li>
			                <a href="/showRoles"><span>View</span></a>
			            </li>
			        </ul>
			    </li>
			    <li>
			        <a href="#"><i class="entypo-tools"></i><span>DEVICE</span></a>
			        <ul>
			            <li>
			                <a href="/device/create"><span>Add New</span></a>
			            </li>
			            <li>
			                <a href="/device"><span>View</span></a>
			            </li>
			        </ul>
			    </li>
			    <li>
			        <a href="#"><i class="entypo-publish"></i>REPORT</a>
			        <ul>
			            <li>
			                <a href="/dataReading"><span>Activity Logs</span></a>
			            </li>
			            <li>
			                <a href="/summary"><span>History</span></a>
			            </li>
			        </ul>
			    </li>
			    <li>
			        <a href="#"><i class="entypo-calendar"></i>CALENDARS</a>
			        <ul>
			            <li>
			                <a href="/events"><span>Events</span></a>
			            </li>
			        </ul>
			    </li>

			    @else
			    <li>
			        <a href="#"><i class="entypo-doc-text"></i><span>ROOMS</span></a>
			        <ul>
			            <li>
			                <a href="/rooms"><span>View</span></a>
			            </li>
			        </ul>
			    </li>
			    <li>
			        <a href="#"><i class="entypo-publish"></i>Data Reading</a>
			        <ul>
			            <li>
			                <a href="/dataReading"><span>View</span></a>
			            </li>
			        </ul>
			    </li>
			    @endif
			</ul>
