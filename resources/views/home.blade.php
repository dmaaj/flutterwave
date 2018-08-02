<?php
 $fees_count = count($fees);
 $count = 1;
 $cout = 1;
?>

@extends('layouts.home-layout')

@section('content')
<div class="dashboard">
<div class="container">
    <div class="row">
        <div class="col text-center">
            <h2> Payment Portal</h2>
        </div>
               
    </div>
    @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('success') }}</strong>
    </div>
    @endif
 
    @if ( Session::has('error') )
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ Session::get('error') }}</strong>
    </div>
    @endif
    <div class="row mt-3">
        <div class="col">
            Welcome, Please click the button 'Generate' to generate your Fees. Select the 'Pay' button to pay your fee
            <button class="btn btn-primary generate" style="float:right;"> Generate </button>
            <form action="{{ route('import') }}" method="POST" id="generate">
            {{ csrf_field() }}
                <input type="hidden" name="file" />
            </form>
        </div>
    </div>
</div>
</div>

<div class="dash">
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Pending Fees </h3>
             
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <td class="col-md-1"> Id </td>
            <td class="col-md-2"> Name </td>
            <td class="col-md-2"> Email </td>
            <td class="col-md-2"> Session </td>
            <td class="col-md-2"> Fee </td>
            <td class="col-md-2"> Amount </td>
            <td class="col-md-1"> Action </td> 
        </tr>
</thead>
</table >

            @if($fees_count > 0)
            
              @foreach($fees as $fee)
            <form method="POST" id="{{$fee->id}}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$fee->id}}">
            <input name="name" id="name" type="hidden" value="{{$user->name}}" >
            <input type="hidden" value="{{$user->email}}" name="email" id="email">
            <input type="hidden" value="{{$fee->fee}}" name="fee" id="fee">
            <input type="hidden" value="{{$fee->amount}}" name="amount" id="amount">
            </form>
        <table class="table">
        <tbody class="table-container"> 
        <tr>
            <td class="col-md-1">{{ $count++ }} </td>
            <td class="col-md-2">{{ $user->name }} </td>
            <td class="col-md-2">{{ $user->email }}  </td>
            <td class="col-md-2"> {{ $fee->session }}</td>
            <td class="col-md-2">{{ $fee->fee }} </td>
            <td class="col-md-2">{{ $fee->amount }} </td>
            <td class="col-md-1"> <button class="btn btn-primary submit" id="{{$fee->id}}"> Pay </button> </td>
            
        </tr>
        </tbody>

    </table>
        @endforeach
            @endif

</div>
</div>

<div class="dash">
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Paid Fees </h3>
             
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <td> Id </td>
                <td> Name </td>
                <td> Email </td>
                <td> Session </td>
                <td> Fee </td>
                <td> Amount </td>
                <td> Status </td>
                 
            </tr>
        </thead>
        <tbody>
        @if($fees_count > 0)
              @foreach($paid as $pay)
        <tr>    
            <td>{{ $cout++ }} </td>
            <td>{{ $user->name }} </td>
            <td>{{ $user->email }}  </td>
            <td> {{ $pay->session }}</td>
            <td>{{ $pay->fee }} </td>
            <td>{{ $pay->amount }} </td>
            <td>{{ $pay->status}} </td>
            
        </tr>
        @endforeach
            @endif
        </tbody>
    </table>
</div>
</div>

@endsection
@section('custom_script')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"> </script>
<script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script>
    
    $(document).ready(function () {
    $('.generate').on('click', function (e) {
        $('input[name="file"]').val('img/fees.xlsx');
        $('#generate').submit();
    });

    $('.submit').click(function(){
        var id = this.id;
        
        var formValues = $('#' + id).serialize();
	    console.log(formValues);
        
        var fee = $('#'+ id).find('input[name="fee"]').val();
        var email = $('#'+ id).find('input[name="email"]').val();
        var name = $('#'+ id).find('input[name="name"]').val();
        var amount = $('#'+ id).find('input[name="amount"]').val();

        console.log(fee);

        var PBFKey = "FLWPUBK-a7e2f843ad9ee4496101e469bbea3725-X";
    
        getpaidSetup({
        PBFPubKey: PBFKey,
        customer_email: email,
        customer_firstname: name,
        custom_description: fee,
        custom_logo: "https://res.cloudinary.com/maaj/image/upload/v1524822457/bot.png",
        custom_title: "University of Lagos",
        amount: amount,
        customer_phone: "234099940409",
        country: "NG",
        currency: "NGN",
        txref: "rave-123456",
        
        onclose: function() {},
        callback: function(response) {
            var flw_ref = response.tx.flwRef; // collect flwRef returned and pass to a 					server page to complete status check.
            console.log("This is the response returned after a charge", response);
            if (
            response.tx.chargeResponseCode == "00" ||
            response.tx.chargeResponseCode == "0"
            ) {
            // redirect to a success page
                $.ajax({
                    type: "POST",
                    url: "{{route('success')}}",
                    data: formValues, // serializes the form's elements.
                    dataType: 'json',
                    success: function(response)
                    {
                            // show response from the php script.
                        alert(response);
                        window.location.href = "home";
                    }
                    });
            } else {
            // redirect to a failure page.
            }
        }
        });

    });
    });
</script>

<!--
<script>
	 document.addEventListener("DOMContentLoaded", function(event) {
  document.getElementById("").addEventListener("click", function(e) {
    var PBFKey = "FLWPUBK-a7e2f843ad9ee4496101e469bbea3725-X";
    
    getpaidSetup({
      PBFPubKey: PBFKey,
      customer_email: "user@example.com",
      customer_firstname: "Temi",
      custom_description: "Pay School Fees",
      custom_logo: "http://localhost/communique-3/skin/frontend/ultimo/communique/custom/images/logo.svg",
      custom_title: "University of Lagos",
      amount: 50000,
      customer_phone: "234099940409",
      country: "NG",
      currency: "NGN",
      txref: "rave-123456",
      
      onclose: function() {},
      callback: function(response) {
        var flw_ref = response.tx.flwRef; // collect flwRef returned and pass to a 					server page to complete status check.
        console.log("This is the response returned after a charge", response);
        if (
          response.tx.chargeResponseCode == "00" ||
          response.tx.chargeResponseCode == "0"
        ) {
          // redirect to a success page
        } else {
          // redirect to a failure page.
        }
      }
    });
  });
});


</script> -->
@endsection
