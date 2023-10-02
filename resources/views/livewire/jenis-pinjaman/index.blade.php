@section('title', 'Jenis Pembiayaan')

<div class="row clearfix">
    <div class="col-lg-8">
        <div class="card">
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Pembiayaan</th>
                                <th class="text-center">Margin (%)</th>
                                <th class="text-right">Biaya Admin</th>
                                <th class="text-right">Asuransi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                                @if($edit and $selected_id==$item->id)
                                    <tr>
                                        <td style="width: 50px;">{{$k+1}}</td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="name" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" wire:model="margin" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" wire:model="biaya_admin" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" wire:model="asuransi" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="save" class="mx-2"><i class="fa fa-save"></i></a>
                                            <a href="javascript:void(0)" wire:click="$set('edit',false)"><i class="fa fa-times text-danger"></i></a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="width: 50px;">{{$k+1}}</td>
                                        <td><a href="javascript:void(0)" wire:click="set_edit({{$item->id}})">{{$item->name}}</a></td>
                                        <td class="text-center">{{$item->margin}}</td>
                                        <td class="text-right">{{format_idr($item->biaya_admin)}}</td>
                                        <td class="text-right">{{format_idr($item->asuransi)}}</td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="set_edit({{$item->id}})"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if($insert==false)
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <a href="javascript:void(0)" wire:loading.remove wire:click="$set('insert',true)"><i class="fa fa-plus"></i> Jenis Pembiayaan</a>
                                        <span wire:loading>
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                        </span>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" wire:loading.remove wire:target="save" class="form-control" wire:model="name" placeholder="Name" />
                                    </td>
                                    <td>
                                        <input type="number" wire:loading.remove wire:target="save" class="form-control" wire:model="margin" placeholder="Margin" />
                                    </td>
                                    <td>
                                        <input type="number" wire:loading.remove wire:target="save" class="form-control" wire:model="biaya_admin" placeholder="Biaya Admin" />
                                    </td>
                                    <td>
                                        <input type="number" wire:loading.remove wire:target="save" class="form-control" wire:model="asuransi" placeholder="Asuransi" />
                                    </td>
                                    <td>
                                        <span wire:loading wire:target="save">
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                        </span>
                                        <a href="javascript:void(0)" wire:click="save"><i class="fa fa-save"></i></a>
                                        <a href="javascript:void(0)" wire:click="$set('insert',false)" class="mx-2"><i class="fa fa-close text-danger"></i></a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_autologin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Autologin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger close-modal">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-warning"></i> Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <p>Are you want delete this data ?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                <button type="button" wire:click="delete()" class="btn btn-danger close-modal">Yes</button>
            </div>
        </div>
    </div>
</div>
@section('page-script')
function autologin(action,name){
    $("#modal_autologin form").attr("action",action);
    $("#modal_autologin .modal-body").html('<p>Autologin as '+name+' ?</p>');
    $("#modal_autologin").modal("show");
}
@endsection