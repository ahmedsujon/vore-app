<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Customers</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customers</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-white" style="border-bottom: 1px solid #e2e2e7;">
                            <h4 class="card-title" style="float: left;">All Customers</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12 mb-2 sort_cont">
                                    <label class="font-weight-normal" style="">Show</label>
                                    <select name="sortuserresults" class="sinput" id=""
                                        wire:model="sortingValue" wire:change='resetPage'>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label class="font-weight-normal" style="">entries</label>
                                </div>
                                <div style="position: absolute; text-align: center;" wire:loading
                                    wire:target='searchTerm,sortingValue,previousPage,gotoPage,nextPage'>
                                    <span class="bg-light" style="padding: 5px 15px; border-radius: 2px;"><span
                                            class="spinner-border spinner-border-xs align-middle" role="status"
                                            aria-hidden="true"></span> Processing</span>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2 search_cont">
                                    <label class="font-weight-normal mr-2">Search:</label>
                                    <input type="search" class="sinput" placeholder="Search..." wire:model="searchTerm"
                                        wire:keyup='resetPage' />
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Email</th>
                                            <th class="align-middle">Gender</th>
                                            <th class="align-middle">Date Of Birth</th>
                                            <th class="align-middle">Created Date</th>
                                            <th class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($customers->count() > 0)
                                            @foreach ($customers as $customer)
                                                <tr>
                                                    <td>{{ $customer->device_token }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->gender }}</td>
                                                    <td>{{ $customer->birth_date }}</td>
                                                    <td>{{ $customer->created_at }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            class="btn btn-sm btn-soft-primary waves-effect waves-light action-btn edit_btn"
                                                            wire:click.prevent='editData({{ $customer->id }})'
                                                            wire:loading.attr='disabled'>
                                                            <i
                                                                class="mdi mdi-eye-outline font-size-13 align-middle"></i>
                                                        </button>
                                                        {{-- <button
                                                            class="btn btn-sm btn-soft-danger waves-effect waves-light action-btn delete_btn"
                                                            wire:click.prevent='deleteConfirmation({{ $customer->id }})'
                                                            wire:loading.attr='disabled'>
                                                            <i class="bx bx-trash font-size-13 align-middle"></i>
                                                        </button> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center pt-5 pb-5">No customer found!</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            {{ $customers->links('livewire.pagination-links') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    <div wire:ignore.self class="modal fade" id="editDataModal" tabindex="-1" role="dialog" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-labelledby="modelTitleId">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: white;">
                    <h5 class="modal-title m-0" id="mySmallModalLabel">View Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent='close'></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <form wire:submit.prevent='updateData'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Name</label>
                                        <input class="form-control mb-2" type="text" wire:model="name" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Email</label>
                                        <input class="form-control mb-2" type="text" wire:model="email" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Gender</label>
                                        <input class="form-control mb-2" type="text" wire:model="gender" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Goal</label>
                                        <input class="form-control mb-2" type="text" wire:model="goal" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Daily Activity
                                            Level</label>
                                        <input class="form-control mb-2" type="text"
                                            wire:model="daily_activity_level" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Starting
                                            Weight</label>
                                        <input class="form-control mb-2" type="text" wire:model="starting_weight"
                                            readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Current
                                            Weight</label>
                                        <input class="form-control mb-2" type="text" wire:model="current_weight"
                                            readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Target Weight</label>
                                        <input class="form-control mb-2" type="email" wire:model="target_weight"
                                            readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Height</label>
                                        <input class="form-control mb-2" wire:model="height" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Date Of
                                            Birth</label>
                                        <input class="form-control mb-2" wire:model="birth_date" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-number-input" class="col-form-label">Image</label>
                                        <input type="file" class="form-control" wire:model='avatar' />
                                        @error('avatar')
                                            <p class="text-danger" style="font-size: 11.5px;">{{ $message }}</p>
                                        @enderror

                                        <div wire:loading wire:target='avatar' wire:key='avatar'>
                                            <span class="spinner-border spinner-border-xs" role="status"
                                                aria-hidden="true"></span> <small>Uploading</small>
                                        </div>
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" class="img-fluid mt-2"
                                                style="height: 55px; width: 55px;" />
                                        @elseif ($uploadedAvatar)
                                            <img src="{{ asset($uploadedAvatar) }}" class="img-fluid mt-2"
                                                style="height: 55px; width: 55px;" />
                                        @endif
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Data Modal -->

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-md" role="document">
            <div class="modal-content p-5 bg-transparent border-0">
                <div class="modal-body pt-4 pb-4 bg-white" style="border-radius: 10px;">
                    <div class="row justify-content-center mb-2">
                        <div class="col-md-11 text-center">
                            <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;">
                                <div class="swal2-icon-content">!</div>
                            </div>
                            <h2>Are you sure?</h2>
                            <p class="mb-4">You won't be able to revert this!</p>

                            <button type="button" class="btn btn-sm btn-success waves-effect waves-light"
                                wire:click.prevent='deleteData' wire:loading.attr='disabled'>
                                {!! loadingStateWithText('deleteData', 'Yes, Delete.') !!}
                            </button>
                            <button type="button" class="btn btn-sm btn-danger waves-effect waves-light"
                                data-bs-dismiss="modal">No, Cancel.</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->
</div>

@push('scripts')
    <script>
        window.addEventListener('showEditModal', event => {
            $('#editDataModal').modal('show');
        });
        window.addEventListener('closeModal', event => {
            $('#addDataModal').modal('hide');
            $('#editDataModal').modal('hide');
        });

        window.addEventListener('customer_deleted', event => {
            $('#deleteDataModal').modal('hide');
            Swal.fire(
                "Deleted!",
                "The admin has been deleted.",
                "success"
            );
        });
    </script>
@endpush
