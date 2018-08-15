@extends('layout.main')

@section('content')

	<!-- Start Page Content -->
    <div class="row records-wrapper">
        <div class="col-12">

            <div class="card upload-holder">
                <div class="card-body">
                	<h4 class="card-title">Upload Records</h4>
                    <form action="{{ route('records.store') }}" method="POST" id="form-records" enctype="multipart/form-data">
                        <div class="form-group row col-md-4 promo-group">
                            <label for="records_promo" class="col-sm-3 control-label records-label">Promo:</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="promo_id" id="records_promo">
                                    <option value=""></option>
                                    @if($promo->count() > 0)
                                        @foreach($promo as $row)
                                            <option value="{{ $row->id }}">{{ $row->promo }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback animated fadeInDown">
                                    Please select promo
                                </div>
                            </div>
                        </div>

                        <div class="form-group row col-md-12 input-group">
                            <div id="dropzone">
                                <div class="img-holder" style="display: none;"><img src="{{ asset('resources/assets/img/excel.png') }}"></div>
                                <div style="color: #2f2f2f" class="text">Drop your file here.</div>
                                <input type="file" name="records" id="records_file" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                            <div class="invalid-feedback animated fadeInDown">
                                Please upload a file
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- records table wrapper -->
            <div class="card record-table-holder">
                <div class="card-body">
                    <div class="header-holder">
                        <h4 class="card-title pull-left">List of Files</h4>
                        <button type="button" class="btn btn-info pull-right" id="new-btn-records">Add New</button>
                    </div>
                    <div class="table-responsive">
                        <table id="table-records" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="remove-sort"></th>
                                    <th>Filename</th>
                                    <th>Promo</th>
                                    <th>Generated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Filename</th>
                                    <th>Promo</th>
                                    <th>Generated</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if($files->count() > 0)
                                    @foreach($files as $file)
                                        <tr>
                                            <td></td>
                                            <td>{{ str_replace('_', ' ', $file->file) }}</td>
                                            <td>{{ $file->promo }}</td>
                                            <td class="text-center">
                                                @if($file->status === 0)
                                                    <span class="label label-danger">No</span>
                                                @else
                                                    <span class="label label-success">Yes</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($file->status === 0)
                                                    <button type="button" class="btn btn-info btn-generate-record" value="{{ base64_encode($timestamp . $file->id . $randomKey) }}">Generate Tickets</button>
                                                @else
                                                    <!-- <a href="{{ url('records/show/?id=' . base64_encode($timestamp . $file->id . $randomKey)) }}" class="btn btn-info"><i class="fa fa-eye"></i></a> -->
                                                     <button type="button" class="btn btn-info btn-view-record" value="{{ base64_encode($timestamp . $file->id . $randomKey) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-danger btn-del-record" value="{{ base64_encode($timestamp . $file->id . $randomKey) }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card record-data-table-holder hide">
                <div class="card-body">
                    <div class="header-holder">
                        <h4 class="card-title pull-left">List of Records Data</h4>
                        <!-- <button type="button" class="btn btn-danger pull-right" id="del-btn-record-file">Delete</button> -->
                        <!-- <input type="checkbox" class="chkToDel"> -->
                        <a href="{{ route('records.index') }}" class="btn btn-info pull-right">Back</a>
                    </div>
                    <div class="table-responsive">
                        <table id="table-file-records" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="remove-sort"></th>
                                    <th>Name</th>
                                    <th>Username/Code</th>
                                    <th>Entries</th>
                                    <th>Ticket No. Start</th>
                                    <th>Ticket No. End</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Username/Code</th>
                                    <th>Entries</th>
                                    <th>Ticket No. Start</th>
                                    <th>Ticket No. End</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End PAge Content -->
	

@endsection