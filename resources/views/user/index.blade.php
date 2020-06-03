@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Gente</h1>

            <form action="{{ route('user.index') }}" method="GET" id="frmSearch">
                <div class="row">
                    <div class="form-group col-md-10">
                        <input type="text" id="search" class="form-control" />
                    </div>

                    <div class="form-group col-md-2 btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success"/>
                    </div>
                </div>
            </form>

            <hr/>

            @foreach($users as $user)
                <div class="profile-user">
                
                    @if($user->image)
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar', ['filename'=>$user->image]) }}" alt="" class="avatar">
                        </div>
                    @endif

                    <div class="user-info">
                        <h2>{{ '@'.$user->nick }}</h2>
                        <h3>{{ $user->name.' '.$user->surname }}</h3>
                        <p>{{'Se unio: '. \FormatTime::LongTimeFilter($user->created_at) }}</p>
                        <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="btn btn-success">Ver perfil</a>
                    </div>

                    <div class="clearfix"></div>
                    <hr/>

                </div>
            @endforeach

            <!-- PAGINATION -->
            <div class="clear-fix">
                {{$users->links()}}
            </div>

        </div>
    </div>
</div>
@endsection
