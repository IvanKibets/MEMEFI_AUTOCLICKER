<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            @if(\Auth::user()->profile_photo_path!="")
                <img src="{{ \Auth::user()->profile_photo_path }}" class="rounded-circle user-photo" alt="User Profile Picture">
            @endif
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ isset(\Auth::user()->name)?\Auth::user()->name :''}}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{route('profile')}}"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="{{route('setting')}}"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            {{-- <hr> --}}
            {{-- <ul class="row list-unstyled">
                <li class="col-4">
                    <small>Member</small>
                    <h6>{{format_idr(\App\Models\UserMember::count())}}</h6>
                </li>
                <li class="col-4">
                    <small>Koordinator</small>
                    <h6>{{format_idr(\App\Models\Koordinator::count())}}</h6>
                </li>
                <li class="col-4">
                    <small>Revenue</small>
                    <h6>0</h6>
                </li>
            </ul> --}}
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['setting','user', 'product-supplier', 'purchase-order-supplier']) ? 'active':'')}}" data-toggle="tab" href="#menu">Data</a></li>
            <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['user-member']) ? 'active':'')}}" data-toggle="tab" href="#tab_anggota">Anggota</a></li>
            <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['transaksi','product','invoice-transaksi','purchase-order']) ? 'active':'')}}" data-toggle="tab" href="#tab_toko">Toko</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane {{in_array(Request::segment(1),['user-member','user-simpanan','shu','pinjaman']) ? 'active':''}}" id="tab_anggota">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    
                        <li class="{{ Request::segment(1) === 'user-member' ? 'active' : null }}">
                            <a href="{{route('user-member.index')}}">
                                <img src="{{asset('assets/images/icon/link.png')}}" class="mr-20" />
                                <span>Anggota</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'iuran' ? 'active' : null }}">
                            <a href="{{route('user-simpanan.index')}}">
                                <img src="{{asset('assets/images/icon/wallet.png')}}" class="mr-20" />
                                <span>Simpanan</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'pinjaman' ? 'active' : null }}">
                            <a href="{{route('pinjaman.index')}}">
                                <img src="{{asset('assets/images/icon/borrow.png')}}" class="mr-20" />
                                <span>Pinjaman</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'iuran' ? 'active' : null }}">
                            <a href="{{route('shu.index')}}">
                                <img src="{{asset('assets/images/icon/invest.png')}}" class="mr-20" />
                                <span>SHU</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="tab-pane {{in_array(Request::segment(1),['transaksi','product','invoice-transaksi','purchase-order','user-supplier','voucher']) ? 'active':''}}" id="tab_toko">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    
                        <li class="{{ Request::segment(1) === 'transaksi' ? 'active' : null }}">
                            <a href="{{route('transaksi.index')}}">
                            <img src="{{asset('assets/images/icon/transaction.png')}}" class="mr-20" />
                            <span>Transaksi</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'product' ? 'active' : null }}">
                            <a href="{{route('product.index')}}">
                            <img src="{{asset('assets/images/icon/product.png')}}" class="mr-20" />
                            <span>Product</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'user-supplier' ? 'active' : null }}">
                            <a href="{{route('user-supplier.index')}}">
                            <img src="{{asset('assets/images/icon/supplier.png')}}?v=1" class="mr-20" />
                            <span>Supplier</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'purchase-order' ? 'active' : null }}">
                            <a href="{{route('purchase-order.index')}}">
                            <img src="{{asset('assets/images/icon/purchase-order.png')}}?v=1" class="mr-20" />
                            <span>Purchase Order</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'invoice-transaksi' ? 'active' : null }}">
                            <a href="{{route('invoice-transaksi.index')}}">
                            <img src="{{asset('assets/images/icon/invoice.png')}}" class="mr-20" />
                            <span>Invoice</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'voucher' ? 'active' : null }}">
                            <a href="{{route('voucher.index')}}">
                            <img src="{{asset('assets/images/icon/invoice.png')}}" class="mr-20" />
                            <span>Voucher</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="tab-pane {{(in_array(Request::segment(1),['setting','user','simpanan','jenis-pinjaman']) ? 'active':'')}}"" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    
                        @if(\Auth::user()->user_access_id==1)<!--Administrator-->                   
                            <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                                <a href="/"><i class="icon-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'bank-account') ? 'active' : null }}">
                                <a href="{{route('bank-account.index')}}"><i class="fa fa-bank"></i>Bank Account</a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'user') ? 'active' : null }}">
                                <a href="{{route('users.index')}}"><i class="fa fa-users"></i>User</a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'log-activity') ? 'active' : null }}">
                                <a href="{{route('log-activity.index')}}"><i class="fa fa-history"></i>Log Activity</a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'setting') ? 'active' : null }}">
                                <a href="javascript:void(0)" class="has-arrow"><i class="fa fa-gear"></i><span>Pengaturan</span></a>
                                <ul>
                                    <li class="{{ Request::segment(1) === 'setting' ? 'active' : null }}"><a href="{{route('setting')}}">Umum</a></li>
                                    <!-- <li class="{{ Request::segment(1) === 'simpanan' ? 'active' : null }}"><a href="{{route('simpanan.index')}}">Simpanan</a></li> -->
                                    <li class="{{ Request::segment(1) === 'jenis-pinjaman' ? 'active' : null }}"><a href="{{route('jenis-pinjaman.index')}}">Pinjaman</a></li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>    
            
            
            <div class="tab-pane {{(in_array(Request::segment(1),['product-supplier','purchase-order-supplier']) ? 'active':'')}}" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    

                        @if(\Auth::user()->user_access_id==7)<!--Supplier-->                   
                         
                            
                        @endif
                    </ul>
                </nav>
            </div>    
        </div>          
    </div>
</div>
