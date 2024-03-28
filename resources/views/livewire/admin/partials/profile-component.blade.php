<div>
    <div wire:ignore.self class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="modelTitleId">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: white;">
                    <h5 class="modal-title m-0" id="mySmallModalLabel">Admin Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <form wire:submit.prevent='updateProfile' enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control mb-2" type="text" wire:model="name" placeholder="Enter name">
                                        @error('name')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                            <br>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input class="form-control mb-2" type="text" wire:model="email" placeholder="Enter email">
                                        @error('email')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                            <br>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input class="form-control mb-2" type="text" wire:model="phone" placeholder="Enter phone">
                                        @error('phone')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                            <br>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input class="form-control mb-2" type="text" wire:model="password" placeholder="Enter new password" wire:model='password'>
                                        @error('password')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                            <br>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-sm-3 col-form-label">Avatar</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" wire:model='avatar' />
                                        @error('avatar')
                                            <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                        @enderror

                                        <div wire:loading wire:target='avatar' wire:key='avatar'>
                                            <span class="spinner-border spinner-border-xs" role="status" aria-hidden="true"></span> <small>Uploading</small>
                                        </div>
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" class="img-fluid mt-2" style="height: 55px; width: 55px;"/>
                                        @elseif ($uploadedAvatar)
                                            <img src="{{ asset($uploadedAvatar) }}" class="img-fluid mt-2" style="height: 55px; width: 55px;"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row mt-4">
                                    <label for="" class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            {!! loadingStateWithText('updateProfile', 'Update Profile') !!}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#editProfileModal').modal('hide');
        });
    </script>
@endpush
