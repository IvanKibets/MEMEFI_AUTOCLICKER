@section('title', 'Voucher')
@section('sub-title', 'Index')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="p-4 row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="filter_voucher_number" placeholder="Voucher Number..." />
                </div>
                <div class="col-md-5">
                    <a href="javascript:void(0)" class="btn btn-primary" wire:click="$set('is_insert',true)"><i class="fa fa-plus"></i> Voucher</a>
                    <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#modal_upload" ><i class="fa fa-upload"></i> Upload</a>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>                             
                                <th>Voucher Number</th>                                    
                                <th>Nominal</th>                                    
                                <th>Status</th>
                                <th>Used Date</th>
                                <th>Created</th>
                            </tr> 
                        </thead>
                        <tbody>
                            @if($is_insert)
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="voucher_number" />
                                        <a href="javascript:void(0)" wire:click="generateRandomString"><i class="fa fa-refresh"></i> Generate</a>
                                        @error('voucher_number')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="amount" />
                                        @error('amount')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" wire:click="save" class="mx-2"><i class="fa fa-save"></i></a>
                                        <a href="javascript:void(0)" wire:click="$set('is_insert',false)"><i class="fa fa-times text-danger"></i></a>
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                            @foreach($data as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$item->voucher_number}}</td>
                                    <td>{{format_idr($item->amount)}}</td>
                                    <td>
                                        @if($item->status==0)
                                            <span class="badge badge-success">Available</span>
                                        @endif
                                        @if($item->status==1)
                                            <span class="badge badge-danger">Used</span>
                                        @endif
                                    </td>
                                    <td>{{$item->used_date ? date('d-M-Y',strtotime($item->used_date)) : '-'}}</td>
                                    <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="upload">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Upload Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="file" wire:model="file" />
                            @error('file')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info close-modal"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                    <div wire:loading>
                        <div class="page-loader-wrapper" style="display:block">
                            <div class="loader" style="display:block">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                <p>Please wait...</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
