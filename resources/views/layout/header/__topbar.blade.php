<div class="d-flex align-items-stretch flex-shrink-0">
    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img src="{{ asset('/assets/media/avatars/blank.png') }}" alt="user" />
        </div>
        <!--layout-partial:partials/menus/_user-account-menu.html-->
        @include('partials.menus._user-account-menu')
    </div>
</div>
