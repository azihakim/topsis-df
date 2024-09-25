<div class="col-sm-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Penilaian <small>Fuzzy AHP</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
							class="fa fa-wrench"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="#">Settings 1</a>
						<a class="dropdown-item" href="#">Settings 2</a>
					</div>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="form-group row">
				{{-- <label class="control-label col-md-2 col-sm-2 ">Pilih Pelanggan</label>
				<div wire:ignore>
					<select class="form-control" id="select2">
						<option value="">Pilih Pelanggan</option>
						<option value="1">Pelanggan 1</option>
						<option value="2">Pelanggan 2</option>
						<option value="3">Pelanggan 3</option>
						@foreach ($series as $item)
							<option value="{{ $item }}">{{ $item }}</option>
						@endforeach
					</select>
				</div> --}}

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
				</div>
			@endif
		</div>
	</div>


</div>
@push('scripts')
	<script>
		$(document).ready(function() {
			$('#select2').select2();
			$('#select2').on('change', function(e) {
				var data = $('#select2').select2("val");
				@this.set('selected', data);
			});
		});
	</script>
@endpush
