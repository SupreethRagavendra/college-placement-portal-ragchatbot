<style>
    /* Ensure navbar collapse is hidden by default on mobile */
    .navbar-collapse:not(.show) {
        display: none;
    }
    
    @media (min-width: 992px) {
        .navbar-collapse {
            display: flex !important;
        }
    }
    
    /* Navbar toggler improvements */
    .navbar-toggler:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.3);
    }
    
    .navbar-toggler:not(.collapsed) {
        background-color: rgba(255,255,255,0.2);
    }
    
    /* Dropdown Menu Responsive Styles */
    .navbar .dropdown-menu {
        min-width: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        border: none;
        margin-top: 8px;
        padding: 8px 0;
    }
    
    .navbar .dropdown-item {
        padding: 10px 20px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        color: #333;
    }
    
    .navbar .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #000;
    }
    
    .navbar .dropdown-item i {
        width: 20px;
        text-align: center;
    }
    
    .navbar .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .navbar .dropdown-toggle::after {
        margin-left: 5px;
    }
    
    /* Hide dropdown by default */
    .navbar .dropdown-menu {
        display: none;
    }
    
    .navbar .dropdown-menu.show {
        display: block;
    }
    
    /* Responsive Dropdown Styles */
    @media (max-width: 991.98px) {
        .navbar .dropdown-menu {
            min-width: 180px;
            margin-top: 5px;
        }
        
        .navbar .dropdown-item {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .navbar .dropdown-toggle {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 768px) {
        .navbar-collapse {
            background: rgba(102, 126, 234, 0.98);
            margin-top: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .navbar .dropdown-menu {
            min-width: 100%;
            position: static !important;
            transform: none !important;
            margin-top: 10px;
            margin-left: 0;
            margin-right: 0;
            box-shadow: none;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
            display: none;
        }
        
        .navbar .dropdown-menu.show {
            display: block;
        }
        
        .navbar .dropdown-item {
            padding: 10px 20px;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.9);
        }
        
        .navbar .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        
        .navbar .dropdown-divider {
            border-color: rgba(255,255,255,0.2);
            margin: 8px 0;
        }
        
        .navbar .dropdown-toggle::after {
            display: inline-block;
        }
        
        .navbar .nav-link {
            padding: 10px 15px !important;
        }
    }
    
    @media (max-width: 575.98px) {
        .navbar .dropdown-menu {
            margin-top: 8px;
        }
        
        .navbar .dropdown-item {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        
        .navbar .dropdown-toggle {
            font-size: 0.85rem;
            padding: 5px 10px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('student.dashboard') }}">
            <img src="{{ asset('css/logo1-removebg-preview.png') }}" alt="College Logo" style="height: 40px; margin-right: 10px;" loading="lazy">
            <span class="d-none d-md-inline">College Placement Portal</span>
            <span class="d-md-none">Portal</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.categories') ? 'active' : '' }}" href="{{ route('student.categories') }}">Categories</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.assessments.analytics') ? 'active' : '' }}" href="{{ route('student.assessments.analytics') }}">Analytics</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.assessment.history') ? 'active' : '' }}" href="{{ route('student.assessment.history') }}">History</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDd" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="d-md-none"><i class="fas fa-user"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDd">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start"><i class="fas fa-sign-out-alt me-2"></i>Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Ensure Bootstrap dropdown works properly on mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap dropdowns
        const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdowns.forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });
        
        // Handle mobile menu collapse
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', function() {
                navbarCollapse.classList.toggle('show');
            });
        }
        
        // Close menu when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideNav = navbarCollapse && navbarCollapse.contains(event.target);
            const isTogglerClick = navbarToggler && navbarToggler.contains(event.target);
            
            if (!isClickInsideNav && !isTogglerClick && navbarCollapse && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
</script>
