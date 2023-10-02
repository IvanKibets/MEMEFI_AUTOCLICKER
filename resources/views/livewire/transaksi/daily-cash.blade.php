<form wire:submit.prevent="save">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-desktop"></i> Daily Cash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true close-btn">×</span>
        </button>
    </div>
    <div class="modal-body">
        @if($message)
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <i class="fa fa-check-circle"></i> {{$message}}
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-md-3">
                <select class="form-control" wire:model="filter_month" >
                    <option value=""> -- Month -- </option>
                    @foreach([
                                1=>'Januari',
                                2 =>'Februari',
                                3=>'Maret',
                                4=>'April',
                                5=>'Mei',
                                6=>'Juni',
                                7=>'Juli',
                                8=>'Agustus',
                                9=>'September',
                                10=>'Oktober',
                                11=>'November',
                                12=>'Desember'] as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Cash Transaction (POS)</th>
                    <th>Start Cash</th>
                    <th>End Cash</th>
                    <th>Daily Cash In</th>
                    <th>CT vs DC</th>
                    <th></th>
                </tr>
                @if($insert)
                    <tr style="background: #eee;">
                        <td></td>
                        <td>{{date('d/M/Y')}}</td>
                        <td>{{format_idr($cash_pos)}}</td>
                        <td>
                            <input type="number" class="form-control" wire:model="cash_start" />
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model="cash_end" />
                        </td>
                        <td>{{format_idr($daily_cash)}}</td>
                        <td class="{{$ct_vs_dc > 0? 'text-success' : 'text-danger'}}">
                            {{format_idr($ct_vs_dc)}}</td>
                        <td>
                            <a href="javascript:void(0)" class="badge badge-info badge-active" wire:click="save"> Update</a>
                        </td>
                    </tr>
                @endif
                @foreach($data as $k => $item)
                    @if($item->cash_date==date('Y-m-d')) @continue @endif
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{date('d/M/Y',strtotime($item->cash_date))}}</td>
                        <td>{{format_idr($item->cash_transaction_pos)}}</td>
                        <td>{{format_idr($item->cash_start)}}</td>
                        <td>{{format_idr($item->cash_end)}}</td>
                        <td>{{format_idr($item->daily_cash)}}</td>
                    </tr>
                @endforeach
            </tbody>
       </table>
    </div>
</form>
