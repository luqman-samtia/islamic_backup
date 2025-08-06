<meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- for toast --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<header class="style1">
    <div class="container">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}"><img src="{{ asset('assets/images/logo1.png') }}" alt=""></a>
        </div>
        <nav>
            <div>
                @if(Auth::check() )
                <div class="dropdown" style="display: inline-block;">
                    <a 
                        {{-- src="{{ asset('storage/images/students/'.Auth::user()->image) }}"  --}}
                        {{-- alt="Profile Icon"  --}}
                        class="btn btn-secondary"
                        type="button"
                        style="background:#d1ad3c;color:#fff;border:none;border-radius:50px;margin-top:8px;margin-left:20px;" 
                        id="profileImage"
                        data-toggle="dropdown"
                        aria-haspopup="true" 
                        aria-expanded="false"
                    >{{Auth::user()->name}}</a>
                    <div class="dropdown-menu" aria-labelledby="profileImage">
                        <a class="dropdown-item" href="{{url('admin/home')}}">Dashboard</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="logoutButton">Logout</a>
                       
                    </div>
                
                </div>
         
            @else
                {{-- <a class="btn btn-danger" href="javascript:void(0);" onclick="openModal()" title="" style="background:#d1ad3c;color:white;border:none;border-radius:50px;margin-left:5px;margin-top:8px; cursor:pointer;">Login</a> --}}
                <div class="dropdown" style="display: inline-block;">
        
           <a class="btn btn-danger dropdown-toggle"
            href="javascript:void(0);"
            style="background:#d1ad3c;color:white;border:none;border-radius:50px;margin-left:5px;margin-top:8px; cursor:pointer;"
            id="loginDropdown"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >Login</a>
        <div class="dropdown-menu" aria-labelledby="loginDropdown">
            <a class="dropdown-item" href="javascript:void(0);" onclick="openModal()">Student</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="openModal()">Scholar</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="openModal()">Admin</a>
        </div>
    </div>
            @endif
                
            
            <ul>
                    <a class="btn btn-info" href="{{ route('contactUs') }}" title="" style="background:#d1ad3c;border:none;border-radius:50px;margin-top:8px;margin-left:20px;">Contact Us</a>
                    <li><a href="{{ route('site') }}" title="">Home</a></li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Islamic Resources</a>
                        <ul>
                            @foreach($resources as $resource)
                            <li><a href="{{ route('page', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
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
{{--                    <li><a href="{{ route('charges') }}" title="">Charges</a></li>--}}

                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Modal -->
<div id="authModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <!-- Login Form -->
        <div id="loginForm">
            <h3>Login</h3>
            <form id="loginData" action="{{ route('student.login') }}" method="POST">
                @csrf
                <label for="email">Email</label>
                <input class="form-control" id="email" type="email" name="email" placeholder="Email"  style="margin-bottom: 10px;">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                 <label for="password">Password</label>
                <input class="form-control" id="password"  type="password" name="password" placeholder="Password"  style="margin-bottom: 10px;">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                <button class="btn btn-info" type="submit" style="margin-bottom: 10px;background:#d1ad3c;color:white;border:none;border-radius:50px;">Login </button>
            </form>
            <p>Don't have an account? <button onclick="showSignup()" class="" style="">Sign Up</button></p>
            <p><a href="javascript:void(0);" onclick="showForgotPassword()">Forgot Password?</a></p>

        </div>
             
        <!-- Signup Form (Initially Hidden) -->
        <div id="signupForm" style="display:none;">
            <span style="float: inline-end;color: #7D6825; font-weight:500;">Free Trail For 3 Days ✨</span>
            <h3>Student Sign Up</h3>
            <form id="registerForm" action="{{ route('student.register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="name">Name</label>
                <input class="form-control" id="name" type="text" name="name" placeholder="Full Name"  style="margin-bottom: 10px;">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                <label for="email">Email</label>
                <input class="form-control" id="email" type="email" name="email" placeholder="Email"  style="margin-bottom: 10px;">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                {{-- <label for="contact">Contact</label>
                <input class="form-control" id="contact" type="number" name="contact_no" placeholder="Contact Number"  style="margin-bottom: 10px;">
                 --}}
                 <label for="contact">Contact</label>
                <div class="input-group" style="margin-bottom: 10px;">
                    <div class="input-group-prepend">
                        <select name="country_code" class="form-control" style="max-width: 90px;">
                            <option value="92" selected>+92 🇵🇰</option>
                            <option value="91">+91 🇮🇳</option>
                            <option value="44">+44 🇬🇧</option>
                            <option value="1">+1 🇺🇸</option>
                            <option value="971">+971 🇦🇪</option>
                            <option value="966">+966 🇸🇦</option>
                            <option value="880">+880 🇧🇩</option>
                            <option value="93">+93 🇦🇫</option>
                            <option value="20">+20 🇪🇬</option>
                            <option value="234">+234 🇳🇬</option>
                            <option value="81">+81 🇯🇵</option>
                            <option value="49">+49 🇩🇪</option>
                            <option value="33">+33 🇫🇷</option>
                            <option value="39">+39 🇮🇹</option>
                            <option value="86">+86 🇨🇳</option>
                            <option value="7">+7 🇷🇺</option>
                            <option value="55">+55 🇧🇷</option>
                            <option value="34">+34 🇪🇸</option>
                            <option value="62">+62 🇮🇩</option>
                            <option value="27">+27 🇿🇦</option>
                            <option value="82">+82 🇰🇷</option>
                            <option value="60">+60 🇲🇾</option>
                            <option value="63">+63 🇵🇭</option>
                            <option value="94">+94 🇱🇰</option>
                            <option value="856">+856 🇱🇦</option>
                            <option value="95">+95 🇲🇲</option>
                            <option value="961">+961 🇱🇧</option>
                            <option value="962">+962 🇯🇴</option>
                            <option value="964">+964 🇮🇶</option>
                            <option value="98">+98 🇮🇷</option>
                            <option value="965">+965 🇰🇼</option>
                            <option value="968">+968 🇴🇲</option>
                            <option value="974">+974 🇶🇦</option>
                            <option value="963">+963 🇸🇾</option>
                            <option value="90">+90 🇹🇷</option>
                            <option value="84">+84 🇻🇳</option>
                            <option value="855">+855 🇰🇭</option>
                            <option value="976">+976 🇲🇳</option>
                            <option value="960">+960 🇲🇻</option>
                            <option value="66">+66 🇹🇭</option>
                            <option value="961">+961 🇱🇧</option>
                            <option value="598">+598 🇺🇾</option>
                            <option value="591">+591 🇧🇴</option>
                            <option value="94">+94 🇱🇰</option>
                            <option value="250">+250 🇷🇼</option>
                            <option value="211">+211 🇸🇸</option>
                            <option value="56">+56 🇨🇱</option>
                            <option value="213">+213 🇩🇿</option>
                            <option value="216">+216 🇹🇳</option>
                            <option value="351">+351 🇵🇹</option>
                            <option value="47">+47 🇳🇴</option>
                            <option value="46">+46 🇸🇪</option>
                            <option value="48">+48 🇵🇱</option>
                        </select>
                    </div>
                    <input type="number" min="0" class="form-control" name="contact_raw" placeholder="3476834169">
                </div>
                @error('contact_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('contact_no')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                 <label for="password">Password</label>
                <input class="form-control" id="password" type="password" name="password" placeholder="Password"  style="margin-bottom: 10px;">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                 <label for="cPassword">Confirm Password</label>
                <input class="form-control" id="cPassword" type="password" name="password_confirmation" placeholder="Confirm Password"  style="margin-bottom: 10px;">
                @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                 {{-- <label for="image">Image</label>
                <input class="form-control" id="image" type="file" name="image" placeholder="Select File" accept="image/*"  style="margin-bottom: 10px;" >
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                 @enderror --}}
                <button class="btn btn-info" type="submit" style="margin-bottom: 10px;background:#d1ad3c;color:white;border:none;border-radius:50px;">Sign Up</button>
            </form>
            <p>Already have an account? <button onclick="showLogin()" class="" style="">Login</button></p>
        </div>
        {{-- Forgot Password --}}
        <div id="forgotPasswordForm" style="display:none;">
          <h3>Forgot Password</h3>
            <form id="forgotForm" method="POST" action="{{ route('student.forgotPassword') }}">
                @csrf
                <label for="forgot_email">Email</label>
                <input class="form-control" id="forgot_email" type="email" name="email" placeholder="Enter your register email" style="margin-bottom: 10px;">
                <button class="btn btn-info" type="submit" style="background:#d1ad3c;color:white;border:none;border-radius:50px;">Send Reset Link</button>
            </form>
            <p><a href="javascript:void(0);" onclick="showLogin()">Back to Login</a></p>
        </div>

        {{-- Reset Forgotform --}}
        <div id="resetPasswordForm" style="display:none;">
    <h3>Reset Your Password</h3>
    <form id="resetForm" method="POST" action="{{ route('password.reset.submit') }}">
        @csrf
        <input type="hidden" name="token" id="resetToken">
        <input type="hidden" name="email" id="resetEmail">

        <label for="new_password">New Password</label>
        <input class="form-control" type="password" name="password" placeholder="New password" style="margin-bottom: 10px;">
        <label for="confirm_password">Confirm Password</label>
        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" style="margin-bottom: 10px;">
        
        <button class="btn btn-info" type="submit" style="background:#d1ad3c;color:white;border:none;border-radius:50px;">Reset Password</button>
    </form>
</div>

    </div>
</div>


@section('custom_js')

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

    // Forgot Password 
$('#forgotForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('student.forgotPassword') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
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
                title: 'Success',
                text: response.message
            }).then(() => {
                showLogin();
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let message = '';
                $.each(errors, function (key, errorMessages) {
                    errorMessages.forEach(function (msg) {
                        message += msg + '\n';
                    });
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: message,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        }
    });
});


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
            // Show loading SweetAlert
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
            // SweetAlert for success
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
            }).then(function() {
                document.getElementById('signupForm').style.display = "none";
                // location.reload();
                document.getElementById('loginForm').style.display = "block";
                
            });

        },
        error: function(xhr) {
            if (xhr.status === 422) { // Laravel validation error status code
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                // Collect all error messages into a single string
                $.each(errors, function (key, errorMessages) {
                    errorMessages.forEach(function (errorMessageItem) {
                        errorMessage += errorMessageItem + '\n';
                    });
                });

                // SweetAlert for validation errors
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessage,
                });
            } else {
                // SweetAlert for general error
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
    e.preventDefault(); // Prevent default form submission
    
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: "{{ route('student.login') }}", // Ensure this is the correct route for login
        method: "POST",
        data: $(this).serialize(),
        success: function(response) {
            // SweetAlert for successful login
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: response.message,
            }).then(function() {
                location.reload(); // Reload or redirect the page on successful login
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Laravel validation error
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                // Collect all error messages into a single string
                $.each(errors, function (key, errorMessages) {
                    errorMessages.forEach(function (errorMessageItem) {
                        errorMessage += errorMessageItem + '\n';
                    });
                });

                // SweetAlert for validation errors
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessage,
                });
            } else if (xhr.status === 404) { // Account not verified
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error,
                });
            } else if (xhr.status === 403) { // Account not verified
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error,
                });
            }else if (xhr.status === 401) { // Account not verified
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error,
                });
            }else { // Other errors
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid credentials.',
                });
            }
        }
    });
});

    // Reset Password 
    $('#resetForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('password.reset.submit') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),
        beforeSend: function() {
            Swal.fire({
                title: 'Processing...',
                text: 'Updating your password...',
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
                text: response.message
            }).then(() => {
                showLogin();
            });
        },
        error: function(xhr) {
            let msg = 'Something went wrong.';
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                msg = Object.values(errors).flat().join('\n');
            } else if (xhr.responseJSON?.error) {
                msg = xhr.responseJSON.error;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg
            });
        }
    });
});


        // Logout ajax
        $('#logoutButton').on('click', function(e) {
    e.preventDefault();

            $.ajax({
                url: '{{ route("student.logout") }}',  // Change this to your actual route name
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'  // CSRF token for security
                },
                success: function(response) {
                    // On success, redirect the user to the desired route (e.g., the site homepage)    
                    if (response.success) {
                // Redirect to the site route after logout
                window.location.href = response.redirect;
                  }
                },
                error: function(xhr) {
                    // Handle any errors
                    console.log(xhr.responseText);
                }
            });
        });



    function openModal() {
            document.getElementById('authModal').style.display = "block";
            showLogin(); // Default to showing login form when modal is opened
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
       function showResetForm(token, email) {
            document.getElementById('loginForm').style.display = "none";
            document.getElementById('signupForm').style.display = "none";
            document.getElementById('forgotPasswordForm').style.display = "none";
            document.getElementById('resetPasswordForm').style.display = "block";

            document.getElementById('resetToken').value = token;
            document.getElementById('resetEmail').value = email;
        }

  // Auto-show reset form if URL contains reset token
           document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const pathSegments = window.location.pathname.split('/');
            const token = pathSegments[pathSegments.length - 1]; // Get last segment
            const email = urlParams.get('email');

            if (window.location.pathname.includes('/reset-password/') && token && email) {
                openModal();
                showResetForm(token, email);
            }
        });

        // Close the modal if the user clicks outside the modal content
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

        @if(session('showLogin'))
        document.addEventListener('DOMContentLoaded', function() {
            // console.log('Attempting to show login popup');
            openModal();
            showLogin();
        });
        @endif



</script>


@stop