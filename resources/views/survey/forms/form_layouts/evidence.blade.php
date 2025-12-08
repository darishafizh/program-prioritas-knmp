                                                    <!-- File Upload -->
                                                    <form
                                                        action="{{ route('forms.store_bukti_upload', ['knmp' => $knmp->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf

                                                        {{-- class="dropzone"
                                                        id="myAwesomeDropzone" data-plugin="dropzone"
                                                        data-previews-container="#file-previews"
                                                        data-upload-preview-template="#uploadPreviewTemplate" --}}

                                                        <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

                                                        <div class="fallback">
                                                            <input name="file" type="file" multiple />
                                                        </div>

                                                        <div class="dz-message needsclick">
                                                            <i class="h1 text-muted dripicons-cloud-upload"></i>
                                                            <h3>Upload Bukti Pendukung</h3>
                                                            <p class="text-muted font-14">Jatuhkan berkas di sini
                                                                atau klik untuk mengunggah.</p>
                                                        </div>

                                                        <!-- Preview -->
                                                        <div class="dropzone-previews mt-3" id="file-previews"></div>

                                                        <!-- file preview template -->
                                                        <div class="d-none" id="uploadPreviewTemplate">
                                                            <div class="card mt-1 mb-0 shadow-none border">
                                                                <div class="p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-auto">
                                                                            <img data-dz-thumbnail src="#"
                                                                                class="avatar-sm rounded bg-light"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="col ps-0">
                                                                            <a href="javascript:void(0);"
                                                                                class="text-muted fw-bold"
                                                                                data-dz-name></a>
                                                                            <p class="mb-0" data-dz-size></p>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <!-- Button -->
                                                                            <a href=""
                                                                                class="btn btn-link btn-lg text-muted"
                                                                                data-dz-remove>
                                                                                <i class="dripicons-cross"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 justify-content-end d-flex">
                                                                <button type="submit"
                                                                    class="btn btn-primary m-2">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <script>
                                                        Dropzone.autoDiscover = false;

                                                        const dz = new Dropzone("#myAwesomeDropzone", {
                                                            url: "{{ route('forms.store_bukti_upload', ['knmp' => $knmp->id]) }}",
                                                            paramName: "file",
                                                            method: "post",
                                                            headers: {
                                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                                            },
                                                            uploadMultiple: false,
                                                            maxFilesize: 10,
                                                            acceptedFiles: "image/*"
                                                        });
                                                    </script>
