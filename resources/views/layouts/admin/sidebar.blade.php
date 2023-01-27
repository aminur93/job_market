<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Public Market</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @hasrole('admin')
            @php
                $user_image = \Illuminate\Support\Facades\Auth::user()->profile_image;
            @endphp
            @if ($user_image != null)
            <div class="image">
                <img src="{{ asset('assets/admin/uploads/user/original/'.$user_image) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            @else
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            @endif
            
            <div class="info">
                <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
            </div>
            @endhasrole

            @hasrole('marchent')
                @php
                    $user_image = \Illuminate\Support\Facades\Auth::user()->profile_image;
                @endphp
                @if ($user_image != null)
                <div class="image">
                    <img src="{{ asset('assets/frontend/upload/merchant/'.$user_image) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                @else
                <div class="image">
                    <img src="{{ asset('assets/frontend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                @endif
                
                <div class="info">
                    <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                </div>
            @endhasrole
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @hasrole('admin')
                
                <li class="nav-item has-treeview {{ Request::routeIs('category', 'category.create', 'category.edit', 'sub_category','sub_category.create','sub_category.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('category', 'category.create', 'category.edit', 'sub_category','sub_category.create','sub_category.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Ads Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            @hasrole('admin')
                            <a href="{{ route('category') }}" class="nav-link {{ Request::routeIs('category', 'category.create', 'category.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                           

                            <a href="{{ route('sub_category') }}" class="nav-link {{ Request::routeIs('sub_category','sub_category.create','sub_category.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                            @endhasrole
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('admin|marchent')
                <li class="nav-item">
                    <a href="{{ route('ads') }}" class="nav-link {{ Request::routeIs('ads','ads.create','ads.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ad"></i>
                        <p>Ads</p>
                    </a>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item">
                    <a href="{{ route('ads_price') }}" class="nav-link {{ Request::routeIs('ads_price','ads_price.create','ads_price.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Ads Pricing</p>
                    </a>
                </li>
                @endhasrole

                @hasrole('admin|marchent')
                <li class="nav-item has-treeview {{ Request::routeIs('ads_banner_category', 'ads_banner_category.create', 'ads_banner_category.edit', 'ads_banner','ads_banner.create','ads_banner.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('ads_banner_category', 'ads_banner_category.create', 'ads_banner_category.edit', 'ads_banner','ads_banner.create','ads_banner.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-image"></i>
                        <p>
                            Ads Banner
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            @hasrole('admin')
                            <a href="{{ route('ads_banner_category') }}" class="nav-link {{ Request::routeIs('ads_banner_category', 'ads_banner_category.create', 'ads_banner_category.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banner Category</p>
                            </a>
                            @endhasrole

                            <a href="{{ route('ads_banner') }}" class="nav-link {{ Request::routeIs('ads_banner','ads_banner.create','ads_banner.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banner</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('admin|marchent')
                <li class="nav-item has-treeview {{ Request::routeIs('tvc','tvc.create','tvc.edit', 'auto_tv','auto_tv.create','auto_tv.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('tvc','tvc.create','tvc.edit', 'auto_tv','auto_tv.create','auto_tv.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-tv"></i>
                        <p>
                            Tvc
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{ route('tvc') }}" class="nav-link {{ Request::routeIs('tvc', 'tvc.create', 'tvc.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tvc Tv</p>
                            </a>
                            
                            @hasrole('admin')
                            <a href="{{ route('auto_tv') }}" class="nav-link {{ Request::routeIs('auto_tv','auto_tv.create','auto_tv.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Auto Tv</p>
                            </a>
                            @endhasrole
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('admin|marchent')
                <li class="nav-item has-treeview {{ Request::routeIs('job_category','job_category.create','job_category.edit', 'job','job.create','job.edit', 'cv_upload','cv_upload.view') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('job_category','job_category.create','job_category.edit', 'job','job.create','job.edit', 'cv_upload','cv_upload.view') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-handshake"></i>
                        <p>
                            Job bank
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            @hasrole('admin')
                            <a href="{{ route('job_category') }}" class="nav-link {{ Request::routeIs('job_category','job_category.create','job_category.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Job Category</p>
                            </a>
                            @endhasrole

                            
                            <a href="{{ route('job') }}" class="nav-link {{ Request::routeIs('job','job.create','job.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Job</p>
                            </a>
                           

                            <a href="{{ route('cv_upload') }}" class="nav-link {{ Request::routeIs('cv_upload','cv_upload.view') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cv Upload</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fa fa-paper-plane"></i>
                        <p>Sending Sms</p>
                    </a>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-regular fa-clipboard"></i>
                        <p>Subcriptions</p>
                    </a>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item">
                    <a href="{{ route('subscriber') }}" class="nav-link {{ Request::routeIs('subscriber') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-rocket"></i>
                        <p>Subscriber</p>
                    </a>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item has-treeview {{ Request::routeIs('permission','permission.create','permission.edit', 'role','role.create','role.edit', 'user','user.create','user.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('permission','permission.create','permission.edit', 'role','role.create','role.edit', 'user','user.create','user.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{ route('user') }}" class="nav-link {{ Request::routeIs('user','user.create','user.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>

                            <a href="{{ route('role') }}" class="nav-link {{ Request::routeIs('role','role.create','role.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role</p>
                            </a>

                            <a href="{{ route('permission') }}" class="nav-link {{ Request::routeIs('permission','permission.create','permission.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole

                @hasrole('admin')
                <li class="nav-item has-treeview {{ Request::routeIs('division', 'division.create','division.edit', 'district', 'district.create','district.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('division', 'division.create','division.edit', 'district', 'district.create','district.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{ route('division') }}" class="nav-link {{ Request::routeIs('division', 'division.create','division.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Divison</p>
                            </a>

                            <a href="{{ route('district') }}" class="nav-link {{ Request::routeIs('district', 'district.create','district.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>District</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasrole
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>