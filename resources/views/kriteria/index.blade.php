@extends('master')

@section('styles')
@endsection

@section('content')
	@if (session('success'))
		<div class="alert alert-success">
			{{ session('success') }}
		</div>
	@endif
	@if (session('error'))
		<div class="alert alert-error">
			{{ session('error') }}
		</div>
	@endif
	<div class="col-md-12 col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				{{-- <h2>Kriteria</h2> --}}
				<ul class="nav navbar-right panel_toolbox">

					<li>
						<a href="{{ route('kriteria.create') }}"
							style="text-decoration: none; transition: color 0.3s; color: rgb(76, 75, 75);">
							<i class="fa fa-plus"></i> Tambah
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				{{-- @if ($data)
					<div class="row">
						<br>
						<!-- Section 1: Penilaian Data -->
						<h4 style="margin-bottom: 10px">Penilaian Data</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Nama Pelanggan</th>
									@if (isset($data['penilaianData']) && !empty($data['penilaianData']))
										@php
											$firstPenilaian = reset($data['penilaianData']);
											$kodeKriteria = array_column($firstPenilaian['kriteria'], 'kode_kriteria');
										@endphp
										@foreach ($kodeKriteria as $kode)
											<th>{{ $kode }}</th>
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($data['penilaianData'] as $penilaian)
									<tr>
										<td>{{ $penilaian['pelanggan_nama'] ?? 'N/A' }}</td>
										@foreach ($penilaian['kriteria'] as $kriteria)
											<td>{{ $kriteria['nilai'] ?? 'N/A' }}</td>
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>

						<!-- Section 2: Matriks Ternormalisasi -->
						<h4 style="margin-bottom: 10px">Matriks Ternormalisasi</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Nama Pelanggan</th>
									@if (isset($data['matriksTernormalisasi']) && !empty($data['matriksTernormalisasi']))
										@php
											$firstMatriks = reset($data['matriksTernormalisasi']);
											$kodeKriteria = array_column($firstMatriks['kriteria'], 'kode_kriteria');
										@endphp
										@foreach ($kodeKriteria as $kode)
											<th>{{ $kode }}</th>
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($data['matriksTernormalisasi'] as $matriks)
									<tr>
										<td>{{ $matriks['nama_pelanggan'] ?? 'N/A' }}</td>
										@foreach ($matriks['kriteria'] as $kriteria)
											<td>{{ $kriteria['nilai_ternormalisasi'] ?? 'N/A' }}</td>
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>

						<!-- Section 3: Matriks Terbobot -->
						<h4 style="margin-bottom: 10px">Matriks Terbobot</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Nama Pelanggan</th>
									@if (isset($data['matriksTerbobot']) && !empty($data['matriksTerbobot']))
										@php
											$firstMatriks = reset($data['matriksTerbobot']);
											$kodeKriteria = array_column($firstMatriks['kriteria'], 'kode_kriteria');
										@endphp
										@foreach ($kodeKriteria as $kode)
											<th>{{ $kode }}</th>
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($data['matriksTerbobot'] as $matriks)
									<tr>
										<td>{{ $matriks['nama_pelanggan'] ?? 'N/A' }}</td>
										@foreach ($matriks['kriteria'] as $kriteria)
											<td>{{ $kriteria['nilai_terbobot'] ?? 'N/A' }}</td>
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>

						<!-- Section 4: Solusi Ideal Positif -->
						<h4 style="margin-bottom: 10px">Solusi Ideal Positif</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									@if (isset($data['solusiIdealPositif']) && !empty($data['solusiIdealPositif']))
										@foreach ($data['solusiIdealPositif'] as $solusi)
											<th>{{ $solusi['kode_kriteria'] ?? 'N/A' }}</th>
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody>
								<tr>
									@foreach ($data['solusiIdealPositif'] as $nilai)
										<td>{{ $nilai['nilai'] ?? 'N/A' }}</td>
									@endforeach
								</tr>
							</tbody>
						</table>

						<!-- Section 5: Solusi Ideal Negatif -->
						<h4 style="margin-bottom: 10px">Solusi Ideal Negatif</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									@if (isset($data['solusiIdealNegatif']) && !empty($data['solusiIdealNegatif']))
										@foreach ($data['solusiIdealNegatif'] as $solusi)
											<th>{{ $solusi['kode_kriteria'] ?? 'N/A' }}</th>
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody>
								<tr>
									@foreach ($data['solusiIdealNegatif'] as $nilai)
										<td>{{ $nilai['nilai'] ?? 'N/A' }}</td>
									@endforeach
								</tr>
							</tbody>
						</table>

						<!-- Section 6: Jarak Solusi -->
						<h4 style="margin-bottom: 10px">Jarak Solusi</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Nama Pelanggan</th>
									<th>Jarak Positif</th>
									<th>Jarak Negatif</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data['calculateJarakSolusi'] as $jarak)
									<tr>
										<td>{{ $jarak['nama_pelanggan'] ?? 'N/A' }}</td>
										<td>{{ $jarak['jarakPositif'] ?? 'N/A' }}</td>
										<td>{{ $jarak['jarakNegatif'] ?? 'N/A' }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

						<!-- Section 7: Nilai Preferensi -->
						<h4 style="margin-bottom: 10px">Nilai Preferensi</h4>
						<table class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Ranking</th>
									<th>Nama Pelanggan</th>
									<th>Nilai Preferensi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data['nilaiPreferensiDenganNama'] as $preferensi)
									<tr>
										<td style="text-align: center">{{ $preferensi['ranking'] ?? 'N/A' }}</td>
										<td>{{ $preferensi['nama_pelanggan'] ?? 'N/A' }}</td>
										<td style="text-align: center">{{ number_format($preferensi['nilai_preferensi'], 4) ?? 'N/A' }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif --}}

				<div class="row">
					<h2>Kriteria</h2>

					<div class="col-sm-12">
						<div class="card-box table-responsive">
							<table class="table" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Kode</th>
										<th>Kriteria</th>
										<th>Bobot</th>
										<th style="width: 20%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($datakriteria as $item)
										<tr>
											<td>{{ $item->kode }}</td>
											<td>{{ $item->nama }}</td>
											<td>{{ $item->bobot }}</td>
											<td style="text-align: center">
												<div class="col-md-6">
													<a href="{{ route('kriteria.edit', $item->id) }}" class="btn-hover">
														<i class="fa fa-pencil"></i> Edit
													</a>
												</div>
												@if ($item->id)
													<div class="col-md-6">
														<form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" style="display: inline;">
															@csrf
															@method('DELETE')
															<button type="submit" class="btn-hover"
																style="border: none; background: none; color: red; padding: 0; cursor: pointer;">
																<i class="fa fa-trash"></i> Hapus
															</button>
														</form>
													</div>
												@endif

											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- <div class="col-md-12 col-sm-12">
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>C1 Jumlah Pesanan</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box table-responsive">
								<table class="table" cellspacing="0" width="100%" style="text-align: center">
									<thead>
										<tr>
											<th>Jumlah Pesanan</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>>10 Barang</td>
											<td>6</td>
										</tr>
										<tr>
											<td>8-9 Barang</td>
											<td>5</td>
										</tr>
										<tr>
											<td>6-7 Barang</td>
											<td>4</td>
										</tr>
										<tr>
											<td>4-5 Barang</td>
											<td>3</td>
										</tr>
										<tr>
											<td>2-3 Barang</td>
											<td>2</td>
										</tr>
										<tr>
											<td>1 Barang</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>C2 Lama Berlangganan</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box table-responsive">
								<table class="table" cellspacing="0" width="100%" style="text-align: center">
									<thead>
										<tr>
											<th>Lama Berlangganan</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>>1 Tahun</td>
											<td>6</td>
										</tr>
										<tr>
											<td>8-10 Bulan</td>
											<td>5</td>
										</tr>
										<tr>
											<td>5-7 Bulan</td>
											<td>4</td>
										</tr>
										<tr>
											<td>3-4 Bulan</td>
											<td>3</td>
										</tr>
										<tr>
											<td>2 Bulan</td>
											<td>2</td>
										</tr>
										<tr>
											<td>1 Bulan</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>C3 Jumlah Pembayaran</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box table-responsive">
								<table class="table" cellspacing="0" width="100%" style="text-align: center">
									<thead>
										<tr>
											<th>Jumlah Pembayaran</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>10.000.000</td>
											<td>6</td>
										</tr>
										<tr>
											<td>8.000.000 - 9.000.000</td>
											<td>5</td>
										</tr>
										<tr>
											<td>6.000.000 - 7.000.000</td>
											<td>4</td>
										</tr>
										<tr>
											<td>4.000.000 - 5.000.000</td>
											<td>3</td>
										</tr>
										<tr>
											<td>2.000.000 - 3.000.000</td>
											<td>2</td>
										</tr>
										<tr>
											<td>1.000.000</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>C4 Riwayat Pembayaran</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box table-responsive">
								<table class="table" cellspacing="0" width="100%" style="text-align: center">
									<thead>
										<tr>
											<th>Riwayat Pembayaran</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Sangat Lancar</td>
											<td>5</td>
										</tr>
										<tr>
											<td>Lancar</td>
											<td>4</td>
										</tr>
										<tr>
											<td>Cukup Lancar</td>
											<td>3</td>
										</tr>
										<tr>
											<td>Tidak Lancar</td>
											<td>2</td>
										</tr>
										<tr>
											<td>Sangat Tidak Lancar</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
@endsection
