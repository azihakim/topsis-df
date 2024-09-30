<div class="col-sm-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Penilaian</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			@if (session()->has('message'))
				<div wire:ignore.self>
					<div class="alert alert-danger" id="flash-message">
						{{ session('message') }}
					</div>
				</div>
			@endif
			<div class="form-group row">

				<div class="col-md-6 col-sm-6 ">
					<select class="form-control" wire:model="selectedPelanggan">
						<option>Pilih Pelanggan</option>
						@foreach ($pelanggans as $item)
							<option value="{{ $item->id }}">{{ $item->nama }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-4 col-sm-4">
					<button type="submit" class="btn btn-success" wire:click="tambahPelanggan">Tambah Pelanggan</button>
				</div>
			</div>
			@if ($selectedPelangganList)
				<div class="form-horizontal form-label-left">
					<div class="ln_solid"></div>
					@foreach ($selectedPelangganList as $item)
						<div class="form-group row">
							<label class="control-label col-md-1 col-sm-1 col-xs-1">{{ $item['nama'] }}</label>
							@foreach ($kriteriaPenilaian as $k)
								<div class="col-md-2 col-sm-2 col-xs-2">
									<span class="form-control-feedback left" aria-hidden="true">{{ $k['kode'] }}</span>
									<select class="form-control has-feedback-left"
										wire:model="penilaianData.{{ $item['id'] }}.{{ $k['kode'] }}">
										<option value="">{{ $k['nama'] }}</option>
										@foreach ($k['sub_kriterias'] as $subKriteria)
											<option value="{{ $subKriteria['bobot'] }}">
												{{ $subKriteria['rentang'] }}
											</option>
										@endforeach
									</select>
								</div>
							@endforeach
						</div>
						<div class="ln_solid"></div>
					@endforeach
					<div class="ln_solid"></div>
					<div class="form-group row">
						<div class="col-sm-12">
							{{-- <button class="btn btn-primary" wire:click="generatePDF">Cancel</button> --}}
							<button wire:click="storeData" class="btn btn-success">Simpan</button>
						</div>
					</div>
				</div>
			@else
				<div class="alert alert-warning">Tidak ada pelanggan yang dipilih.</div>
			@endif
		</div>
	</div>


</div>
@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Ambil elemen flash message
			var flashMessage = document.getElementById('flash-message');
			if (flashMessage) {
				// Set timeout untuk menghilangkan pesan setelah 3 detik
				setTimeout(function() {
					flashMessage.style.display = 'none';
				}, 1000); // 3000 ms = 3 detik
			}
		});
	</script>
@endpush
