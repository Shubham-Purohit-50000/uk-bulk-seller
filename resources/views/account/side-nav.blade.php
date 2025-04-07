<!-- nav bar -->
<div class="wrap-sidebar-account">
    <div class="sidebar-account">
        <div class="account-avatar">
            <div class="image">
                <img src="{{asset('frontend/images/avatar/user-account.jpg')}}" alt="">
            </div>
            <h6 class="mb_4">{{auth()->user()->name}}</h6>
            <div class="body-text-1">{{auth()->user()->email}}</div>
        </div>
        <ul class="my-account-nav">
            <li>
                <a href="{{url('account')}}" class="my-account-nav-item {{ request()->is('account') ? 'active' : '' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Account Details
                </a>
            </li>
            <li>
                <a href="{{url('my-orders')}}" class="my-account-nav-item {{ request()->is('my-orders') ? 'active' : '' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    My Orders
                </a>
            </li>
            @if (auth()->user()->hasRole('company'))
            <li>
                <a href="{{url('franchises')}}" class="my-account-nav-item {{ request()->is('franchises') ? 'active' : '' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L4 4H20L21 9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 9H22" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 9V15C6 16.0609 6.42143 17.0783 7.17157 17.8284C7.92172 18.5786 8.93913 19 10 19H14C15.0609 19 16.0783 18.5786 16.8284 17.8284C17.5786 17.0783 18 16.0609 18 15V9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 13H14" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                    Franchises
                </a>
            </li>
            <li>
                <a href="{{url('create-franchise')}}" class="my-account-nav-item {{ request()->is('create-franchise') ? 'active' : '' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 12H19" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                    Create Franchises
                </a>
            </li>
            @endif

            @if (auth()->user()->hasRole('relational-manager'))
            <li>
                <a href="{{url('create-store')}}" class="my-account-nav-item {{ request()->is('create-store') ? 'active' : '' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 12H19" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                    Create Franchises
                </a>
            </li>
            @endif
            
            <li>
                <a href="{{url('logout')}}" class="my-account-nav-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 17L21 12L16 7" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12H9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- end nav bar -->