@section('title', 'Register')
<div class="container">
    <div class="mt-2 card">
      <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4><small>Koperasi</small><br />COOPZONE</h4>
                <!-- <p>Jl. Citarum Tengah Ruko E-1<br />
                Telp: 024-354 4085 Semarang 50126 </p> -->
            </div>
            
        </div>
      </div>
      <div class="card-body">
        <form class="form-auth-small" method="POST" wire:submit.prevent="register" action="" >
           
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-info">DATA SUPPLIER</h5>
                    <hr />
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nama Supplier</label><span class="text-danger">*
                                    <input type="text" class="form-control" wire:model="nama_supplier" />
                                </div>
                                <div class="col-md-6">
                                    <label>Tipe Supplier</label><span class="text-danger">*
                                    <select name="" id="" class="form-control" wire:model="tipe_supplier">
                                        <option value="lainnya">Lainnya</option>
                                        <option value="makanan">Makanan</option>
                                        <option value="perlengkapan-kantor">Perlengkapan Kantor</option>
                                        <option value="alat-elektronik">Alat Elektronik</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" wire:model="no_anggota_gold" /> -->
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName">E-mail</label><span class="text-danger">*
                                    <input type="email" class="form-control" placeholder="Enter name" wire:model="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label >No Telp. / HP</label><span class="text-danger">*
                                    <input type="text" class="form-control" wire:model="no_telp">
                                    @error('no_telp') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName">Password</label><span class="text-danger">*</span> 
                                    <input type="password" name="password" class="form-control" wire:model="password" wire:change="checkpw" required>
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputAlamat">Confirm Password</label><span class="text-danger">*
                                    <input type="password" name="confirm_password" class="form-control" wire:model="confirm_password" wire:change="checkpw" required>
                                    @if($match_pw==false)
                                    <span class="text-danger">Password Doesn't Match</span> 
                                    @endif
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputAlamat">Alamat</label>
                                    <!-- <input type="text" class="form-control" id="address" placeholder="Enter address" wire:model="address"> -->
                                    <textarea name="alamat_supplier" cols="30" rows="6" class="form-control" wire:model="alamat_supplier"></textarea>
                                    @error('alamat_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                                </div> 
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName">Provinsi</label>
                                    <select name="provinsi" class="form-control" wire:model="provinsi">
                                        @foreach(\App\Models\Provinsi::get()  as $item)
                                        <option value="{{ $item->id_prov }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('provinsi') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-group col-md-12">
                    <hr />
                    <a href="/"><i class="fa fa-arrow-left"></i> {{__('Back')}}</a>
                    @if($match_pw == true)
                    <button type="submit" class="ml-3 btn btn-primary">{{ __('Submit Pendaftaran') }} <i class="fa fa-check"></i></button>
                    @endif
                </div>
            </div>
            
            
        </form>
      </div>
    </div>
</div>
