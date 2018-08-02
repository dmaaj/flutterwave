@extends('layouts.home-layout')

@section('content')


    <div class="jumbotron jumbotron-fluid background">
        <div class="container">
            <div class="row px-5">
                <div class="col-md-8 left-badge">
                    <form method="Post" action="" class="form-group">
                        {{ csrf_field() }}

                        <input type="text" placeholder="Email" class="form"/>
                        <input type="password" placeholder="Password" class="form"/>
                        <input type="submit" class="btn btn-primary btn-submit" value="Sign in"/> 
                        <a href="" class="pass-link"> Forgot Password </a>
                    </form>

                    <div class="row mx-5">
                        <div class="col mx-5">
                            <span class="link mt-4">
                                Dont have an account? <a href="#"> Create an account</a>
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
@section('custom_script')

@endsection