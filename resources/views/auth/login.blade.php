@extends('layouts.app')

@section('content')

 <div class="jumbotron jumbotron-fluid background">
        <div class="container">
            <div class="row px-5">
                <div class="col-md-8 left-badge">
                    <form method="Post" action="{{ route('login') }}" class="form-group">
                        {{ csrf_field() }}
                        @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        <input id=""type="text" placeholder="Email" class="form form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus/>
                        @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        <input type="password" placeholder="Password" class="form form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required/>
                        <input type="submit" class="btn btn-primary btn-submit" value="Sign in"/> 
                        <a href="{{ route('password.request') }}" class="pass-link"> Forgot Password </a>
                    </form>

                    <div class="row account">
                        <div class="col">
                            <span class="link mt-4">
                                Dont have an account? <a href="{{ route('register') }}"> Create an account</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 right-badge px-4">
                    <h2 style="font-weight: bold;"> Hello,</h2>
                    <h5> Welcome to University Of Lagos' Payment Portal </h5>

                    <p> 
                    Please log in with your student details to pay your fees. 
                    Create an account if visiting for the first time.
                    </p>

                    <span>
                        Be sure to email us with any difficulty in payment
                    </span>
                </div>
            </div>
        </div>
  
    </div>
@endsection
