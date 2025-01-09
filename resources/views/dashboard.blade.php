@extends('master')

@section('styles')
	<style>
		hr.vertical-line {
			height: 100px;
			/* Atur tinggi garis vertikal */
			margin: 0 20px;
			/* Sesuaikan jarak dari elemen sebelumnya */
			border-left: 1px solid black;
			/* Atur warna dan ketebalan garis sesuai kebutuhan */
		}
	</style>
	<style>
		.formula-table {
			width: 100%;
			border-collapse: collapse;
		}

		.formula-table th,
		.formula-table td {
			border: 1px solid black;
			padding: 10px;
			text-align: center;
		}

		.formula-table th {
			background-color: #8CC152;
			color: white;
		}

		.formula-table .highlight {
			background-color: #E6E6E6;
		}
	</style>
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
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">
							<div class="text-center">
								<h1>Sistem Pendukung Keputusan</h1>
								<img src="{{ asset('vendors/img/logo.png') }}" style="width: 150px">
								<div class="row justify-content-center" style="text-align: center">
									<div class="col-md-12">
										<div class="card border-0">
											<div class="card-body">
												<h2> VISI </h2>
												<div class="d-flex justify-content-center">
													<h4>“VISI PERUSAHAAN YAITU MEMBUAT PERUSAHAAN SELALU BERKEMBANG DAN MEMBERIKAN
														PELAYANAN YANG TERBAIK SERTA MENYEDIAKAN PRODUK BERKUALITAS DENGAN HARGA TERBAIK” </h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row justify-content-center" style="text-align: center">
									<div class="col-md-12">
										<div class="card border-0">
											<div class="card-body">
												<h2> MISI </h2>
												<div class="d-flex justify-content-center">
													<h4>“MISI MENCAPAI PERTUMBUHAN YANG BERKELANJUTAN DENGAN KINERJA UNGGUL, MENGHASILKAN LAYANAN BERKUALITAS
														DAN NILAI TAMBAH YANG MAKSIMAL KEPADA KONSUMEN SERTA PEMANGKU KEPENTINGAN MELALUI PRODUK-PRODUK INOVATIF
														DAN SOLUSI YANG EFEKTIF” </h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
