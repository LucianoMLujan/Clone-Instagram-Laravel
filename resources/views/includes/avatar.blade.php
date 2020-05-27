@if(Auth::user()->image)
    <div class="container-avatar">
        <img src="{{ route('user.avatar', Auth::user()->image)}}" class="avatar" alt="" />
    </div>
@endif