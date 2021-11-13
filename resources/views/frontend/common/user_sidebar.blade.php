@php 
   $id = Auth::user()->id;
   $user = App\Models\User::find($id);
@endphp


<div class="col-md-2">
        <img src="{{ (!empty($user->profile_photo_path)) ? 
          url('upload/user_images/'.$user->profile_photo_path) : url('upload/no_image.jpg') }}" 
          alt="" style="border-radius: 50%; margin-bottom: 20px; margin-top: 20px;" class="card-img-top" width="160" height="160">
        <ul class="list-group list-group-flush">
        <a href="{{ route('dashboard')}}" class="btn btn-primary btn-sm btn-block">Home</a>
        <a href="{{ route('user.profile')}}" class="btn btn-primary btn-sm btn-block">Profile Update</a>
        <a href="{{ route('change.password')}}" class="btn btn-primary btn-sm btn-block">Change Password</a>
        <a href="{{ route('my.order')}}" class="btn btn-primary btn-sm btn-block">My Order</a>
        <a href="{{ route('return.order.list')}}" class="btn btn-primary btn-sm btn-block">Return Orders</a>
        <a href="{{ route('cancel.orders')}}" class="btn btn-primary btn-sm btn-block">Cancel Orders</a>
        <a href="{{ route('user.logout')}}" class="btn btn-danger btn-sm btn-block">Logout</a>
        </ul>
      </div>