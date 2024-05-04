<div>
    <section class="banner-static mt-5" id="banner">
        <div class="container">
            <h2 style="text-align: center; color:black" class="mb-5">Contact With Us</h2>
            <div style="text-align: center;">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form wire:submit.prevent='storeData'>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model='name' class="form-control">
                            @error('name')
                                <p class="text-danger" style="font-size: 11.5px;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" wire:model='email' class="form-control">
                            @error('email')
                                <p class="text-danger" style="font-size: 11.5px;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" wire:model='phone' class="form-control">
                            @error('phone')
                                <p class="text-danger" style="font-size: 11.5px;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Message</label>
                            <textarea class="form-control" wire:model='description' placeholder="Write your message..." rows="3"></textarea>
                            @error('description')
                                <p class="text-danger" style="font-size: 11.5px;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"> {!! loadingStateWithText('storeData', 'Send Message') !!}</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
</div>
