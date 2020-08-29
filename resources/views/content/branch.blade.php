@extends('content.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Branch Management</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Branch</h6>
    </div>
    <div class="card-body">

    <div class="d-sm-flex align-items-center justify-content-center mt-2">
        <a href="{{url('add-branch')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Add Branch</a>
    </div>

        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Telp</th>
                    <th>Head Office</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- <tfoot>
                <tr>
                    <th>No</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Telp</th>
                    <th>Head Office</th>
                    <th>Action</th>
                </tr>
            </tfoot> -->
            <tbody>
                @foreach($data as $page)
                <tr>
                    <td>{{ $page->no }}</td>
                    <td>{{ $page->branch_name }}</td>
                    <td>{{ $page->address }}</td>
                    <td>{{ $page->telp }}</td>
                    <td>{{ $page->head_office }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                            <i class="fas fa-fw fa-pencil-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    </div>

</div>

@foreach($data as $page)
<div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="{{url('update-branch')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Branch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Branch Name *</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="" value="{{ $page->branch_name }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Head Office *</label>
                                <input type="text" class="form-control" id="head_office" name="head_office" placeholder="" value="{{ $page->head_office }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{ $page->email }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telp *</label>
                                <input type="text" class="form-control" name="telp" id="exampleInputEmail1" value="{{ $page->telp }}" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fax</label>
                                <input type="text" class="form-control" name="fax" id="exampleInputEmail1" value="{{ $page->fax }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Branch Address *</label>
                        <textarea type="text" class="form-control" id="address" name="address" placeholder="" required> {{ $page->address }} </textarea>
                    </div>
                    <input type="hidden" name="id" value="{{ $page->id }}" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
    <!-- /.modal-dialog -->
</div>
@endforeach
@endsection
