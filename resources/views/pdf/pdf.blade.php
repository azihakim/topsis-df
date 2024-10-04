<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hasil Penilaian TOPSIS</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
		}

		h1 {
			text-align: center;
			margin-bottom: 40px;
		}

		.section-title {
			font-size: 18px;
			margin-top: 20px;
		}

		/* Style tabel */
		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
			page-break-inside: avoid;
		}

		th,
		td {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		th {
			background-color: #f2f2f2;
			text-align: center;
		}

		thead {
			display: table-header-group;
		}

		tfoot {
			display: table-footer-group;
		}

		tr {
			page-break-inside: avoid;
		}

		@page {
			margin: 20px;
		}

		.page-title {
			display: block;
			text-align: center;
			font-size: 16px;
			font-weight: bold;
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<h1>Hasil Penilaian TOPSIS</h1>

	<!-- Section 1: Penilaian Data -->
	<div class="page-title">Penilaian Data</div>
	<table>
		<thead>
			<tr>
				<th>Nama Pelanggan</th>
				@if (isset($data['penilaianData']) && !empty($data['penilaianData']))
					@php
						// Extract kode_kriteria from the first penilaian
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
	<div class="page-title">Matriks Ternormalisasi</div>
	<table>
		<thead>
			<tr>
				<th>Nama Pelanggan</th>
				@if (isset($data['matriksTernormalisasi']) && !empty($data['matriksTernormalisasi']))
					@php
						// Extract kode_kriteria from the first matriks
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
	<!-- Section 2: Matriks Terbobot -->
	<div class="page-title">Matriks Terbobot</div>
	<table>
		<thead>
			<tr>
				<th>Nama Pelanggan</th>
				@if (isset($data['matriksTerbobot']) && !empty($data['matriksTerbobot']))
					@php
						// Extract kode_kriteria from the first matriks
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

	<!-- Section 3: Solusi Ideal Positif -->
	<div class="page-title">Solusi Ideal Positif</div>
	<table>
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

	<!-- Section 4: Solusi Ideal Negatif -->
	<div class="page-title">Solusi Ideal Negatif</div>
	<table>
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

	<!-- Section 5: Jarak Solusi -->
	<div class="page-title">Jarak Solusi</div>
	<table>
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

	<!-- Section 6: Nilai Preferensi -->
	<div class="page-title">Nilai Preferensi</div>
	<table>
		<thead>
			<tr>
				<th>Nama Pelanggan</th>
				<th>Nilai Preferensi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['nilaiPreferensiDenganNama'] as $preferensi)
				<tr>
					<td>{{ $preferensi['nama_pelanggan'] ?? 'N/A' }}</td>
					<td>{{ $preferensi['nilai_preferensi'] ?? 'N/A' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>
