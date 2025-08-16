<div>
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{$activeTab=='profile' ? 'active' : ''}}" wire:click="setActiveTab('profile')" id="tabs-profil-tab" data-toggle="pill" href="#tabs-profil"
                        role="tab" aria-controls="tabs-profil" aria-selected="true">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$activeTab=='photo' ? 'active' : ''}}" wire:click="setActiveTab('photo')" id="tabs-photo-tab" data-toggle="pill"
                        href="#tabs-photo" role="tab" aria-controls="tabs-photo"
                        aria-selected="false">Photo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$activeTab=='password' ? 'active' : ''}}" wire:click="setActiveTab('password')" id="tabs-password-tab" data-toggle="pill"
                        href="#tabs-password" role="tab" aria-controls="tabs-password"
                        aria-selected="false">Password</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                @if ($activeTab=='profile')
                <div class="tab-pane fade active show"  role="tabpanel"
                    aria-labelledby="tabs-profil-tab">
                    @include('form.photo.profile')
                </div>
                @endif
                @if ($activeTab=='photo')
                <div class="tab-pane fade active show"  role="tabpanel"
                    aria-labelledby="tabs-photo-tab">
                    @include('form.photo.photo')
                </div>
                @endif
                @if ($activeTab=='password')
                <div class="tab-pane fade active show"  role="tabpanel"
                    aria-labelledby="tabs-password-tab">
                    @include('form.photo.password')
                </div>
                @endif

            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
