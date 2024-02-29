<div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"> Change Password</h5>
                                        <p>Update your Password</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('assets/admin/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('assets/images/logo-sm2.png') }}" alt="" class="" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="p-2">
                                @if (session()->has('success'))
                                    <div class="alert alert-success text-center mb-4" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session()->has('error'))
                                    <div class="alert alert-danger text-center mb-4" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form class="form-horizontal" wire:submit.prevent='updatePassword' action="">
                                    <div class="mb-3">
                                        <label for="userNewPass" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="userNewPass" wire:model='password' placeholder="Enter password">

                                        @error('password')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="userConfPass" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="userConfPass" wire:model='confirm_password' placeholder="Re-enter password">

                                        @error('confirm_password')
                                            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Change Password</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Remember Old Password ? <a href="{{ route('admin.login') }}" class="fw-medium text-primary"> Sign In here</a> </p>
                        <p>© <script>document.write(new Date().getFullYear())</script> NzCoding</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
