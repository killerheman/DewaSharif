@extends('home.includes.master')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center maroon mb-4">*** Banks ***</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <p>
                <i><b>The banks</b></i> in <b>Dewa Sharif</b> are integral to the town's financial infrastructure, offering a range of services that cater to the needs of residents, businesses, and the many visitors to this spiritual center. 
                They support the local economy, foster financial growth, and help maintain a seamless flow of banking services in a town known for its religious and cultural heritage.
            </p>

            <h4 class="mt-4 mb-3">List of the Banks in Dewa Sharif :</h4>
            
            <p>
                1. <i><b> Bank of India </b></i> &amp; <i><b> ATM</b></i><br>
                2. <i><b> Bank of Baroda</b></i> &amp; <i><b> ATM</b></i><br>
                3. <i><b> State Bank of India</b></i> &amp; <i><b> ATM</b></i><br>
                4. <i><b> Union Bank of India</b></i> &amp; <i><b> ATM</b></i><br>
                5. <i><b> Central Bank of India</b></i> &amp; <i><b> ATM</b></i><br>
                6. <i><b> Axis Bank</b></i> &amp; <i><b> ATM</b></i><br>
                7. <i><b> HDFC</b></i> &amp; <i><b> ATM</b></i><br>
                8. <i><b> Aryawart Gramin Bank</b></i>
            </p>
        </div>

        <div class="col-sm-4 text-center">
            <img src="{{ asset('home/images/dewasharif/dewapage/banks.jpg') }}" alt="Banks in Dewa Sharif" class="img-fluid">
        </div>
    </div>
</div>
@endsection