@section('title', __('Pengajuan Pinjaman'))
@section('parentPageTitle', 'Pinjaman')
<div class="row clearfix">
    <div class="col-md-5">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="form-group" wire:ignore>
                        <label>{{ __('No Anggota / Nama Anggota') }}</label>
                        <select class="form-control select_anggota" wire:model="user_member_id">
                            <option value=""> -- Pilih -- </option>
                            @foreach($user_member as $item)
                                <option value="{{$item->id}}">{{$item->no_anggota_platinum}} / {{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('user_member_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" wire:model="description"></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 text-right">
                            <label>{{ __('Pinjaman Nominal') }}</label>
                            <input type="number" class="form-control text-right" wire:model="pinjaman" >
                            @error('pinjaman')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Lama Angsuran') }}</label>
                            <select class="form-control" wire:model="angsuran">
                                <option value="">  -- Pilih -- </option>
                                <option value="1">1 Bulan</option>
                                <option value="2">2 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="4">4 Bulan</option>
                                <option value="5">5 Bulan</option>
                                <option value="6">6 Bulan</option>
                                <option value="7">7 Bulan</option>
                                <option value="8">8 Bulan</option>
                                <option value="9">9 Bulan</option>
                                <option value="10">10 Bulan</option>
                                <option value="11">11 Bulan</option>
                                <option value="12">12 Bulan</option>
                            </select>
                            @error('angsuran')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>     
                        <div class="form-group col-md-3">
                            <label>{{ __('Jenis Pinjaman') }}</label>
                            <select class="form-control" wire:model="jenis_pinjaman_id">
                                <option value="">  -- Pilih -- </option>
                                @foreach($jenis_pinjaman as $item)
                                    <option value="{{$item->id}}">{{$item->name}} - {{$item->margin}}%</option>
                                @endforeach
                            </select>
                            @error('angsuran')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th>Margin / jasa</th>
                                    <td> : </td>
                                    <td class="text-right">{{format_idr($margin)}}%</td>
                                </tr>
                                <tr>
                                    <th>Biaya Admin</th>
                                    <td> : </td>
                                    <td class="text-right">Rp. {{format_idr($biaya_admin)}}</td>
                                </tr>
                                <tr>
                                    <th>Asuransi</th>
                                    <td> : </td>
                                    <td class="text-right">Rp. {{format_idr($asuransi)}}</td>
                                </tr>
                                <tr>
                                    <th>Nominal Pinjaman</th>
                                    <td> : </td>
                                    <td class="text-right">Rp. {{format_idr($pinjaman)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        Nominal yang Diterima
                                        <h3>Rp. {{format_idr($pinjaman-$asuransi-$biaya_admin)}}</h3>
                                    </td>
                                </tr>
                            </table>
                        </div>                    
                    </div>
                    <a href="{{route('pinjaman.index')}}"><i class="fa fa-arrow-left"></i> {{ __('Kembali') }}</a>
                    <button type="submit" class="btn btn-primary ml-3"><i class="fa fa-save"></i> {{ __('Submit Pengajuan') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="header">
                <h2>Detail Angsuran</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Bulan</th>                                    
                                <th rowspan="2">Pembiayaan</th>                                    
                                <th colspan="2" class="text-center">Angsuran</th>                                    
                                <th colspan="2" class="text-center">Jasa</th>                                    
                                <th rowspan="2" class="text-center">Tagihan</th>
                            </tr>
                            <tr>
                                <th class="text-center">Ke</th>
                                <th class="text-right">Rp</th>
                                <th class="text-center">%</th>
                                <th class="text-right">Rp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $k => $item)
                                <tr>
                                    <td>{{date('d-M-Y',strtotime($item['bulan']))}}</td>
                                    <td>{{format_idr($item['pembiayaan'])}}</td>
                                    <td class="text-center">{{$k+1}}</td>
                                    <td class="text-right">{{format_idr($item['angsuran_perbulan'])}}</td>
                                    <td class="text-center">{{@abs($item['jasa'])}}</td>
                                    <td class="text-center">{{format_idr($item['jasa_nominal'])}}</td>
                                    <td class="text-right">{{format_idr($item['total'])}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        setTimeout(() => {
            select__2 = $('.select_anggota').select2();
            $('.select_anggota').on('change', function (e) {
                var data = $(this).select2("val");
                @this.set("user_member_id", data);
            });
        }, 1000);
    </script>
@endpush