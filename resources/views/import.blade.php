@extends('layout.main')
@section('contant')
        

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Import</h1>
                              
                    
                    <div class="col-12 mt-4">  
                
                        <form action="{{ url('import') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    {!! \Session::get('success') !!}
                                </div>
                            @endif

                            @if (\Session::has('error'))
                                <div class="alert alert-danger">
                                    {!! \Session::get('error') !!}
                                </div>
                            @endif
                            <div class="form-group">
                              <label for="import">Import:</label>
                              <input type="file" class="form-control" id="importId" accept=".csv" name="import" data-type="" >
                              @error('import')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="file_type">file type:</label>
                              <select name="file_type"  class="form-control" id="file_type">
                                <option value="">select type</option>
                                <option value="amazon">Amazon</option>
                                <option value="flipkart">Flipkart</option>
                                <option value="dmart">dmart</option>
                              </select>
                              @error('file_type')
                              <p class="text-danger">{{ $message }}</p>
                              @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </form>
                    </div>
                
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
           
   @endsection