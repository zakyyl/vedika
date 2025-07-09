            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title">Upload Berkas Digital</h3>
                    </div>
                    <div class="card-body">
                        @if ($readonly)
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Anda tidak memiliki akses untuk mengunggah resume.
                            </div>
                        @endif
                        <form action="{{ route('rawatinap.upload_resume', $data->no_rawat) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-wrap">
                                <div class="flex-grow-1" style="min-width: 300px; max-width: 100%;">
                                    <div class="form-group mb-3">
                                        <label>Nomor Rawat</label>
                                        <input type="text" class="form-control" value="{{ $data->no_rawat }}"
                                            readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Kategori Berkas <span class="text-danger">*</span></label>
                                        <select name="kode" class="form-control" {{ $readonly ? 'disabled' : '' }}
                                            required>

                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Pilih Berkas <small class="text-muted">(.pdf / .jpg)</small></label>
                                        <input type="file" name="file" class="form-control"
                                            accept=".pdf,.jpg,.jpeg" {{ $readonly ? 'disabled' : '' }} required>

                                        <small class="form-text text-muted">Format: PDF, JPG, JPEG</small>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-success"
                                            {{ $readonly ? 'disabled' : '' }}>Upload</button>

                                    </div>
                                </div>
                                <div id="preview-wrapper" class="ml-md-4 mt-4 mt-md-0 d-none" style="width: 800px;">
                                    <label class="mb-2">Preview Berkas</label>
                                    <div id="preview-container" class="border rounded p-2 bg-white">
                                        <iframe id="preview-pdf" class="w-100" style="height: 500px; display: none;"
                                            frameborder="0"></iframe>
                                        <img id="preview-image" class="img-fluid d-block mx-auto"
                                            style="max-height: 500px; display: none;" />
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const fileInput = document.querySelector('input[name="file"]');
                                const previewWrapper = document.getElementById('preview-wrapper');
                                const previewPdf = document.getElementById('preview-pdf');
                                const previewImage = document.getElementById('preview-image');
                                fileInput.addEventListener('change', function() {
                                    const file = this.files[0];
                                    if (!file) return;
                                    const fileURL = URL.createObjectURL(file);
                                    const fileType = file.type;
                                    previewWrapper.classList.remove('d-none');
                                    if (fileType === "application/pdf") {
                                        previewPdf.src = fileURL;
                                        previewPdf.style.display = "block";
                                        previewImage.style.display = "none";
                                    } else if (fileType.startsWith("image/")) {
                                        previewImage.src = fileURL;
                                        previewImage.style.display = "block";
                                        previewPdf.style.display = "none";
                                    } else {
                                        previewPdf.style.display = "none";
                                        previewImage.style.display = "none";
                                        previewWrapper.classList.add('d-none');
                                        alert("Format tidak didukung. Hanya PDF dan JPG/JPEG.");
                                    }
                                });
                            });
                        </script>
                        <div id="accordionResume" class="mt-4">
                            <div class="card border">
                                <div class="card-header p-2" id="headingResume">
                                    <h5 class="mb-0">
                                        <button
                                            class="btn btn-link collapsed w-100 text-left d-flex justify-content-between align-items-center text-dark"
                                            data-toggle="collapse" data-target="#collapseResume" aria-expanded="false">
                                            <span>Berkas Terunggah</span>
                                            <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseResume" class="collapse" data-parent="#accordionResume">
                                    <div class="card-body">
                                        @if (count($berkas) > 0)
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kategori</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($berkas as $i => $file)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $file->nama_kategori }}</td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    data-toggle="modal" data-target="#modalPreview"
                                                                    data-file="{{ config('app.webapps_url') . '/' . $file->lokasi_file }}"
                                                                    data-type="{{ strtolower(pathinfo($file->lokasi_file, PATHINFO_EXTENSION)) }}"
                                                                    data-kategori="{{ $file->nama_kategori }}">
                                                                    Lihat File
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-muted mb-0">Belum ada berkas yang diupload.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="previewLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title" id="previewLabel">Preview Berkas</h5>
                                            <small id="previewKategori" class="text-muted d-block"></small>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center bg-light">
                                        <iframe id="modal-pdf" class="w-100" style="height: 600px; display: none;"
                                            frameborder="0"></iframe>
                                        <img id="modal-image" class="img-fluid"
                                            style="max-height: 600px; display: none;" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script>
                            $('#modalPreview').on('show.bs.modal', function(event) {
                                const button = $(event.relatedTarget);
                                const fileUrl = button.data('file');
                                const fileType = button.data('type').toLowerCase();

                                const iframe = $('#modal-pdf');
                                const image = $('#modal-image');

                                if (fileType === 'pdf') {
                                    iframe.attr('src', fileUrl).show();
                                    image.hide();
                                } else if (['jpg', 'jpeg', 'png'].includes(fileType)) {
                                    image.attr('src', fileUrl).show();
                                    iframe.hide();
                                } else {
                                    iframe.hide();
                                    image.hide();
                                    alert('Preview tidak tersedia untuk tipe ini.');
                                }
                            });

                            $('#modalPreview').on('hidden.bs.modal', function() {
                                $('#modal-pdf').attr('src', '').hide();
                                $('#modal-image').attr('src', '').hide();
                            });
                        </script>
                    </div>
                </div>
            </div>
            @section('scripts')
                <script>
                    $('#modalPreview').on('show.bs.modal', function(event) {
                        const button = $(event.relatedTarget);
                        const fileUrl = button.data('file');
                        const fileType = button.data('type')?.toLowerCase();
                        const kategori = button.data('kategori');

                        const iframe = $('#modal-pdf');
                        const image = $('#modal-image');
                        const labelKategori = $('#previewKategori');

                        // Tampilkan kategori di modal
                        if (kategori) {
                            labelKategori.text('Kategori: ' + kategori);
                        } else {
                            labelKategori.text('');
                        }

                        // Preview PDF atau Gambar
                        if (fileType === 'pdf') {
                            iframe.attr('src', fileUrl).show();
                            image.hide();
                        } else if (['jpg', 'jpeg', 'png'].includes(fileType)) {
                            image.attr('src', fileUrl).show();
                            iframe.hide();
                        } else {
                            iframe.hide();
                            image.hide();
                            labelKategori.text('');
                            alert('Preview tidak tersedia untuk tipe file ini.');
                        }
                    });

                    $('#modalPreview').on('hidden.bs.modal', function() {
                        $('#modal-pdf').attr('src', '').hide();
                        $('#modal-image').attr('src', '').hide();
                        $('#previewKategori').text('');
                    });
                </script>
            @endsection
