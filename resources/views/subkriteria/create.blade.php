@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form Tambah Sub Kriteria</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a onclick="goBack()">
							<i class="fa fa-close"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br>
				<form action="{{ route('subkriteria.store') }}" method="POST" enctype="multipart/form-data"
					class="form-label-left input_mask">
					@csrf
					<div class="form-group row">
						<div class="col-sm-6">
							<label for="kriteria_id">Kriteria:</label>
							<div class="form-group">
								<select class="form-control" id="kriteria_id" name="kriteria_id" required>
									<option value="" disabled selected>Pilih Kriteria</option>
									@foreach ($kriterias as $kriteria)
										<option value="{{ $kriteria->id }}" kode_kriteria="{{ $kriteria->kode }}">
											{{ $kriteria->nama }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<label for="kode_sub_kriteria">Kode Sub Kriteria:</label>
							<div class="form-group">
								<input required id="kode_sub_kriteria" placeholder="Kode Sub Kriteria" name="kode_sub_kriteria" type="text"
									class="form-control" readonly>
							</div>
						</div>
					</div>

					<h4>Keterangan</h4>
					<div id="keterangan-container">
						<div class="row keterangan-item">
							<div class="col-sm-6">
								<div class="form-group">
									<input required placeholder="Rentang" name="rentang[]" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<select class="form-control skor" name="skor[]" required>
										<option value=""></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="ln_solid"></div>

					<div class="form-group row">
						<div class="actionBar">
							<button id="add-keterangan" type="button" class="btn btn-primary">Tambah Keterangan</button>
							<button type="submit" class="btn btn-success">Simpan</button>

							{{-- <a href="#" class="buttonFinish buttonDisabled btn btn-default">Finish</a><a href="#"
								class="buttonNext btn btn-success">Next</a><a href="#"
								class="buttonPrevious buttonDisabled btn btn-primary">Previous</a> --}}
						</div>
						{{-- <div class="col-md-6 col-sm-6">

						</div>
						<div class="col-md-6 col-sm-6">
						</div> --}}
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-3"></div>
@endsection
@section('scripts')
	<script>
		document.getElementById('add-keterangan').addEventListener('click', function() {
			var container = document.getElementById('keterangan-container');

			var newKeterangan = document.createElement('div');
			newKeterangan.classList.add('row', 'keterangan-item');
			newKeterangan.innerHTML = `
        <div class="col-sm-6">
            <div class="form-group">
                <input required placeholder="Rentang" name="rentang[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <select class="form-control skor" name="skor[]" required>
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 text-right">
            <button type="button" class="btn btn-danger remove-keterangan">Hapus</button>
        </div>
    `;

			container.appendChild(newKeterangan);

			// Add event listener to the newly added remove button
			newKeterangan.querySelector('.remove-keterangan').addEventListener('click', function() {
				container.removeChild(newKeterangan);
			});
		});

		// Add event listener to existing remove buttons
		document.querySelectorAll('.remove-keterangan').forEach(function(button) {
			button.addEventListener('click', function() {
				var container = document.getElementById('keterangan-container');
				var keteranganItem = this.closest('.keterangan-item');
				container.removeChild(keteranganItem);
			});
		});
	</script>
	<script>
		document.getElementById('kriteria_id').addEventListener('change', function() {
			let selectedKriteria = this.options[this.selectedIndex];
			let kodeKriteria = selectedKriteria.getAttribute('kode_kriteria');

			// AJAX request to get the next available sub-kriteria code
			fetch(`/get-next-sub-kriteria/${kodeKriteria}`)
				.then(response => response.json())
				.then(data => {
					// Update the kode_sub_kriteria input field with the new value
					document.getElementById('kode_sub_kriteria').value = data.kode_sub_kriteria;
				})
				.catch(error => console.error('Error fetching sub-kriteria:', error));
		});
	</script>
	<script>
		function preventMinus(event) {
			if (event.key === '-' || event.keyCode === 45) {
				event.preventDefault();
			}
		}
	</script>
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
	<script>
		document.querySelectorAll('.skor').forEach(function(select) {
			select.addEventListener('change', function() {
				validateScores();
			});
		});

		function validateScores() {
			const scores = [];
			let valid = true;
			document.querySelectorAll('.skor').forEach(function(select) {
				const value = select.value;
				if (value !== '') {
					if (scores.includes(value)) {
						valid = false;
					}
					scores.push(value);
				}
			});

			if (!valid) {
				alert('Nilai skor tidak boleh sama.');
				document.querySelectorAll('.skor').forEach(function(select) {
					if (scores.filter(v => v === select.value).length > 1) {
						select.value = '';
					}
				});
			}
		}

		document.getElementById('form-skors').addEventListener('submit', function(event) {
			const scores = [];
			let valid = true;
			document.querySelectorAll('.skor').forEach(function(select) {
				const value = select.value;
				if (value !== '') {
					if (scores.includes(value)) {
						valid = false;
					}
					scores.push(value);
				}
			});

			if (!valid || scores.length !== 3) {
				alert('Nilai skor harus unik dan hanya boleh 1, 2, atau 3.');
				event.preventDefault(); // Mencegah form submit jika validasi gagal
			}
		});
	</script>
@endsection
