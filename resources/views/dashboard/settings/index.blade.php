@extends('layouts.dashboard.app')

@section('title', 'Setting')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <style>
        .preview-image {
            width: 300px;
            height: 150px;
            object-fit: cover;
            object-position: center;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-center">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4" style="min-width: 100ch">
                <h2>Update Setting</h2><br><br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable">Site Name</label>
                            <input type="text" value="{{ $settings->site_name }}" name="site_name"
                                placeholder="Enter User site_name" class="form-control">
                            @error('site_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Email</label>
                            <input type="text" value="{{ $settings->email }}" name="email"
                                placeholder="Enter User email" class="form-control">
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable">Phone</label>
                            <input type="text" value="{{ $settings->phone }}" name="phone"
                                placeholder="Enter User phone" class="form-control">
                            @error('phone')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Country</label>

                            <input type="text" value="{{ $settings->country }}" name="country"
                                placeholder="Enter User country" class="form-control">
                            @error('country')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> City</label>
                            <input type="text" value="{{ $settings->city }}" name="city" placeholder="Enter city Name"
                                class="form-control">
                            @error('city')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Street</label>
                            <input type="text" value="{{ $settings->street }}" name="street"
                                placeholder="Enter street Name" class="form-control">
                            @error('street')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Facebook</label>
                            <input type="text" value="{{ $settings->facebook }}" name="facebook"
                                placeholder="Enter facebook Link " class="form-control">
                            @error('facebook')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Twitter</label>
                            <input type="text" value="{{ $settings->twitter }}" name="twitter"
                                placeholder="Enter twitter link " class="form-control">
                            @error('twitter')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Instagram</label>
                            <input type="text" value="{{ $settings->instagram }}" name="instagram"
                                placeholder="Enter instagram Link" class="form-control">
                            @error('instagram')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="lable"> Youtupe</label>
                            <input type="text" value="{{ $settings->youtube }}" name="youtube"
                                placeholder="Enter youtube link " class="form-control">
                            @error('youtube')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="lable"> Small Description</label>
                            <textarea type="text" name="small_desc" placeholder="Enter small_desc " class="form-control">{{ $settings->small_desc }}</textarea>
                            @error('small_desc')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Logo Section -->
                    <div class="col-6">
                        <div class="form-group">
                            Logo : <input type="file" class="dropify" name="logo" class="form-control">
                            @error('logo')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <br>
                            <img class="img-thumbnail" src="{{ asset($settings->logo) }}">
                        </div>
                    </div>

                    <!-- Favicon Section -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="favicon">Favicon:</label>
                            <input type="file" class="dropify form-control" id="favicon" name="favicon">
                            @error('favicon')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <div class="text-center mt-3">
                                <img class="img-thumbnail preview-image" src="{{ asset($settings->favicon) }}"
                                    alt="Favicon">
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <input name="setting_id" value="{{ $settings->id }}" hidden>
                <button type="submit" class="btn btn-primary"> Update Setting</button>
            </div>

        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drop a file here',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
