@section('title', 'Pinjaman')
@section('sub-title', 'Index')

<div class="row clearfix">
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-database text-info"></i>
                </div>
                <div class="content">
                    <div class="text">Total Pengajuan</div>
                    <h5 class="number">{{format_idr($total_pengajuan)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-bank text-warning"></i>
                </div>
                <div class="content">
                    <div class="text">Total Pengajuan(Rp)</div>
                    <h5 class="number">Rp. {{format_idr($total_pengajuan_nominal)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-check-circle text-success"></i>
                </div>
                <div class="content">
                    <div class="text">Pengajuan Disetujui(Rp)</div>
                    <h5 class="number">Rp. {{format_idr($total_pengajuan_disetujui)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-times text-danger"></i>
                </div>
                <div class="content">
                    <div class="text">Pengajuan Ditolak(Rp)</div>
                    <h5 class="number">Rp. {{format_idr($total_pengajuan_ditolak)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-2">
                    <a href="{{route('pinjaman.insert')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Pinjaman</a>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Status</th>
                                <th>No Pengajuan</th>                                    
                                <th>Jenis Pinjaman</th>                                    
                                <th>No Anggota</th>                                    
                                <th>Nama</th>                                                
                                <th>Tanggal Pengajuan</th>                                                
                                <th class="text-right">Pinjaman</th>                                    
                                <th class="text-center">Tenor</th>
                                <th class="text-center">Angsuran</th>
                                <th class="text-center">Jasa</th>
                                <th class="text-right">Tagihan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                                <tr>
                                    <td style="width: 50px;">{{$k+1}}</td>
                                    <td class="text-center">
                                        @if($item->status==0)
                                            <span class="badge badge-warning">Approval</span>
                                        @endif
                                        @if($item->status==1)
                                            <span class="badge badge-success">On Going</span>
                                        @endif
                                        @if($item->status==2)
                                            <span class="badge badge-info">Completed</span>
                                        @endif
                                        @if($item->status==3)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td><a href="{{route('pinjaman.edit',$item->id)}}">{{$item->no_pengajuan}}</a></td>
                                    <td>{{isset($item->jenis_pinjaman->name) ? $item->jenis_pinjaman->name : '-'}}</td>
                                    <td><a href="{{route('user-member.edit',$item->user_member_id)}}" target="_blank">{{isset($item->anggota->no_anggota_platinum) ? $item->anggota->no_anggota_platinum : ''}}</a></td>
                                    <td><a href="{{route('user-member.edit',$item->user_member_id)}}" target="_blank">{{isset($item->anggota->name) ? $item->anggota->name : ''}}</a></td>
                                    <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                                    <td class="text-right">{{format_idr($item->amount)}}</td>
                                    <td class="text-center">{{format_idr($item->angsuran)}}</td>
                                    <td class="text-center">{{format_idr($item->angsuran_perbulan)}}</td>
                                    <td class="text-center">{{$item->jasa_persen}}% - Rp. {{format_idr($item->jasa)}}</td>
                                    <td class="text-right">{{format_idr($item->angsuran_perbulan)}}</td>
                                    <td>
                                        @if($item->status==0)
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete" wire:click="$set('selected_id',{{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                                            @if(\Auth::user()->user_access_id==3)
                                                <a href="{{ route('pinjaman.edit',$item->id) }}" class="badge badge-success badge-active"><i class="fa fa-edit"></i> Proses</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($data->count()==0)
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
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

    <div wire:ignore.self class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-information"></i> Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda ingin membatalkan peminjaman ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="delete" class="btn btn-danger close-modal">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
