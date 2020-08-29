@extends('content.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Customer</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Input</h6>
    </div>
    <div class="card-body">
    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Customer</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bulk Insert</a>
        </li> -->
    </ul>
    
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form method="post" action="{{url('add-customer')}}" enctype="multipart/form-data" class="mt-2">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Customer Name *</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Branch *</label>
                            <select class="form-control"  name="branch_id" required>
                                <option> -- </option>
                                @foreach($data['branch'] as $branch)
                                <option value="{{ $branch->id }}"> {{ $branch->branch_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company</label>
                            <input type="text" class="form-control" name="company" id="exampleInputEmail1" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telp *</label>
                            <input type="text" class="form-control" name="telp" id="exampleInputEmail1" placeholder="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address *</label>
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="" required> </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="text-danger mt-3">Perhatian</p>
            <p class="text-danger mt-3">Silahkan anda <a href="#">unduh</a> file ini, lalu anda inputkan data - data items (product tinta) yang akan anda jual ke dalam file tersebut, kemudian silahkan anda upload kembali melalui form dibawah ini.</p>
            <div class="input-group mb-3 mt-2">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">File</span>
                </div>
                <input type="text" class="form-control" placeholder="Upload one or more files excel" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
        
        </div>
    </div>
    </div>

</div>
@endsection
