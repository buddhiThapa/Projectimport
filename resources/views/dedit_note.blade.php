@extends('layout.main')

@section('contant')
    

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search --
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>-->

                    <h1 style="color: black;">Account Mangement System</h1>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto"></ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Debit Note</h1>
                              
                    
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5">
                                <div class='input-group yearSrTarget w-100' id = "mydate">
                                    <input onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="From Date" name="from_date" id="from_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5">
                                <div class='input-group monthSrTarget w-100' id = "toMydate">
                                    <input onfocus="(this.type='date')" onblur="(this.type='text')"  id="to_date" name="to_date" placeholder="To Date" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5">
                                <select class="select2 select2-multiple form-control" name="state" id="state">
                                    <option value="">Select State</option>
                                    @if (isset($state) && !empty($state))
                                        @foreach ($state as $item)
                                            <option value="{{$item}}">{{ ucWords($item) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5">
                                <select class="select2 select2-multiple form-control" name="vendor" id="vendor">
                                    <option value="">Select vendor</option>
                                    @if (isset($vendor) && !empty($vendor))
                                        @foreach ($vendor as $item)
                                            <option value="{{$item}}">{{ ucWords($item) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5 mt-4">
                                <select class="select2 select2-multiple form-control" name="gst_percentage" id="gst_percentage">
                                    <option value="">Select GST</option>
                                    @if (isset($gst_percentage) && !empty($gst_percentage))
                                        @foreach ($gst_percentage as $item)
                                            <option value="{{$item}}">{{ ucWords($item) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pl-xs-0 pr-xs-5 mt-4">
                                <select class="select2 select2-multiple form-control" name="payment_mode" id="payment_mode">
                                    <option value="">Select payment mode</option>
                                    @if (isset($payment_mode) && !empty($payment_mode))
                                        @foreach ($payment_mode as $item)
                                            <option value="{{$item}}">{{ ucWords($item) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class=" col-lg-3 col-md-3 col-xs-6 form-group mb-0 p-0 mt-xs-5 pl-4 pt-4 pl-xs-0 pr-xs-5">
                                <button class="btn btn-primary" id="filterbtn">submit</button>
                                <a class="btn btn-danger" id="import" href="{{ route('importfile') }}" >Import</a>
                            </div>
                            
                        </div>
                
                            
                          
                    
                    
                    <div class="col-12 mt-4">  
                
                        <table class="table table-striped table-success text-dark table-bordered" id='data_table' >
                          <thead>
                            <tr>
                              {{-- <th>Vendor name</th> --}}
                              <th >Sn no</th>
                              <th>Order Id</th>
                              <th>Order date</th>
                              <th>Bill to State</th>
                              <th>Vendor</th>
                              <th>Customer Type</th>
                              <th>Gst Percentage</th>
                              <th>Payment Mode</th>
                              {{-- <th>To date</th> --}}
                            </tr>
                          </thead>
                        </table>
                      </div>
                
                </div>
                <!-- /.container-fluid -->

   
    <script>
        $(document).ready(function(){
            getAmazonData();
        });
        
        $('#filterbtn').click(function(){
            getAmazonData();
            return false;
        })
        
        function getAmazonData(){
            var state = $('#state').find(':selected').val();
            var vendor = $('#vendor').find(':selected').val();
            var payment_mode = $('#payment_mode').find(':selected').val();
            var gst_percentage = $('#gst_percentage').find(':selected').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            // var state = $('#state').find(':selected').val();
            $('#data_table').dataTable().fnDestroy();
            $('#data_table tbody').empty();
            var table=$('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    iDisplayLength:50,
                    ajax: {
                        url: "{{ url('getAmazonData') }}",
                        data:{
                            state:state,vendor:vendor,payment_mode:payment_mode,gst_percentage:gst_percentage,from_date:from_date,to_date:to_date
                        },
                        method: 'GET',
                        // data: {
                        //     year: year,
                        //     month: month,
                        //     filter_type: filter_type,
                        //     location_id: location_id,
                        //     user_id: user_id,
                        // }
                    },
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50,100]
                    ],
            
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'order_id', name: 'order_id'},
                        {data: 'order_date', name: 'order_date'},
                        {data: 'ship_to_state', name: 'ship_to_state',searchable:true},
                        {data: 'vendor', name: 'vendor',searchable:true},
                        {data: 'customer_type', name: 'customer_type',searchable:true},
                        {data: 'gst_percentage', name: 'gst_percentage',searchable:true},
                        {data: 'payment_mode', name: 'payment_mode',searchable:true},
                    ],
                    language: {
                        searchPlaceholder: 'Search..........',
                        sSearch: '',
                        lengthMenu: '_MENU_',
                    },
                });
        }
        </script>

</body>

</html>

@endsection