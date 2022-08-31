@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">User Details Registration</h6>
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group wd-xs-300">
                                        <div class="form-group wd-xs-300">
                                            <img id="output1" src="{{URL::asset('/assets/images/placeholder.jpg')}}"
                                                 style="width: 70%;height: auto; display:block;margin:auto;">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*"
                                                   id="myimage1"
                                                   style="width: 100%"
                                                   name="myimage1" onchange="displaySelectedImage(this)" required>
                                            <label class="custom-file-label" for="inputGroupFile01">Select User Image</label>
                                        </div>
                                        <div id="imgspan1" class="abc d-none">
                                            <p style="color:red;">Select & Valid User Image </p>
                                        </div><!-- form-group -->
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Full Name</label>
                                    <input id="fullnametxt" type="text" class="form-control"
                                           placeholder="Enter Full Name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">User Type</label>
                                    <select id="usertypetxt" class="form-control">
                                        <option value="1">Admin</option>
                                        <option value="2">User</option>
                                    </select>
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <textarea id="addresstxt" class="form-control"
                                              placeholder="Enter Address"></textarea>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Mobile Number</label>
                                    <input id="mobiletxt" type="text" class="form-control"
                                           placeholder="Enter Mobile Number">
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <input id="emailtxt" type="email" class="form-control"
                                           placeholder="Enter Email Address">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input id="passwordtxt" type="password" class="form-control">

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input id="confirmpasswordtxt" type="password" class="form-control">
                                </div>
                            </div><!-- Col -->

                        </div>

                    </form>
                    <button type="button" id="submitbtn" onclick="onclickSubmit()" class="btn btn-success">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">View User Details</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Mobile Number</th>
                                <th>Address</th>
                                <th>User Type</th>
                                <th class="text-xl-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $userdata)
                                @if(Auth::user()->usertype==1 && $userdata->id!=Auth::id())
                                <tr>
                                    <td>{{$userdata->name}}</td>
                                    <td>{{$userdata->email}}</td>
                                    <td>{{$userdata->mobilenumber}}</td>
                                    <td>{{$userdata->address}}</td>
                                    @if($userdata->usertype==1)
                                        <td>Admin</td>
                                    @elseif($userdata->usertype==2)
                                        <td>User</td>
                                    @elseif($userdata->usertype==3)
                                        <td>Region</td>

                                    @endif
                                    <td class="text-xl-center">
                                        <div class="user-btn-wrapper">
                                            <button type="button" class="btn btn-secondary btn-secondary"
                                                    onclick="loadEditModalView({{$userdata->id}})">Edit
                                            </button>
                                            <button type="button" onclick="onClickDelete({{$userdata->id}})"
                                                    class="btn btn-danger btn-danger">Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @elseif(Auth::user()->usertype==2 && $userdata->id!=Auth::id())
                                    @if($userdata->usertype!=1  )
                                        <tr>
                                            <td>{{$userdata->name}}</td>
                                            <td>{{$userdata->email}}</td>
                                            <td>{{$userdata->mobilenumber}}</td>
                                            <td>{{$userdata->address}}</td>
                                            @if($userdata->usertype==1)
                                                <td>Admin</td>
                                            @elseif($userdata->usertype==2)
                                                <td>User</td>
                                            @endif
                                            <td class="text-xl-center">
                                                <div class="user-btn-wrapper">
                                                    <button type="button" class="btn btn-secondary btn-secondary"
                                                            onclick="loadEditModalView({{$userdata->id}})">Edit
                                                    </button>
                                                    <button type="button" onclick="onClickDelete({{$userdata->id}})"
                                                            class="btn btn-danger btn-danger">Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <div id="editmodalload" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="color: white" aria-label="Close">
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
                                                                <img id="output2" src="{{URL::asset('/assets/images/placeholder.jpg')}}"
                                                                     style="width: 70%;height: auto; display:block;margin:auto;">
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" accept="image/*"
                                                                       id="myimage2"
                                                                       style="width: 100%"
                                                                       name="myimage2" onchange="displaySelectedImage1(this)" required>
                                                                <label class="custom-file-label" for="inputGroupFile01">Select User Image</label>
                                                            </div>
                                                            <div id="imgspan2" class="abc d-none">
                                                                <p style="color:red;">Select & Valid User Image </p>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Full Name</label>
                                                        <input id="modalfullnametxt" type="text" class="form-control"
                                                               placeholder="Enter Full Name">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Address</label>
                                                        <textarea id="modaladdresstxt" class="form-control"
                                                                  placeholder="Enter Address"></textarea>
                                                    </div>
                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Mobile Number</label>
                                                        <input id="modalidtxt" type="text" class="form-control d-none">
                                                        <input id="modalmobiletxt" type="text" class="form-control"
                                                               placeholder="Enter Mobile Number">
                                                    </div>
                                                </div><!-- Col -->

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Email Address</label>
                                                        <input id="modalemailtxt" type="email" class="form-control" disabled
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
                                        <button type="button" onclick="onClickSaveChanges()" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
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
         * Update User
         */

        function onClickSaveChanges(){
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

            if ($('#modalpasswordtxt').val() == $('#modalconfirmpasswordtxt').val() && !($('#modalpasswordtxt').val()=='' | $('#modalpasswordtxt').val()==null)) {
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
                                title: 'Success notice', text: 'User Updated Successfully !', type: 'success'
                            });
                            setInterval(function () {
                                window.location = action + 'user-management';
                            }, 3000);

                        } else {
                            new PNotify({
                                title: 'Danger notice', text: 'User Updated Fail !', type: 'error'
                            });
                        }

                    },
                    error: function (error) {
                        new PNotify({
                            title: 'Danger notice', text: 'User Updated Fail !', type: 'error'
                        });
                    }
                });
            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Enter Password does not Match!', type: 'error'
                });
            }
        }

        let image2;

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

        function loadEditModalView(id){
            $.ajax({
                url: action + "api/user/single/" + id,
                method: 'GET',
                processData: false,
                contentType: false,
                async: true,
                success: function (result) {
                    for (let i in result) {
                        let respose = result[i];
                        let id = respose['id'];
                        let name = respose['name'];
                        let address = respose['address'];
                        let email = respose['email'];
                        let mobilenumber = respose['mobilenumber'];
                        let file_path = respose['file_path'];
                        $('#modalfullnametxt').val(name);
                        $('#modaladdresstxt').val(address);
                        $('#modalemailtxt').val(email);
                        $('#modalmobiletxt').val(mobilenumber);
                        $('#modalidtxt').val(id);
                        image2=file_path;
                        $('#output2').attr('src', action + "image/"+file_path);
                    }
                    $('#editmodalload').modal({show: true});
                },
                error: function (error) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Cell Log is safe :)',
                        'error'
                    )
                }
            });
        }

        function onClickDelete(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'ml-2',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: action + "api/user/delete/" + id,
                        method: 'GET',
                        processData: false,
                        contentType: false,
                        async: true,
                        success: function (result) {
                            if (result.code == 200) {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                                setInterval(function () {
                                    window.location = action + 'user-management';
                                }, 3000);
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    'Your imaginary User is safe :)',
                                    'error'
                                )
                            }

                        },
                        error: function (error) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Your User is safe :)',
                                'error'
                            )
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your User is safe :)',
                        'error'
                    )
                }
            })
        }

        let image1;


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

        /**
         * Function For add User
         */

        function onclickSubmit() {
            let form_data = new FormData();
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("fullname", $('#fullnametxt').val());
            form_data.append("email", $('#emailtxt').val());
            form_data.append("mobilenumber", $('#mobiletxt').val());
            form_data.append("address", $('#addresstxt').val());
            form_data.append("password", $('#passwordtxt').val());
            form_data.append("usertype", $('#usertypetxt').val());
            form_data.append("image1", image1);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if ($('#passwordtxt').val() == $('#confirmpasswordtxt').val() && !($('#passwordtxt').val()=='' | $('#passwordtxt').val()==null) ) {
                $.ajax({
                    url: action + "api/user/email/" + $('#emailtxt').val(),
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (result) {
                        if(result.code==200) {
                            $.ajax({
                                url: action + "api/user/add",
                                method: 'post',
                                data: form_data,
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                async: true,
                                success: function (result) {
                                    if (result.code == 200) {
                                        new PNotify({
                                            title: 'Success notice', text: 'User Added Successfully !', type: 'success'
                                        });
                                        setInterval(function () {
                                            window.location = action + 'user-management';
                                        }, 3000);

                                    } else {
                                        new PNotify({
                                            title: 'Danger notice', text: 'User Added Fail !', type: 'error'
                                        });
                                    }

                                },
                                error: function (error) {
                                    new PNotify({
                                        title: 'Danger notice', text: 'User Added Fail !', type: 'error'
                                    });
                                }
                            });
                        }else if(result.code==500){
                            new PNotify({
                                title: 'Danger notice', text: 'Your enter Email existed!', type: 'error'
                            });
                        }
                    },
                    error: function (error) {
                        new PNotify({
                            title: 'Danger notice', text: 'Some thing went wrong!', type: 'error'
                        });
                    }
                });

            } else {
                new PNotify({
                    title: 'Danger notice', text: 'Enter Password does not Match!', type: 'error'
                });
            }
        }

    </script>
@endpush
