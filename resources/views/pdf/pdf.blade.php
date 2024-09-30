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

		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
		}

		th,
		td {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		th {
			background-color: #f2f2f2;
		}

		h1 {
			text-align: center;
			margin-bottom: 40px;
		}

		.section-title {
			font-size: 18px;
			margin-top: 20px;
		}
	</style>
</head>

<body>
	<h1>Hasil Penilaian TOPSIS</h1>

	<div class="section-title">Penilaian Data</div>
	<table>
		<thead>
			<tr>
				<th>ID Pelanggan</th>
				<th>Kriteria 1</th>
				<th>Kriteria 2</th>
				<th>Kriteria 3</th>
				<th>Kriteria 4</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($penilaianData as $id => $data)
				<tr>
					<td>{{ $data['pelanggan_id'] }}</td>
					@foreach ($data['kriteria'] as $kriteria)
						<td>{{ $kriteria['nilai'] }}</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="section-title">Matriks Terbobot</div>
	<table>
		<thead>
			<tr>
				<th>ID Pelanggan</th>
				<th>Kriteria 1</th>
				<th>Kriteria 2</th>
				<th>Kriteria 3</th>
				<th>Kriteria 4</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($matriksTerbobot as $id => $data)
				<tr>
					<td>{{ $data['pelanggan_id'] }}</td>
					@foreach ($data['kriteria'] as $kriteria)
						<td>{{ $kriteria['nilai_terbobot'] }}</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="section-title">Solusi Ideal Positif</div>
	<table>
		<thead>
			<tr>
				<th>Kriteria 1</th>
				<th>Kriteria 2</th>
				<th>Kriteria 3</th>
				<th>Kriteria 4</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				@foreach ($solusiIdealPositif as $nilai)
					<td>{{ $nilai }}</td>
				@endforeach
			</tr>
		</tbody>
	</table>

	<div class="section-title">Solusi Ideal Negatif</div>
	<table>
		<thead>
			<tr>
				<th>Kriteria 1</th>
				<th>Kriteria 2</th>
				<th>Kriteria 3</th>
				<th>Kriteria 4</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				@foreach ($solusiIdealNegatif as $nilai)
					<td>{{ $nilai }}</td>
				@endforeach
			</tr>
		</tbody>
	</table>

	<div class="section-title">Jarak Solusi</div>
	<table>
		<thead>
			<tr>
				<th>ID Pelanggan</th>
				<th>Jarak Positif</th>
				<th>Jarak Negatif</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($calculateJarakSolusi as $id => $data)
				<tr>
					<td>{{ $id }}</td>
					<td>{{ $data['jarakPositif'] }}</td>
					<td>{{ $data['jarakNegatif'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="section-title">Nilai Preferensi</div>
	<table>
		<thead>
			<tr>
				<th>ID Pelanggan</th>
				<th>Nilai Preferensi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($nilaiPreferensi as $id => $nilai)
				<tr>
					<td>{{ $id }}</td>
					<td>{{ $nilai }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>
