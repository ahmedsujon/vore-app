<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Fat Secret</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Fat Secret</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-white" style="border-bottom: 1px solid #e2e2e7;">
                            <h4 class="card-title" style="float: left;">Fat Secret Search</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <form wire:submit.prevent='searchFoods'>
                                                <div class="form-group">
                                                    <label for="">Search</label>
                                                    <div class="input-group">
                                                        <input type="text" wire:model.blur='search_value'
                                                            class="form-control" placeholder="Search here" />
                                                        <button type="submit" style="width: 120px;"
                                                            wire:loading.attr='disabled' class="btn btn-sm btn-primary">
                                                            {!! loadingStateWithText('searchFoods', 'Get Foods') !!}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-white" style="border: 1px solid #CCC;">
                                            <h5 class="float-start">All Foods</h5>
                                            {{-- <button class="btn btn-sm btn-primary float-end save_btn" wire:click.prevent='saveAllToDatabase'>Store All</button> --}}
                                        </div>
                                        <div class="card-body" style="border: 1px solid #CCC; border-top: 0px;">
                                            @if ($foods)
                                                <div class="row justify-content-center">
                                                    @foreach ($foods as $key => $food)
                                                        <div class="col-md-12">
                                                            <div class="card" style="border: 1px solid #CCC;">
                                                                <div class="card-body bg-white pt-0 pb-2">
                                                                    <h6 class="mt-3 float-start">
                                                                        {{ $food['food_name'] }}
                                                                        <small class="text-danger" title="Brand">
                                                                            @if ($food['food_type'] == 'Brand')
                                                                                {{ $food['brand_name'] }}
                                                                            @endif
                                                                        </small>
                                                                    </h6>
                                                                    <a href="{{ $food['food_url'] }}" class="float-end text-success mt-3" target="_blank">View Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-12 py-5 text-center">
                                                        <small>No data available!</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
