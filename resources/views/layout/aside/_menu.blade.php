<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
    <!--begin::Menu-->
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
        <div class="menu-item">
            <a class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        @if (auth()->user()->can('read-surat-masuk') || auth()->user()->can('read-surat-keluar') || auth()->user()->can('read-dokumen'))
        <div data-kt-menu-trigger="click" class="menu-item {{ request()->is('arsip*') ? 'here show' : '' }} menu-accordion">
            <span class="menu-link">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/files/fil012.svg-->
                    <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Arsip (inactive)</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                @if (auth()->user()->can('read-dokumen'))
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('arsip/dokumen*') ? 'active' : '' }}" href="{{ url('arsip/dokumen') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Dokumen</span>
                    </a>
                </div>
                @endif
                @if (auth()->user()->can('read-surat-masuk') || auth()->user()->can('read-surat-keluar'))
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('arsip/surat*') ? 'active' : '' }}" href="{{ url('arsip/surat') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Surat</span>
                    </a>
                </div>
                @endif

            </div>
        </div>
        @endif
        @if (auth()->user()->can('read-surat-masuk') || auth()->user()->can('read-surat-keluar'))
        <div data-kt-menu-trigger="click" class="menu-item {{ request()->is('surat*') ? 'here show' : '' }} menu-accordion">
            <span class="menu-link">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Surat</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                {{-- start: Menu Surat Masuk --}}
                @if (auth()->user()->can('read-surat-masuk'))
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('suratmasuk*') ? 'active' : '' }}" href="{{ url('suratmasuk') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Masuk</span>
                    </a>
                </div>
                @endif
                {{-- end: Menu Surat Masuk --}}
                {{-- start: Menu Surat Keluar --}}
                @if (auth()->user()->can('read-surat-keluar'))
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('suratkeluar*') ? 'active' : '' }}" href="{{ url('suratkeluar') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Keluar</span>
                    </a>
                </div>
                @endif
                {{-- end: Menu Surat Keluar --}}

            </div>
        </div>
        @endif

        @if (auth()->user()->can('read-laporan'))
        <div class="menu-item">
            <a class="menu-link  {{ request()->is('laporan') ? 'active' : '' }}" href="{{ url('laporan') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/files/fil025.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="currentColor" />
                            <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="currentColor" />
                            <path d="M10.3629 14.0084L8.92108 12.6429C8.57518 12.3153 8.03352 12.3153 7.68761 12.6429C7.31405 12.9967 7.31405 13.5915 7.68761 13.9453L10.2254 16.3488C10.6111 16.714 11.215 16.714 11.6007 16.3488L16.3124 11.8865C16.6859 11.5327 16.6859 10.9379 16.3124 10.5841C15.9665 10.2565 15.4248 10.2565 15.0789 10.5841L11.4631 14.0084C11.1546 14.3006 10.6715 14.3006 10.3629 14.0084Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Laporan</span>
            </a>
        </div>
        @endif

        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Data Master</span>
            </div>
        </div>
        {{-- start: Menu Komponen --}}
        @if (auth()->user()->can('read-komponen'))
        <div class="menu-item">
            <a class="menu-link {{ request()->is('data-master/komponen') ? 'active' : '' }}" href="{{ url('data-master/komponen') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor" />
                            <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Komponen</span>
            </a>
        </div>
        @endif
        {{-- end: Menu Komponen --}}
        {{-- start: Menu Klasifikasi --}}
        @if (auth()->user()->can('read-klasifikasi'))
        <div class="menu-item">
            <a class="menu-link {{ request()->is('data-master/klasifikasi') ? 'active' : '' }}" href="{{ url('data-master/klasifikasi') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
                            <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
                            <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
                            <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Klasifikasi</span>
            </a>
        </div>
        @endif
        {{-- end: Menu Klasifikasi --}}
        {{-- start: Menu Kearsipan --}}
        @if (auth()->user()->can('read-kearsipan'))
        <div class="menu-item">
            <a class="menu-link {{ request()->is('data-master/kearsipan') ? 'active' : '' }}" href="{{ url('data-master/kearsipan') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21 11H18.9C18.5 7.9 16 5.49998 13 5.09998V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V5.09998C7.9 5.49998 5.50001 8 5.10001 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H5.10001C5.50001 16.1 8 18.4999 11 18.8999V21C11 21.6 11.4 22 12 22C12.6 22 13 21.6 13 21V18.8999C16.1 18.4999 18.5 16 18.9 13H21C21.6 13 22 12.6 22 12C22 11.4 21.6 11 21 11ZM12 17C9.2 17 7 14.8 7 12C7 9.2 9.2 7 12 7C14.8 7 17 9.2 17 12C17 14.8 14.8 17 12 17Z" fill="currentColor" />
                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Kearsipan</span>
            </a>
        </div>
        @endif
        {{-- end: Menu Kearsipan --}}
        {{-- start: Menu Template Surat --}}
        @if (auth()->user()->can('read-template'))
        <div class="menu-item">
            <a class="menu-link {{ request()->is('data-master/template') ? 'active' : '' }}" href="{{ url('data-master/template') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21 11H18.9C18.5 7.9 16 5.49998 13 5.09998V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V5.09998C7.9 5.49998 5.50001 8 5.10001 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H5.10001C5.50001 16.1 8 18.4999 11 18.8999V21C11 21.6 11.4 22 12 22C12.6 22 13 21.6 13 21V18.8999C16.1 18.4999 18.5 16 18.9 13H21C21.6 13 22 12.6 22 12C22 11.4 21.6 11 21 11ZM12 17C9.2 17 7 14.8 7 12C7 9.2 9.2 7 12 7C14.8 7 17 9.2 17 12C17 14.8 14.8 17 12 17Z" fill="currentColor" />
                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Template Surat</span>
            </a>
        </div>
        @endif
        {{-- end: Menu Template Surat --}}
        {{-- start: Menu Sifat Surat --}}
        @if (auth()->user()->can('read-sifat-surat'))
        <div class="menu-item">
            <a class="menu-link {{ request()->is('data-master/jenissurat') ? 'active' : '' }}" href="{{ url('data-master/jenissurat') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.6533 10.129L11.2291 18.5532C10.1971 19.5852 8.7974 20.165 7.3379 20.165C5.8784 20.165 4.47867 19.5852 3.44665 18.5532C2.41462 17.5212 1.83484 16.1214 1.83484 14.6619C1.83484 13.2024 2.41462 11.8027 3.44665 10.7707L11.8708 2.34651C12.5588 1.6585 13.492 1.27197 14.465 1.27197C15.438 1.27197 16.3711 1.6585 17.0591 2.34651C17.7472 3.03453 18.1337 3.96768 18.1337 4.94068C18.1337 5.91368 17.7472 6.84683 17.0591 7.53485L8.62581 15.959C8.28181 16.303 7.81523 16.4963 7.32873 16.4963C6.84223 16.4963 6.37566 16.303 6.03165 15.959C5.68764 15.615 5.49438 15.1484 5.49438 14.6619C5.49438 14.1754 5.68764 13.7089 6.03165 13.3648L13.8141 5.59151" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Sifat Surat</span>
            </a>
        </div>
        @endif
        {{-- end: Menu Sifat Surat --}}
        @if (auth()->user()->can('read-user'))
        <div data-kt-menu-trigger="click" class="menu-item {{ request()->is('data-master/user-management*') ? 'here show' : '' }} menu-accordion mb-1">
            <span class="menu-link">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
                            <path d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">User Management</span>
                <span class="menu-arrow"></span>
            </span>

            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('data-master/user-management/divisi') ? 'active' : '' }}" href="{{ url('data-master/user-management/divisi') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Bagian</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('data-master/user-management/hak-akses') ? 'active' : '' }}" href="{{ url('data-master/user-management/hak-akses') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Role</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('data-master/user-management/permission') ? 'active' : '' }}" href="{{ url('data-master/user-management/permission') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Permission</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->is('data-master/user-management/user') ? 'active' : '' }}" href="{{ url('data-master/user-management/user') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">User</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>