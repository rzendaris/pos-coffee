@extends('content.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Master Product Category</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Product Category</h6>
    </div>
    <div class="card-body">

    <div class="d-sm-flex align-items-center justify-content-center mt-2">
        <!-- <a href="{{url('add-branch')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Add Type</a> -->
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-upload fa-sm text-white-50"></i> Add Category
        </button>
    </div>

        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Description</th>
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
                    <td style="width:5%;text-align:center">{{ $page->no }}</td>
                    <td style="text-align:center">{{ $page->category_name }}</td>
                    <td>{{ $page->description }}</td>
                    <td style="width:10%">
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#editModal{{ $page->id }}">
                            <i class="fas fa-fw fa-pencil-alt"></i> Edit
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="{{url('add-category')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Product Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category *</label>
                        <input type="text" class="form-control" id="type_name" name="type_name" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description </label>
                        <textarea type="text" class="form-control" id="description" name="description" placeholder=""> </textarea>
                    </div>
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

@foreach($data as $page)
<div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="{{url('update-category')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category *</label>
                        <input type="text" class="form-control" id="type_name_edit" name="type_name_edit" placeholder="" value="{{ $page->category_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description </label>
                        <textarea type="text" class="form-control" id="description_edit" name="description_edit" placeholder=""> {{ $page->description }} </textarea>
                    </div>
                    <input type="hidden" name="id_edit" value="{{ $page->id }}" />
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
