<div class="rspn-hdr">
    <div class="lg-mn">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}">
                <img src="{{ asset('assets/images/logo1.png') }}">
            </a>
        </div>
        <div class="rspn-cnt">
            @php($info = \App\Information::query()->first())
            <span>
                <i class="fa fa-envelope thm-clr"></i>
                     @if(@$info['email']['label'] && @$info['email']['value'])
                     <a href="mailto:{{$info['email']['value']}}"><span>{{ $info['email']['value']  }}</span></a>
                    @endif
            </span>
            
            @if(@$info['whatsapp2']['label'] && @$info['whatsapp2']['value'])      
           
            <span><i class="fa fa-phone thm-clr"></i>+{{$info['whatsapp2']['value']}}</span>
            @endif
        </div>
        <span class="rspn-mnu-btn"><i class="fa fa-list-ul"></i></span>
    </div>
    <div class="rsnp-mnu">
        <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>

        @if(Auth::check() )
        <div class="dropdown" style="display: inline-block;">
            <a 
                class="btn btn-secondary"
                type="button"
                style="background:#d1ad3c;color:#fff;border:none;border-radius:50px;margin-top:8px;margin-left:20px;" 
                id="profileImage"
                data-toggle="dropdown"
                aria-haspopup="true" 
                aria-expanded="false"
            >
            {{Auth::user()->name}}
           
                </a>
            <div class="dropdown-menu" aria-labelledby="profileImage">
                <a class="dropdown-item" href="{{url('admin/home')}}">Dashboard</a>
                <a class="dropdown-item" href="javascript:void(0);" id="logoutButton_mobile">Logout</a>
               
            </div>
        
        </div>
 
    @else
        {{-- <div class="dropdown" style="display: inline-block;">
            <a class="btn btn-danger dropdown-toggle"
                href="javascript:void(0);"
                style="background:#d1ad3c;color:white;border:none;border-radius:50px;margin-left:5px;margin-top:8px; cursor:pointer;"
                id="loginDropdown"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Login</a>
            <div class="dropdown-menu" aria-labelledby="loginDropdown">
                <a class="dropdown-item" href="javascript:void(0);" onclick="openModal('student')">Student</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="openModal('scholar')">Scholar</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="openModal('admin')">Admin</a>
            </div>
        </div> --}}
        <a class="btn btn-danger" href="javascript:void(0);" onclick="openModal('student')" style="background:#d1ad3c;color:white;border:none;border-radius:50px;margin-left:5px;margin-top:8px; cursor:pointer;">
                Login
        </a>
    @endif
        <ul>
            <li><a href="{{ route('site') }}" title="">Home</a></li>
            <li class="menu-item-has-children">
                <a href="#" title="">Islamic Resources</a>
                <ul>
                    @foreach($resources as $resource)
                        <li><a href="{{ route('page', $resource->slug) }}?page=1" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a href="#" title="">Articles</a>
                <ul>
                    @foreach($articles as $resource)
                        <li><a href="{{ route('artical', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a href="#" title="">Read Quran</a>
                <ul>
                    <li><a href="{{ route('quranPage') }}" title="">Tajweed Quran 15</a></li>
                    <li><a href="{{ route('tajweedQuran') }}" title="">Tajweed Quran 16</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a href="#" title="">Islamic Lecture</a>
                <ul>
                    @foreach($media as $islamic)
                        <li><a href="{{ route('islamicmedia', $islamic->slug) }}" title="{{ $islamic->title }}">{{ $islamic->title }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li><a href="{{ route('contactUs') }}" title="">Contact Us</a></li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
        const currentUser = '{{ Auth::user()->name ?? "guest" }}';

       // Logout handler
    document.getElementById('logoutButton_mobile')?.addEventListener('click', function(e) {
        e.preventDefault();
        
        fetch('{{ route("student.logout") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('User ' + currentUser + ' logged out at:', new Date().toISOString());
                window.location.href = data.redirect;
            }
        })
        .catch(error => console.error('Logout Error:', error));
    });
});
</script>
@section('custom_js')
<script>
    // logoutButton


</script>
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
@endif

 <script>

// Register ajax
$('#registerForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('student.register') }}",
        method: "POST",
        data: formData, 
        processData: false, 
        contentType: false, 
        beforeSend: function() {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we register your account.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
            }).then(function() {
                document.getElementById('signupForm').style.display = "none";
                document.getElementById('loginForm').style.display = "block";
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) { 
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                $.each(errors, function (key, errorMessages) {
                    errorMessages.forEach(function (errorMessageItem) {
                        errorMessage += errorMessageItem + '\n';
                    });
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessage,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            }
        }
    });
});


// Login ajax
$('#loginData').on('submit', function(e) {
    e.preventDefault();
    
    var loginType = document.getElementById('loginType').value;
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('student.login') }}", 
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function() {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait...',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: response.message,
            }).then(function() {
                location.reload();
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) { 
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                $.each(errors, function (key, errorMessages) {
                    errorMessages.forEach(function (errorMessageItem) {
                        errorMessage += errorMessageItem + '\n';
                    });
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessage,
                });
            } else if (xhr.status === 404) { 
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error,
                });
            } else if (xhr.status === 403) {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: xhr.responseJSON.error || 'You do not have permission to login as ' + loginType,
                });
            } else if (xhr.status === 401) { 
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error,
                });
            } else { 
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid credentials.',
                });
            }
        }
    });
});




function openModal(userType = 'student') {
    document.getElementById('authModal').style.display = "block";
    updateLoginForm(userType);
    showLogin();
}

function updateLoginForm(userType) {
    const typeMap = {
        'student': 'Student',
        'scholar': 'Scholar',
        'admin': 'Admin'
    };

    document.getElementById('loginType').value = userType;
    document.getElementById('registerType').value = userType;
    document.getElementById('forgotType').value = userType;
    document.getElementById('loginTitle').textContent = typeMap[userType] + ' Login';

    const loginForm = document.getElementById('loginData');
    loginForm.action = "{{ route('student.login') }}";
}

function closeModal() {
    document.getElementById('authModal').style.display = "none";
}

function showSignup() {
    document.getElementById('loginForm').style.display = "none";
    document.getElementById('signupForm').style.display = "block";
    document.getElementById('forgotPasswordForm').style.display = "none";
    document.getElementById('resetPasswordForm').style.display = "none";
}

function showLogin() {
    document.getElementById('signupForm').style.display = "none";
    document.getElementById('loginForm').style.display = "block";
    document.getElementById('forgotPasswordForm').style.display = "none";
    document.getElementById('resetPasswordForm').style.display = "none";
}

function showForgotPassword() {
    document.getElementById('loginForm').style.display = "none";
    document.getElementById('signupForm').style.display = "none";
    document.getElementById('resetPasswordForm').style.display = "none";
    document.getElementById('forgotPasswordForm').style.display = "block";
}

window.onclick = function(event) {
    var modal = document.getElementById('authModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

@if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");
@endif

@if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
@endif

</script>

@stop