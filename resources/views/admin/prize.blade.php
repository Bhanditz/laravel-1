@extends('layout.main')

@section('content')

	<!-- Start Page Content -->
    <div class="row prize-wrapper">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                	<div class="header-holder">
	                    <h4 class="card-title pull-left">List of Prizes</h4>
	                    <button type="button" class="btn btn-danger pull-right" id="del-btn-chk-prize">Delete</button>
	                    <button type="button" class="btn btn-info pull-right" id="new-btn-prize">Add New</button>
	                </div>
                    <div class="table-responsive">
                        <table id="table-prize" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center remove-sort"><input type="checkbox" class="chkToDel"></th>
                                    <th>Promo</th>
                                    <th>Prize</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Draw Up</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Promo</th>
                                    <th>Prize</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Draw Up</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            	@if($prize->count() > 0)
                                    @foreach($prize as $row)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="toDelPrize" value="{{ $row->id }}">
                                            </td>
                                            <td>{{ $row->promo }}</td>
                                            <td>{{ $row->prize }}</td>
                                            <td class="text-center">
                                                @if(empty($row->image))
                                                    <img src="{{ asset('resources/assets/img/no-image.jpg') }}" width="50" height="50">
                                                @else
                                                    <img src="{{ asset('resources/assets/uploads/img') }}/{{ $row->image }}" width="50" height="50">
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->quantity }}</td>
                                            <td class="text-center">
                                                @if($row->draw_up === 0)
                                                    <span class="label label-danger">No</span>
                                                @else
                                                    <span class="label label-success">Yes</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info btn-view-prize" value="{{ $row->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-info btn-edit-prize" value="{{ $row->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-del-prize" value="{{ $row->id }}"">
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
        </div>
    </div>
    <!-- End PAge Content -->
	

@endsection