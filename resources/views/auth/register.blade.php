@extends('layout.master2')

@section('content')
    <div class="page-content d-flex align-items-center justify-content-center">

        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pr-md-0">
                            <div class="auth-left-wrapper">
                                 {{--style="background-image: url({{ url('https://via.placeholder.com/219x452') }})">--}}
                                <img src="{{asset('assets/images/login.jpg')}}" width="240px" height="780px">

                            </div>
                        </div>
                        <div class="col-md-8 pl-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <img src="{{asset('assets/images/logo.png')}}" width="70px" height="60px">
                                <br>
                                <h5 class="text-muted font-weight-normal mb-4">Create a Region account.</h5>
                                <form class="forms-sample" method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name" value="{{ old('name') }}" required autocomplete="name"
                                               autofocus placeholder="Full Name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Mobile Number</label>
                                        <input type="text"
                                               class="form-control @error('mobilenumber') is-invalid @enderror"
                                               name="mobilenumber" value="{{ old('mobilenumber') }}" required
                                               autocomplete="mobilenumber"
                                               autofocus placeholder="Mobile Number">
                                        @error('mobilenumber')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                               name="address" value="{{ old('address') }}" required
                                               autocomplete="address"
                                               autofocus placeholder="Address">
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">User Type</label>
                                        <select id="usertype" name="usertype" class="form-control">
                                            <option value="3">Region - 01</option>
                                            <option value="4">Region - 02</option>
                                            <option value="5">Region - 03</option>
                                            <option value="6">Region - 04</option>
                                            <option value="7">Region - 05</option>
                                            <option value="8">Region - 06</option>
                                            <option value="9">Region - 07</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email"
                                               placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password"
                                               placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0">Sing up</button>
                                    </div>
                                    <a href="{{ url('/login') }}" class="d-block mt-3 text-muted">Already a user? Sign
                                        in</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function displaySelectedImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                if (input.files[0].type == 'image/jpg' || input.files[0].type == 'image/jpeg' || input.files[0].type == 'image/png') {
                    $('#output1').attr('src', e.target.result);
                    image1 = input.files[0];
                    $('#imgspan1').addClass('d-none');
                } else {
                    $('#output1').attr('src', action + "img/placeholder.jpg");
                    $('#imgspan1').removeClass('d-none');

                }
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
