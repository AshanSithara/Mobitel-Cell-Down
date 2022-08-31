@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="profile-page tx-13">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="profile-header">
                    <div class="cover">
                        <div class="gray-shade"></div>
                        <figure>
                            <img src="{{ asset("assets/images/background.jpg") }}"
                                 style="height: 300px" class="img-fluid" alt="profile cover">
                        </figure>
                        <div class="cover-body d-flex justify-content-between align-items-center">
                            <div>
                                <img class="profile-pic" src="{{asset("image/".Auth::user()->file_path)}}"
                                     alt="profile">
                                <span class="profile-name">{{Auth::user()->name}}</span>
                            </div>
                            <div class="d-none d-md-block">
                                <button class="btn btn-primary btn-icon-text btn-edit-profile" type="button"
                                        onclick="editProfile()">
                                    <i data-feather="edit" class="btn-icon-prepend"></i> Edit profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-12 col-xl-12 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0">About</h6>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Joined:</label>
                            <p class="text-muted">{{Auth::user()->created_at}}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Address:</label>
                            <p class="text-muted">{{Auth::user()->address}}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                            <p class="text-muted">{{Auth::user()->email}}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobile Number:</label>
                            <p class="text-muted">{{Auth::user()->mobilenumber}}</p>
                        </div>

                    </div>
                </div>
            </div>
            <div id="editmodalload" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                 aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Profile Details</h5>
                            <button type="button" class="close" data-dismiss="modal" style="color: white"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group wd-xs-300">
                                                <div class="form-group wd-xs-300">
                                                    <img id="output2" src="{{asset("image/".Auth::user()->file_path)}}"
                                                         style="width: 70%;height: auto; display:block;margin:auto;">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" accept="image/*"
                                                           id="myimage2"
                                                           style="width: 100%"
                                                           name="myimage2" onchange="displaySelectedImage1(this)"
                                                           required>
                                                    <label class="custom-file-label" for="inputGroupFile01">Select User
                                                        Image</label>
                                                </div>
                                                <div id="imgspan2" class="abc d-none">
                                                    <p style="color:red;">Select & Valid User Image </p>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Full Name</label>
                                            <input id="modalfullnametxt" type="text" class="form-control"
                                                   value="{{Auth::user()->name}}"
                                                   placeholder="Enter Full Name">
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <textarea id="modaladdresstxt" class="form-control"
                                                      placeholder="Enter Address">{{Auth::user()->address}}</textarea>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <div class="row">

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label>
                                            <input id="modalidtxt" type="text" class="form-control d-none"
                                                   value="{{Auth::user()->id}}">
                                            <input id="modalmobiletxt" type="text" class="form-control"
                                                   value="{{Auth::user()->mobilenumber}}"
                                                   placeholder="Enter Mobile Number">
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Email Address</label>
                                            <input id="modalemailtxt" type="email" class="form-control" disabled
                                                   value="{{Auth::user()->email}}"
                                                   placeholder="Enter Email Address">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input id="modalpasswordtxt" type="password" class="form-control">

                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Confirm Password</label>
                                            <input id="modalconfirmpasswordtxt" type="password" class="form-control">
                                        </div>
                                    </div><!-- Col -->

                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="onClickSaveChanges()" class="btn btn-primary">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
    <!-- Pnotify js -->
    <script src="{{asset('assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dragula.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
    <script>

        /**
         * Update Profile
         */

        function onClickSaveChanges() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("fullname", $('#modalfullnametxt').val());
            form_data.append("email", $('#modalemailtxt').val());
            form_data.append("mobilenumber", $('#modalmobiletxt').val());
            form_data.append("address", $('#modaladdresstxt').val());
            form_data.append("password", $('#modalpasswordtxt').val());
            form_data.append("id", $('#modalidtxt').val());
            form_data.append("image1", image2);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if ($('#modalpasswordtxt').val() == $('#modalconfirmpasswordtxt').val() && !($('#modalpasswordtxt').val() == '' | $('#modalpasswordtxt').val() == null)) {
                $.ajax({
                    url: action + "api/user/update",
                    method: 'post',
                    data: form_data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (result) {
                        if (result.code == 200) {
                            new PNotify({
                                title: 'Success notice', text: 'Profile Updated Successfully !', type: 'success'
                            });
                            setInterval(function () {
                                window.location = action + 'profile';
                            }, 3000);

                        } else {
                            new PNotify({
                                title: 'Danger notice', text: 'Profile Updated Fail !', type: 'error'
                            });
                        }

                    },
                    error: function (error) {
                        new PNotify({
                            title: 'Danger notice', text: 'Profile Updated Fail !', type: 'error'
                        });
                    }
                });
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Enter Password does not Match!', type: 'error'
                });
            }
        }

        let image2 = '{{Auth::user()->file_path}}';

        function displaySelectedImage1(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    if (input.files[0].type == 'image/jpg' || input.files[0].type == 'image/jpeg' || input.files[0].type == 'image/png') {
                        $('#output2').attr('src', e.target.result);
                        image2 = input.files[0];
                        $('#imgspan2').addClass('d-none');
                    } else {
                        $('#output2').attr('src', action + "img/placeholder.jpg");
                        $('#imgspan2').removeClass('d-none');

                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function editProfile() {
            $('#editmodalload').modal({show: true});
        }

    </script>
@endpush

