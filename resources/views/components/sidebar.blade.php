<aside class="sidebar bg-light border-end vh-100 d-flex flex-column p-2">
    
    <!-- Branding / Profile -->
    <div class="sidebar-brand d-flex align-items-center gap-2 px-2 py-3 mb-3 border-bottom">
        <img src="{{ asset('assets/images/illustrator-avatar.png') }}" 
             alt="Super Admin" 
             width="36" 
             height="36" 
             class="rounded-circle border">
        <span class="fw-semibold link-text">Super Admin</span>
    </div>
    
    <!-- Menu -->
    <ul class="list-unstyled m-0 p-0 flex-grow-1">
        <li class="mb-1">
            <a href="{{ route(Auth::user()->role . '.dashboard') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs(Auth::user()->role.'.dashboard') ? 'active' : '' }}">
                <span class="icon-circle bg-primary text-white"><i class="ri-dashboard-line"></i></span>
                <span class="link-text">Dashboard</span>
            </a>
        </li>

        <li class="mb-1">
            <a href="{{ route(Auth::user()->role . '.users.index') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs(Auth::user()->role.'.users.*') ? 'active' : '' }}">
                <span class="icon-circle bg-warning text-white"><i class="ri-user-3-line"></i></span>
                <span class="link-text">Manajemen Pengguna</span>
            </a>
        </li>

        <li class="mb-1">
            <a href="{{ route(Auth::user()->role . '.products') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs(Auth::user()->role.'.products*') ? 'active' : '' }}">
                <span class="icon-circle bg-info text-white"><i class="ri-shopping-bag-line"></i></span>
                <span class="link-text">Manajemen Produk</span>
            </a>
        </li>

        <li class="mb-1">
            <a href="{{ route(Auth::user()->role . '.transactions') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs(Auth::user()->role.'.transactions*') ? 'active' : '' }}">
                <span class="icon-circle bg-danger text-white"><i class="ri-exchange-dollar-line"></i></span>
                <span class="link-text">Transaksi</span>
            </a>
        </li>

        <li class="mb-1">
            <a href="{{ route('superadmin.refunds.index') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs('superadmin.refunds*') ? 'active' : '' }}">
                <span class="icon-circle bg-danger text-white"><i class="ri-refund-line"></i></span>
                <span class="link-text">Refund</span>
            </a>
        </li>

        <li class="mb-1">
            <a href="{{ route(Auth::user()->role . '.settings') }}" 
               class="d-flex align-items-center gap-2 px-3 py-2 rounded sidebar-link {{ request()->routeIs(Auth::user()->role.'.settings') ? 'active' : '' }}">
                <span class="icon-circle bg-purple text-white"><i class="ri-settings-3-line"></i></span>
                <span class="link-text">Pengaturan</span>
            </a>
        </li>
    </ul>
</aside>

<style>
    .sidebar {
        width: 220px;
        transition: width 0.3s ease, left 0.3s ease;
    }
    body.sidebar-collapsed .sidebar {
        width: 60px;
    }

    /* mobile: overlay */
    @media (max-width: 991px) {
        .sidebar {
            position: fixed;
            top: 0;
            left: -220px;
            height: 100%;
            z-index: 1050;
            background: #fff;
        }
        body.sidebar-collapsed .sidebar {
            left: 0;
        }
    }

    /* teks link */
    .sidebar .link-text {
        transition: opacity 0.3s ease, margin 0.3s ease;
    }
    body.sidebar-collapsed .sidebar .link-text {
        opacity: 0;
        margin-left: -10px;
        pointer-events: none;
    }

    /* Bulatan Icon */
    .icon-circle {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 18px;
        flex-shrink: 0;
        line-height: 1;
    }
    .icon-circle i,
    .icon-circle iconify-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        line-height: 1 !important;
        font-size: inherit;
    }

    /* Link sidebar */
    .sidebar-link {
        color: #495057;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .sidebar-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
        color: #0d6efd;
        padding-left: 1.5rem;
    }
    .sidebar-link.active {
        background-color: #0d6efd;
        color: #fff;
        font-weight: 600;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const body = document.body;
        const navToggle = document.querySelector(".sidebar-toggle"); // tombol di navbar
        const sidebarToggle = document.getElementById("sidebarToggle"); // kalau ada tombol di sidebar

        if (navToggle) {
            navToggle.addEventListener("click", () => {
                body.classList.toggle("sidebar-collapsed");
            });
        }
        if (sidebarToggle) {
            sidebarToggle.addEventListener("click", () => {
                body.classList.toggle("sidebar-collapsed");
            });
        }
    });
</script>



          <!--  <li class="sidebar-menu-group-title">Application</li>
            <li>
                  <a href="{{ route('email') }}">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Email</span>
                </a>
            </li>
            <li>
                <a href="{{ route('chatMessage') }}">
                    <iconify-icon icon="bi:chat-dots" class="menu-icon"></iconify-icon>
                    <span>Chat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('calendar') }}">
                    <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kanban') }}">
                    <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
                    <span>Kanban</span>
                </a>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Invoice</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                    <a href="{{ route('invoiceList') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                    <a href="{{ route('invoicePreview') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Preview</a>
                    </li>
                    <li>
                    <a href="{{ route('invoiceAdd') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add new</a>
                    </li>
                    <li>
                    <a href="{{ route('invoiceEdit') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Edit</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <i class="ri-robot-2-line text-xl me-6 d-flex w-auto"></i>
                    <span>Ai Application</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('textGenerator') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Text Generator</a>
                    </li>
                    <li>
                        <a href="{{ route('codeGenerator') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Code Generator</a>
                    </li>
                    <li>
                        <a href="{{ route('imageGenerator') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Image Generator</a>
                    </li>
                    <li>
                        <a href="{{ route('voiceGenerator') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Voice Generator</a>
                    </li>
                    <li>
                        <a href="{{ route('videoGenerator') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Video Generator</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <i class="ri-btc-line text-xl me-6 d-flex w-auto"></i>
                    <span>Crypto Currency</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('wallet') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Wallet</a>
                    </li>
                    <li>
                        <a href="{{ route('marketplace') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Marketplace</a>
                    </li>
                    <li>
                        <a href="{{ route('marketplaceDetails') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Marketplace Details</a>
                    </li>
                    <li>
                    <a  href="{{ route('portfolio') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Portfolios</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-menu-group-title">UI Elements</li> 

            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>Components</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('typography') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Typography</a>
                    </li>
                    <li>
                        <a  href="{{ route('colors') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Colors</a>
                    </li>
                    <li>
                        <a  href="{{ route('button') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Button</a>
                    </li>
                    <li>
                         <a  href="{{ route('dropdown') }}"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Dropdown</a>
                    </li>
                    <li>
                        <a  href="{{ route('alert') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Alerts</a>
                    </li>
                    <li>
                       <a  href="{{ route('card') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Card</a>
                    </li>
                    <li>
                        <a  href="{{ route('carousel') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Carousel</a>
                    </li>
                    <li>
                        <a  href="{{ route('avatar') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Avatars</a>
                    </li>
                    <li>
                        <a  href="{{ route('progress') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Progress bar</a>
                    </li>
                    <li>
                        <a  href="{{ route('tabs') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Tab & Accordion</a>
                    </li>
                    <li>
                        <a  href="{{ route('pagination') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Pagination</a>
                    </li>
                    <li>
                        <a  href="{{ route('badges') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Badges</a>
                    </li>
                    <li>
                        <a  href="{{ route('tooltip') }}"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Tooltip & Popover</a>
                    </li>
                    <li>
                        <a  href="{{ route('videos') }}"><i class="ri-circle-fill circle-icon text-cyan w-auto"></i> Videos</a>
                    </li>
                    <li>
                        <a  href="{{ route('starRating') }}"><i class="ri-circle-fill circle-icon text-indigo w-auto"></i> Star Ratings</a>
                    </li>
                    <li>
                        <a  href="{{ route('tags') }}"><i class="ri-circle-fill circle-icon text-purple w-auto"></i> Tags</a>
                    </li>
                    <li>
                        <a  href="{{ route('list') }}"><i class="ri-circle-fill circle-icon text-red w-auto"></i> List</a>
                    </li>
                    <li>
                        <a  href="{{ route('calendar') }}"><i class="ri-circle-fill circle-icon text-yellow w-auto"></i> Calendar</a>
                    </li>
                    <li>
                        <a  href="{{ route('radio') }}"><i class="ri-circle-fill circle-icon text-orange w-auto"></i> Radio</a>
                    </li>
                    <li>
                        <a  href="{{ route('switch') }}"><i class="ri-circle-fill circle-icon text-pink w-auto"></i> Switch</a>
                    </li>
                    <li>
                        <a  href="{{ route('imageUpload') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Upload</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                    <span>Forms</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('form') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Input Forms</a>
                    </li>
                    <li>
                        <a  href="{{ route('formLayout') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Input Layout</a>
                    </li>
                    <li>
                        <a  href="{{ route('formValidation') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Form Validation</a>
                    </li>
                    <li>
                        <a  href="{{ route('wizard') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Form Wizard</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                    <span>Table</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('tableBasic') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Basic Table</a>
                    </li>
                    <li>
                        <a  href="{{ route('tableData') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Data Table</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="solar:pie-chart-outline" class="menu-icon"></iconify-icon>
                    <span>Chart</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('lineChart') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Line Chart</a>
                    </li>
                    <li>
                        <a  href="{{ route('columnChart') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Column Chart</a>
                    </li>
                    <li>
                        <a  href="{{ route('pieChart') }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Pie Chart</a>
                    </li>
                </ul>
            </li>
            <li>
                <a  href="{{ route('widgets') }}">
                    <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                    <span>Widgets</span>
                </a>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('usersList') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List</a>
                    </li>
                    <li>
                        <a  href="{{ route('usersGrid') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Users Grid</a>
                    </li>
                    <li>
                        <a  href="{{ route('addUser') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add User</a>
                    </li>
                    <li>
                        <a  href="{{ route('viewProfile') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> View Profile</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <i class="ri-user-settings-line text-xl me-6 d-flex w-auto"></i>
                    <span>Role & Access</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('roleAaccess') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Role & Access</a>
                    </li>
                    <li>
                        <a  href="{{ route('assignRole') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Assign Role</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-menu-group-title">Application</li>

            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="simple-line-icons:vector" class="menu-icon"></iconify-icon>
                    <span>Authentication</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('signin') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Sign In</a>
                    </li>
                    <li>
                        <a  href="{{ route('signup') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Sign Up</a>
                    </li>
                    <li>
                        <a  href="{{ route('forgotPassword') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Forgot Password</a>
                    </li>
                </ul>
            </li>
            <li>
                <a  href="{{ route('gallery') }}">
                    <iconify-icon icon="solar:gallery-wide-linear" class="menu-icon"></iconify-icon>
                    <span>Gallery</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('pricing') }}">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Pricing</span>
                </a>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <i class="ri-news-line text-xl me-6 d-flex w-auto"></i>
                    <span>Blog</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('blog') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Blog</a>
                    </li>
                    <li>
                        <a  href="{{ route('blogDetails') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Blog Details</a>
                    </li>
                    <li>
                        <a  href="{{ route('addBlog') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add Blog</a>
                    </li>
                </ul>
            </li>
            <li>
                <a  href="{{ route('testimonials') }}">
                    <i class="ri-star-line text-xl me-6 d-flex w-auto"></i>
                    <span>Testimonial</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('faq') }}">
                    <iconify-icon icon="mage:message-question-mark-round" class="menu-icon"></iconify-icon>
                    <span>FAQs</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('error') }}">
                    <iconify-icon icon="streamline:straight-face" class="menu-icon"></iconify-icon>
                    <span>404</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('termsCondition') }}">
                    <iconify-icon icon="octicon:info-24" class="menu-icon"></iconify-icon>
                    <span>Terms & Conditions</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('comingSoon') }}">
                    <i class="ri-rocket-line text-xl me-6 d-flex w-auto"></i>
                    <span>Coming Soon</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('maintenance') }}">
                    <i class="ri-hammer-line text-xl me-6 d-flex w-auto"></i>
                    <span>Maintenance</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('blankPage') }}">
                    <i class="ri-checkbox-multiple-blank-line text-xl me-6 d-flex w-auto"></i>
                    <span>Blank Page</span>
                </a>
            </li> 
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a  href="{{ route('company') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Company</a>
                    </li>
                    <li>
                        <a  href="{{ route('notification') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Notification</a>
                    </li>
                    <li>
                        <a  href="{{ route('notificationAlert') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Notification Alert</a>
                    </li>
                    <li>
                        <a  href="{{ route('theme') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Theme</a>
                    </li>
                    <li>
                        <a  href="{{ route('currencies') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Currencies</a>
                    </li>
                    <li>
                        <a  href="{{ route('language') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Languages</a>
                    </li>
                    <li>
                        <a  href="{{ route('paymentGateway') }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Payment Gateway</a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</aside>