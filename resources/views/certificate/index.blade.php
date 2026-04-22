@extends('layouts.app')

@section('title', 'Generator Sertifikat')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<style>
    :root {
        --navy: #0F1E3C; --navy-mid: #1a3260; --gold: #C9A84C; --gold-light: #E8D48B;
    }

    /* ---- PANEL ---- */
    .gen-panel {
        background: #fff;
        border: 1px solid #dde4f0;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(15,30,60,0.05);
    }
    .gen-panel-title {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--navy-mid);
        border-bottom: 2px solid var(--gold);
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ---- FORM CONTROLS ---- */
    .form-label-sm {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 5px;
        display: block;
    }
    .form-control, .form-select {
        border: 1.5px solid #dde4f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1a1a2e;
        transition: border-color .2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--navy-mid);
        box-shadow: 0 0 0 3px rgba(26,50,96,0.08);
    }

    /* ---- UPLOAD IMAGE BOX ---- */
    .img-upload-box {
        border: 2px dashed #dde4f0;
        border-radius: 10px;
        padding: 16px 10px;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #f9fbff;
        position: relative;
        min-height: 110px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .img-upload-box:hover { border-color: var(--navy-mid); background: #f0f4ff; }
    .img-upload-box input[type=file] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .img-upload-box .upload-icon { font-size: 1.6rem; margin-bottom: 4px; }
    .img-upload-box p { font-size: 0.72rem; color: #9ca3af; line-height: 1.5; margin: 0; }
    .img-upload-box p strong { color: var(--navy-mid); display: block; }
    .img-upload-box .thumb { width: 52px; height: 52px; object-fit: contain; border-radius: 6px; }
    .upload-badge {
        position: absolute; top: 6px; right: 6px;
        background: #dcfce7; color: #16a34a;
        font-size: 0.6rem; padding: 2px 6px;
        border-radius: 10px; letter-spacing: 1px; font-weight: 700;
    }

    /* ---- OPACITY SLIDER ---- */
    .opacity-badge {
        font-size: 0.72rem;
        font-weight: 700;
        color: #fff;
        background: var(--navy);
        padding: 2px 8px;
        border-radius: 20px;
        min-width: 42px;
        text-align: center;
        letter-spacing: 0.5px;
        transition: background .2s;
        display: inline-block;
    }

    /* Wrapper slider dengan fill bar */
    .opacity-slider-wrap {
        position: relative;
        margin: 6px 0 2px;
        height: 20px;
        display: flex;
        align-items: center;
    }
    /* Track background abu */
    .opacity-slider-wrap::before {
        content: '';
        position: absolute;
        left: 0; right: 0;
        height: 5px;
        background: #e2e8f0;
        border-radius: 10px;
        pointer-events: none;
    }
    /* Fill bar berwarna (lebar diset via JS) */
    .opacity-fill {
        position: absolute;
        left: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--navy-mid), var(--navy));
        border-radius: 10px;
        pointer-events: none;
        transition: width .1s, background .2s;
    }
    /* Slider itu sendiri — transparan supaya track custom kelihatan */
    .opacity-range {
        position: relative;
        width: 100%;
        height: 20px;
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        margin: 0;
        z-index: 1;
    }
    .opacity-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--navy);
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(15,30,60,0.3);
        cursor: pointer;
        transition: transform .15s, background .2s;
    }
    .opacity-range::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        background: var(--navy-mid);
    }
    .opacity-range::-moz-range-thumb {
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--navy);
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(15,30,60,0.3);
        cursor: pointer;
    }
    .opacity-track-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.6rem;
        color: #cbd5e1;
        margin-top: 0;
        padding: 0 2px;
    }

    /* ---- NUMBERING ---- */
    .num-preview {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        color: var(--gold-light);
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        letter-spacing: 3px;
        margin-top: 12px;
    }

    /* ---- SEGMENT BUILDER ---- */
    .btn-add-seg {
        background: var(--navy);
        color: var(--gold-light);
        border: none;
        border-radius: 7px;
        padding: 5px 12px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: 1px;
        transition: all .2s;
    }
    .btn-add-seg:hover { background: var(--navy-mid); }

    /* Setiap baris segmen */
    .seg-row {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f9fbff;
        border: 1.5px solid #dde4f0;
        border-radius: 8px;
        padding: 6px 8px;
        margin-bottom: 6px;
        cursor: grab;
        transition: border-color .2s, box-shadow .2s;
    }
    .seg-row:active { cursor: grabbing; }
    .seg-row.dragging {
        opacity: 0.5;
        border-color: var(--navy-mid);
    }
    .seg-row.drag-over {
        border-color: var(--gold);
        box-shadow: 0 0 0 2px rgba(201,168,76,0.25);
    }
    .seg-handle {
        color: #ccc;
        font-size: 1rem;
        cursor: grab;
        padding: 0 2px;
        flex-shrink: 0;
    }
    .seg-type {
        border: 1.5px solid #dde4f0;
        border-radius: 6px;
        font-size: 0.75rem;
        padding: 4px 6px;
        background: #fff;
        color: var(--navy);
        font-weight: 600;
        width: 110px;
        flex-shrink: 0;
    }
    .seg-type:focus { border-color: var(--navy-mid); outline: none; }
    .seg-value {
        border: 1.5px solid #dde4f0;
        border-radius: 6px;
        font-size: 0.8rem;
        padding: 4px 8px;
        background: #fff;
        flex: 1;
        min-width: 0;
    }
    .seg-value:focus { border-color: var(--navy-mid); outline: none; }
    .seg-value:disabled {
        background: #f0f4ff;
        color: #9ca3af;
    }
    .seg-delete {
        background: none;
        border: none;
        color: #f87171;
        font-size: 1rem;
        cursor: pointer;
        padding: 0 2px;
        flex-shrink: 0;
        line-height: 1;
        opacity: 0.7;
        transition: opacity .2s;
    }
    .seg-delete:hover { opacity: 1; }

    /* Separator buttons */
    .btn-sep {
        background: #f0f4ff;
        border: 1.5px solid #dde4f0;
        border-radius: 6px;
        color: var(--navy);
        font-size: 0.85rem;
        font-weight: 700;
        width: 36px; height: 32px;
        cursor: pointer;
        transition: all .2s;
        flex-shrink: 0;
    }
    .btn-sep:hover { border-color: var(--navy-mid); }
    .btn-sep.active {
        background: var(--navy);
        color: var(--gold-light);
        border-color: var(--navy);
    }

    /* ---- TABS ---- */
    .gen-tabs { border: none; margin-bottom: 20px; gap: 8px; }
    .gen-tabs .nav-link {
        border: 1.5px solid #dde4f0;
        border-radius: 8px;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 8px 18px;
        transition: all .2s;
    }
    .gen-tabs .nav-link.active {
        background: var(--navy);
        border-color: var(--navy);
        color: var(--gold-light);
    }
    .gen-tabs .nav-link:hover:not(.active) {
        border-color: var(--navy-mid);
        color: var(--navy-mid);
    }

    /* ---- UPLOAD FILE AREA ---- */
    .file-drop-zone {
        border: 2px dashed #dde4f0;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        background: #f9fbff;
        position: relative;
    }
    .file-drop-zone:hover { border-color: var(--navy-mid); background: #f0f4ff; }
    .file-drop-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

    /* ---- BTN GENERATE ---- */
    .btn-generate {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        width: 100%;
        transition: all .2s;
        margin-top: 8px;
    }
    .btn-generate:hover { opacity: 0.9; transform: translateY(-1px); color: var(--gold-light); }
    .btn-generate:disabled { opacity: 0.35; cursor: not-allowed; transform: none; }

    /* ---- CSV PREVIEW ---- */
    .csv-preview {
        max-height: 160px;
        overflow-y: auto;
        background: #f9fbff;
        border: 1px solid #dde4f0;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 0.78rem;
    }
    .csv-preview table { margin: 0; }
    .csv-preview th { background: var(--navy); color: var(--gold-light); font-size: 0.72rem; }

    /* ---- RESULTS GRID ---- */
    #results { margin-top: 32px; }
    .result-header {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        color: var(--navy);
        text-align: center;
        margin-bottom: 20px;
    }
    .cert-card {
        background: #fff;
        border: 1px solid #dde4f0;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(15,30,60,0.06);
    }
    .cert-card canvas { width: 100%; border-radius: 6px; display: block; }
    .cert-card .cert-card-name {
        font-size: 0.8rem;
        color: var(--navy-mid);
        font-weight: 600;
        margin: 8px 0 6px;
        text-align: center;
    }
    .btn-dl {
        background: var(--navy);
        color: var(--gold-light);
        border: none;
        border-radius: 7px;
        padding: 7px;
        font-size: 0.75rem;
        font-weight: 700;
        width: 100%;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all .2s;
    }
    .btn-dl:hover { background: var(--navy-mid); }

    /* ---- BTN DOWNLOAD ALL ---- */
    .btn-download-all {
        background: linear-gradient(135deg, #16a34a 0%, #0d6b32 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 13px 24px;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 2px;
        width: 100%;
        margin-top: 16px;
        cursor: pointer;
        transition: opacity .2s;
        display: none;
    }
    .btn-download-all:hover { opacity: 0.88; }

    /* ---- MULTI PESERTA MANUAL ---- */
    .peserta-card {
        background: #f9fbff;
        border: 1.5px solid #dde4f0;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 10px;
        position: relative;
        transition: border-color .2s;
    }
    .peserta-card:focus-within { border-color: var(--navy-mid); }
    .peserta-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .peserta-num {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--navy-mid);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .peserta-num .num-badge {
        background: var(--navy);
        color: var(--gold-light);
        width: 20px; height: 20px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.68rem; font-weight: 700;
    }
    .btn-del-peserta {
        background: none;
        border: none;
        color: #f87171;
        font-size: 1rem;
        cursor: pointer;
        padding: 2px 4px;
        border-radius: 5px;
        opacity: 0.7;
        transition: opacity .2s, background .2s;
        line-height: 1;
    }
    .btn-del-peserta:hover { opacity: 1; background: #fee2e2; }

    .btn-add-peserta {
        background: #f0f4ff;
        border: 1.5px dashed #a5b4fc;
        border-radius: 8px;
        color: var(--navy-mid);
        font-size: 0.78rem;
        font-weight: 700;
        padding: 7px 14px;
        cursor: pointer;
        transition: all .2s;
        letter-spacing: 0.5px;
    }
    .btn-add-peserta:hover {
        background: var(--navy);
        border-color: var(--navy);
        color: var(--gold-light);
    }
    .btn-add-peserta:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f0f4ff;
        border-color: #dde4f0;
        color: #9ca3af;
    }
    .btn-sm-danger-outline {
        background: #fff0f0;
        border: 1.5px solid #fca5a5;
        color: #b91c1c;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all .2s;
    }
    .btn-sm-danger-outline:hover { background: #fee2e2; border-color: #f87171; }

    /* ---- TOGGLE BAHASA ---- */
    .btn-lang {
        flex: 1;
        padding: 8px 12px;
        border: 1.5px solid #dde4f0;
        border-radius: 8px;
        background: #f9fbff;
        color: #6b7280;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        letter-spacing: 0.5px;
    }
    .btn-lang:hover { border-color: var(--navy-mid); color: var(--navy-mid); }
    .btn-lang.active {
        background: var(--navy);
        border-color: var(--navy);
        color: var(--gold-light);
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold" style="color:var(--navy)">
            <i class="bi bi-award me-2" style="color:var(--gold)"></i>Generator Sertifikat
        </h4>
        <small class="text-muted">
            {{ auth()->user()->institution->name ?? 'Lembaga Anda' }}
        </small>
    </div>
</div>

<div class="row g-4">
{{-- ════ KOLOM KIRI: PENGATURAN ════ --}}
<div class="col-lg-5">

    {{-- Panel 1: Pengaturan --}}
    <div class="gen-panel">
        <div class="gen-panel-title">⚙ Pengaturan Sertifikat</div>

        {{-- Toggle Bahasa --}}
        <div class="mb-3">
            <label class="form-label-sm">Bahasa Sertifikat</label>
            <div class="d-flex gap-2">
                <button type="button" id="btnLangID" onclick="setLang('id')"
                        class="btn-lang active">🇮🇩 Indonesia</button>
                <button type="button" id="btnLangEN" onclick="setLang('en')"
                        class="btn-lang">🇬🇧 English</button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label-sm">Nama Acara / Kegiatan</label>
            <input type="text" class="form-control" id="eventName" value="Pelatihan Pengembangan Kompetensi">
        </div>
        <div class="mb-3">
            <label class="form-label-sm">Tempat Pelaksanaan</label>
            <input type="text" class="form-control" id="eventPlace" placeholder="Contoh: Purwokerto" value="Purwokerto">
        </div>
        <div class="mb-3">
            <label class="form-label-sm d-flex align-items-center justify-content-between">
                <span>Tanggal Pelaksanaan</span>
                <div class="form-check form-switch mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="multiDayToggle" onchange="toggleMultiDay()">
                    <label class="form-check-label" for="multiDayToggle"
                           style="font-size:0.68rem;color:#9ca3af;letter-spacing:0;text-transform:none;font-weight:400">
                        Beberapa hari
                    </label>
                </div>
            </label>
            <div id="singleDayInput">
                <input type="date" class="form-control" id="dateStart" onchange="updateDatePreview()">
            </div>
            <div id="multiDayInput" class="d-none">
                <div class="row g-2">
                    <div class="col-6">
                        <input type="date" class="form-control" id="dateFrom" onchange="updateDatePreview()">
                        <div class="form-text" style="font-size:0.68rem">Dari</div>
                    </div>
                    <div class="col-6">
                        <input type="date" class="form-control" id="dateTo" onchange="updateDatePreview()">
                        <div class="form-text" style="font-size:0.68rem">Sampai</div>
                    </div>
                </div>
            </div>
            <div id="datePreview" class="mt-2 px-2 py-1 rounded"
                 style="font-size:0.8rem;color:var(--navy-mid);background:#f0f4ff;border:1px solid #dde4f0;display:none">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label-sm">Institusi / Lembaga</label>
            <input type="text" class="form-control" id="institution"
                   value="{{ auth()->user()->institution->name ?? '' }}">
        </div>
        {{-- desc otomatis dari pilihan bahasa, tidak perlu input manual --}}
        <div class="row g-2">
            <div class="col-6">
                <label class="form-label-sm">Nama Penandatangan</label>
                <input type="text" class="form-control" id="signerName" value="Dr. Ahmad Fauzi, M.Pd.">
            </div>
            <div class="col-6">
                <label class="form-label-sm">Jabatan Penandatangan</label>
                <input type="text" class="form-control" id="signerTitle" value="Ketua Panitia">
            </div>
        </div>
    </div>

    {{-- Panel 2: TTD, Cap, Logo --}}
    <div class="gen-panel">
        <div class="gen-panel-title">🖊 Tanda Tangan, Cap & Logo</div>
        <div class="row g-2 mb-3">
            <div class="col-4">
                <label class="form-label-sm">Tanda Tangan</label>
                <div class="img-upload-box">
                    <input type="file" accept="image/*" onchange="loadImg(event,'ttd')">
                    <div id="ttdPreview">
                        <div class="upload-icon">✍</div>
                        <p><strong>Upload TTD</strong>PNG transparan</p>
                    </div>
                    <span class="upload-badge d-none" id="ttdBadge">✓ OK</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 mb-1">
                    <label class="form-label-sm mb-0">Opasitas</label>
                    <span id="ttdOpacityVal" class="opacity-badge">100%</span>
                </div>
                <div class="opacity-slider-wrap">
                    <div class="opacity-fill" id="ttdOpacityFill" style="width:100%"></div>
                    <input type="range" id="ttdOpacity" min="0.2" max="1" step="0.05" value="1"
                           class="opacity-range"
                           oninput="updateOpacity('ttd', this.value)">
                </div>
                <div class="opacity-track-labels">
                    <span>20%</span><span>60%</span><span>100%</span>
                </div>
            </div>
            <div class="col-4">
                <label class="form-label-sm">Cap / Stempel</label>
                <div class="img-upload-box">
                    <input type="file" accept="image/*" onchange="loadImg(event,'cap')">
                    <div id="capPreview">
                        <div class="upload-icon">🔴</div>
                        <p><strong>Upload Cap</strong>PNG transparan</p>
                    </div>
                    <span class="upload-badge d-none" id="capBadge">✓ OK</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 mb-1">
                    <label class="form-label-sm mb-0">Opasitas</label>
                    <span id="capOpacityVal" class="opacity-badge">75%</span>
                </div>
                <div class="opacity-slider-wrap">
                    <div class="opacity-fill" id="capOpacityFill" style="width:68.75%"></div>
                    <input type="range" id="capOpacity" min="0.2" max="1" step="0.05" value="0.75"
                           class="opacity-range"
                           oninput="updateOpacity('cap', this.value)">
                </div>
                <div class="opacity-track-labels">
                    <span>20%</span><span>60%</span><span>100%</span>
                </div>
            </div>
            <div class="col-4">
                <label class="form-label-sm">Logo Institusi</label>
                <div class="img-upload-box">
                    <input type="file" accept="image/*" onchange="loadImg(event,'logo')">
                    <div id="logoPreview">
                        <div class="upload-icon">🏛</div>
                        <p><strong>Upload Logo</strong>Tampil di atas</p>
                    </div>
                    <span class="upload-badge d-none" id="logoBadge">✓ OK</span>
                </div>
            </div>
        </div>
        {{-- Background custom --}}
        <div class="mt-2 mb-1">
            <label class="form-label-sm">
                Background Sertifikat
                <span style="text-transform:none;letter-spacing:0;font-size:0.68rem;color:#9ca3af;font-weight:400"> — opsional, default digunakan jika kosong</span>
            </label>
            <div class="d-flex align-items-center gap-3">
                <div class="img-upload-box" style="min-height:70px;flex:1;padding:10px">
                    <input type="file" accept=".jpg,.jpeg,.png" onchange="loadBackground(event)" id="bgFileInput">
                    <div id="bgPreview">
                        <div class="upload-icon" style="font-size:1.2rem">🖼</div>
                        <p><strong>Upload Background</strong>JPG / PNG, maks. 5MB</p>
                    </div>
                    <span class="upload-badge d-none" id="bgBadge">✓ OK</span>
                </div>
                <button type="button" onclick="removeBackground()" id="btnRemoveBg"
                        class="d-none btn-sm-danger-outline">
                    <i class="bi bi-x-circle me-1"></i>Hapus BG
                </button>
            </div>
            <div id="bgError" class="mt-1 d-none" style="font-size:0.75rem;color:#b91c1c"></div>
        </div>

        <div class="row g-2 p-2" style="background:#f9fbff; border-radius:8px; border:1px solid #eee;">
            <div class="col-4">
                <label class="form-label-sm">Posisi TTD</label>
                <select class="form-select form-select-sm" id="ttdPos">
                    <option value="left">Kiri</option>
                    <option value="center" selected>Tengah</option>
                    <option value="right">Kanan</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label-sm">Posisi Cap</label>
                <select class="form-select form-select-sm" id="capPos">
                    <option value="left">Kiri</option>
                    <option value="center">Tengah</option>
                    <option value="right" selected>Kanan</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label-sm">Ukuran TTD/Cap</label>
                <select class="form-select form-select-sm" id="ttdSize">
                    <option value="sm">Kecil</option>
                    <option value="md" selected>Sedang</option>
                    <option value="lg">Besar</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Panel 3: Numbering --}}
    <div class="gen-panel">
        <div class="gen-panel-title">🔢 Auto Numbering</div>

        {{-- Header segmen --}}
        <div class="d-flex align-items-center justify-content-between mb-2">
            <label class="form-label-sm mb-0">Segmen Nomor</label>
            <button type="button" onclick="addSegment()" class="btn-add-seg">
                <i class="bi bi-plus-lg me-1"></i>Tambah Segmen
            </button>
        </div>

        {{-- Daftar segmen (drag & drop) --}}
        <div id="segmentList"></div>

        {{-- Separator --}}
        <div class="mt-3 mb-2">
            <label class="form-label-sm">Pemisah antar segmen</label>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn-sep active" data-sep="/" onclick="setSep('/', this)">/</button>
                <button type="button" class="btn-sep" data-sep="-" onclick="setSep('-', this)">-</button>
                <button type="button" class="btn-sep" data-sep="." onclick="setSep('.', this)">.</button>
                <button type="button" class="btn-sep" data-sep="_" onclick="setSep('_', this)">_</button>
                <div class="d-flex align-items-center gap-1 ms-1">
                    <span style="font-size:0.7rem;color:#aaa">lain:</span>
                    <input type="text" id="customSep" maxlength="3" placeholder="..."
                           class="form-control form-control-sm" style="width:60px"
                           oninput="setSepCustom(this.value)">
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div class="num-preview" id="numPreview">CERT/001/2026</div>
        <p class="text-muted mt-2 mb-0" style="font-size:0.7rem; text-align:center;">
            <i class="bi bi-info-circle me-1"></i>Urutan segmen = urutan di sertifikat. Drag ☰ untuk ubah urutan.
        </p>
    </div>

</div>

{{-- ════ KOLOM KANAN: DATA PESERTA ════ --}}
<div class="col-lg-7">

    <div class="gen-panel">
        <div class="gen-panel-title">👤 Data Peserta</div>

        {{-- Tabs --}}
        <ul class="nav gen-tabs">
            <li class="nav-item">
                <button class="nav-link active" onclick="switchTab('manual', this)">✏ Input Manual</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" onclick="switchTab('upload', this)">📂 Upload Excel/CSV</button>
            </li>
        </ul>

        {{-- TAB MANUAL --}}
        <div id="tabManual">
            {{-- Daftar peserta manual --}}
            <div id="manualPesertaList"></div>

            {{-- Tombol tambah peserta --}}
            <div class="d-flex align-items-center gap-2 mb-3" id="addPesertaWrap">
                <button type="button" class="btn-add-peserta" id="btnAddPeserta" onclick="addPeserta()">
                    <i class="bi bi-person-plus me-1"></i>Tambah Peserta
                </button>
                <span class="text-muted" id="pesertaCount" style="font-size:0.75rem"></span>
            </div>

            {{-- Info lebih dari 4 --}}
            <div id="infoMaxPeserta" class="d-none mb-3 px-3 py-2 rounded"
                 style="background:#fffbeb;border:1px solid #fde68a;font-size:0.8rem;color:#92400e;">
                <i class="bi bi-info-circle me-1"></i>
                Maksimal 4 peserta untuk input manual.
                Untuk lebih, gunakan <button onclick="switchTab('upload', document.querySelectorAll('.gen-tabs .nav-link')[1])"
                    style="background:none;border:none;color:#b45309;font-weight:700;cursor:pointer;padding:0;text-decoration:underline">
                    Upload Excel/CSV</button>.
            </div>

            <button class="btn-generate" onclick="generateManual()">
                ✦ Generate Sertifikat
            </button>
        </div>

        {{-- TAB UPLOAD --}}
        <div id="tabUpload" class="d-none">
            <div class="file-drop-zone mb-3">
                <input type="file" id="fileInput" accept=".xlsx,.xls,.csv" onchange="handleFile(event)">
                <div style="font-size:2rem; margin-bottom:8px">📁</div>
                <p class="mb-1"><strong>Klik atau drag file di sini</strong></p>
                <p class="text-muted" style="font-size:0.8rem">Format: Excel (.xlsx/.xls) atau CSV</p>
                <p class="mt-2" style="font-size:0.72rem; color:#aaa">
                    Kolom wajib: <strong style="color:var(--navy-mid)">nama</strong> &middot;
                    Opsional: <strong style="color:var(--navy-mid)">perusahaan</strong>, <strong style="color:var(--navy-mid)">nomor</strong>
                </p>
            </div>
            <div id="previewTable"></div>
            <p class="text-muted" style="font-size:0.78rem" id="fileInfo"></p>
            <button class="btn-generate" id="btnGenAll" disabled onclick="generateAll()">
                ✦ Generate Semua Sertifikat
            </button>
        </div>
    </div>

    {{-- HASIL --}}
    <div id="results" class="d-none">
        <div class="result-header">✦ Hasil Sertifikat</div>
        <div class="row g-3" id="certGrid"></div>
        <button class="btn-download-all" id="btnDownloadAll" onclick="downloadAllCerts()">
            <i class="bi bi-download me-2"></i>Download Semua (ZIP)
        </button>
    </div>

</div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================
// STATE
// ============================================================
let parsedData = [];
let generatedCanvases = [];
const imgs = { ttd: null, cap: null, logo: null, bg: null };

// ============================================================
// OPACITY SLIDER
// ============================================================
function updateOpacity(key, val) {
    const pct = Math.round(parseFloat(val) * 100);

    // Update badge teks
    const badge = document.getElementById(key + 'OpacityVal');
    badge.textContent = pct + '%';

    // Warna badge berubah sesuai nilai
    if (pct <= 40) {
        badge.style.background = '#94a3b8';
    } else if (pct <= 70) {
        badge.style.background = '#1a3260';
    } else {
        badge.style.background = '#0F1E3C';
    }

    // Update fill bar — range min=0.2 max=1.0, jadi 0% fill = 0.2, 100% fill = 1.0
    const fill = document.getElementById(key + 'OpacityFill');
    if (fill) {
        const min = 0.2, max = 1.0;
        const fillPct = ((parseFloat(val) - min) / (max - min)) * 100;
        fill.style.width = fillPct + '%';

        // Warna fill: abu kalau transparan, navy kalau penuh
        if (pct <= 40) {
            fill.style.background = 'linear-gradient(90deg, #94a3b8, #cbd5e1)';
        } else if (pct <= 70) {
            fill.style.background = 'linear-gradient(90deg, #1a3260, #2a4a8a)';
        } else {
            fill.style.background = 'linear-gradient(90deg, #0F1E3C, #1a3260)';
        }
    }
}

// ============================================================
// IMAGE UPLOAD
// ============================================================
function loadImg(e, key) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        const img = new Image();
        img.onload = () => {
            imgs[key] = img;
            const prev = document.getElementById(key + 'Preview');
            prev.innerHTML = `<img src="${ev.target.result}" class="thumb" style="max-height:56px;max-width:100%;border-radius:6px">`;
            document.getElementById(key + 'Badge').classList.remove('d-none');
        };
        img.src = ev.target.result;
    };
    reader.readAsDataURL(file);
}

// ============================================================
// BACKGROUND UPLOAD
// ============================================================
const BG_MAX_MB = 5;
const BG_ALLOWED = ['image/jpeg', 'image/jpg', 'image/png'];

function loadBackground(e) {
    const file = e.target.files[0];
    if (!file) return;

    const errEl = document.getElementById('bgError');
    errEl.classList.add('d-none');

    // Validasi tipe
    if (!BG_ALLOWED.includes(file.type)) {
        errEl.textContent = '✕ Format tidak didukung. Gunakan JPG atau PNG.';
        errEl.classList.remove('d-none');
        e.target.value = '';
        return;
    }

    // Validasi ukuran (maks 5MB)
    if (file.size > BG_MAX_MB * 1024 * 1024) {
        errEl.textContent = '✕ Ukuran file terlalu besar. Maksimal ' + BG_MAX_MB + 'MB.';
        errEl.classList.remove('d-none');
        e.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = ev => {
        const img = new Image();
        img.onload = () => {
            imgs.bg = img;

            // Tampilkan thumbnail
            const prev = document.getElementById('bgPreview');
            prev.innerHTML = `<img src="${ev.target.result}"
                style="max-height:52px;max-width:100%;border-radius:5px;object-fit:cover">`;
            document.getElementById('bgBadge').classList.remove('d-none');
            document.getElementById('btnRemoveBg').classList.remove('d-none');

            // Info dimensi
            const kb = Math.round(file.size / 1024);
            errEl.textContent = `✓ ${img.width}×${img.height}px · ${kb}KB`;
            errEl.style.color = '#16a34a';
            errEl.classList.remove('d-none');
        };
        img.src = ev.target.result;
    };
    reader.readAsDataURL(file);
}

function removeBackground() {
    imgs.bg = null;
    document.getElementById('bgFileInput').value = '';
    document.getElementById('bgPreview').innerHTML = `
        <div class="upload-icon" style="font-size:1.2rem">🖼</div>
        <p><strong>Upload Background</strong>JPG / PNG, maks. 5MB</p>`;
    document.getElementById('bgBadge').classList.add('d-none');
    document.getElementById('btnRemoveBg').classList.add('d-none');
    const errEl = document.getElementById('bgError');
    errEl.classList.add('d-none');
    errEl.style.color = '#b91c1c';
}

// ============================================================
// NUMBERING — SEGMENT BUILDER
// ============================================================
let segments = [
    { type: 'teks',   value: 'CERT' },
    { type: 'nomor',  value: '001'  },
    { type: 'tahun',  value: '{{ date("Y") }}' },
];
let separator = '/';
let dragSrcIdx = null;

const SEG_TYPES = {
    teks:  { label: 'Teks / Kode', placeholder: 'Contoh: CERT, LP, SK', auto: false },
    nomor: { label: 'Nomor Urut',  placeholder: 'Mulai dari: 001',       auto: true  },
    tahun: { label: 'Tahun',       placeholder: 'Contoh: 2026',          auto: false },
    bulan: { label: 'Bulan',       placeholder: 'Otomatis bulan ini',     auto: true  },
};

function renderSegments() {
    const list = document.getElementById('segmentList');
    list.innerHTML = '';

    segments.forEach((seg, i) => {
        const row = document.createElement('div');
        row.className = 'seg-row';
        row.draggable = true;
        row.dataset.idx = i;

        const isAuto = SEG_TYPES[seg.type]?.auto;
        const valDisplay = isAuto ? getAutoValue(seg.type, 0) : seg.value;

        row.innerHTML = `
            <span class="seg-handle" title="Drag untuk ubah urutan">☰</span>
            <select class="seg-type" onchange="changeSegType(${i}, this.value)">
                ${Object.entries(SEG_TYPES).map(([k,v]) =>
                    `<option value="${k}" ${seg.type===k?'selected':''}>${v.label}</option>`
                ).join('')}
            </select>
            <input class="seg-value"
                   type="text"
                   value="${isAuto ? valDisplay : seg.value}"
                   placeholder="${SEG_TYPES[seg.type]?.placeholder || ''}"
                   ${isAuto ? 'disabled' : ''}
                   oninput="updateSegValue(${i}, this.value)">
            <button class="seg-delete" onclick="deleteSegment(${i})" title="Hapus segmen">✕</button>
        `;

        // Drag events
        row.addEventListener('dragstart', e => {
            dragSrcIdx = i;
            setTimeout(() => row.classList.add('dragging'), 0);
            e.dataTransfer.effectAllowed = 'move';
        });
        row.addEventListener('dragend', () => {
            row.classList.remove('dragging');
            document.querySelectorAll('.seg-row').forEach(r => r.classList.remove('drag-over'));
        });
        row.addEventListener('dragover', e => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            document.querySelectorAll('.seg-row').forEach(r => r.classList.remove('drag-over'));
            row.classList.add('drag-over');
        });
        row.addEventListener('drop', e => {
            e.preventDefault();
            if (dragSrcIdx === null || dragSrcIdx === i) return;
            const moved = segments.splice(dragSrcIdx, 1)[0];
            segments.splice(i, 0, moved);
            renderSegments();
            updatePreview();
        });

        list.appendChild(row);
    });

    updatePreview();
}

function getAutoValue(type, idx) {
    if (type === 'nomor') {
        // Cari segmen nomor, ambil value-nya sebagai start
        const seg = segments.find(s => s.type === 'nomor');
        const startRaw = seg?.value || '001';
        const startVal = parseInt(startRaw) || 1;
        return String(startVal + idx).padStart(startRaw.length, '0');
    }
    if (type === 'bulan') {
        return String(new Date().getMonth() + 1).padStart(2, '0');
    }
    return '';
}

function addSegment() {
    segments.push({ type: 'teks', value: '' });
    renderSegments();
}

function deleteSegment(i) {
    if (segments.length <= 1) { alert('Minimal harus ada 1 segmen!'); return; }
    segments.splice(i, 1);
    renderSegments();
}

function changeSegType(i, newType) {
    segments[i].type = newType;
    if (SEG_TYPES[newType]?.auto) {
        segments[i].value = newType === 'tahun' ? '{{ date("Y") }}' : '';
    } else if (newType === 'tahun') {
        segments[i].value = '{{ date("Y") }}';
    } else {
        segments[i].value = '';
    }
    renderSegments();
}

function updateSegValue(i, val) {
    segments[i].value = val;
    updatePreview();
}

function setSep(sep, btn) {
    separator = sep;
    document.querySelectorAll('.btn-sep').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('customSep').value = '';
    updatePreview();
}

function setSepCustom(val) {
    if (val) {
        separator = val;
        document.querySelectorAll('.btn-sep').forEach(b => b.classList.remove('active'));
    }
    updatePreview();
}

function genNomor(idx) {
    return segments.map(seg => {
        if (seg.type === 'nomor') return getAutoValue('nomor', idx);
        if (seg.type === 'bulan') return getAutoValue('bulan', idx);
        return seg.value || '';
    }).filter(v => v !== '').join(separator);
}

function updatePreview() {
    document.getElementById('numPreview').textContent = genNomor(0) || '—';
}

// Init default segmen saat halaman load
renderSegments();

// ============================================================
// TABS
// ============================================================
function switchTab(tab, el) {
    document.querySelectorAll('.gen-tabs .nav-link').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('tabManual').classList.toggle('d-none', tab !== 'manual');
    document.getElementById('tabUpload').classList.toggle('d-none', tab !== 'upload');
}

// ============================================================
// FILE UPLOAD
// ============================================================
function handleFile(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        let data = [];
        if (file.name.endsWith('.csv')) {
            const lines = ev.target.result.trim().split('\n');
            const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
            for (let i = 1; i < lines.length; i++) {
                const cols = lines[i].split(',').map(c => c.trim());
                const row = {};
                headers.forEach((h, idx) => row[h] = cols[idx] || '');
                if (row.nama) data.push(row);
            }
        } else {
            const wb = XLSX.read(ev.target.result, { type: 'binary' });
            const ws = wb.Sheets[wb.SheetNames[0]];
            const json = XLSX.utils.sheet_to_json(ws, { defval: '' });
            data = json.map(r => {
                const norm = {};
                Object.keys(r).forEach(k => norm[k.toLowerCase().trim()] = String(r[k]).trim());
                return norm;
            }).filter(r => r.nama);
        }
        parsedData = data;
        showPreview(data);
        document.getElementById('btnGenAll').disabled = data.length === 0;
        document.getElementById('fileInfo').textContent = `${data.length} peserta ditemukan dari "${file.name}"`;
    };
    file.name.endsWith('.csv') ? reader.readAsText(file) : reader.readAsBinaryString(file);
}

function showPreview(data) {
    if (!data.length) return;
    let html = `<div class="csv-preview"><table class="table table-sm table-hover mb-0">
        <thead><tr><th>#</th><th>Nama</th><th>Perusahaan / Instansi</th><th>Nomor Sertifikat</th></tr></thead><tbody>`;
    data.slice(0, 6).forEach((row, i) => {
        const nomorCell = (row.nomor && row.nomor.trim())
            ? `<strong>${row.nomor}</strong>`
            : `<em class="text-muted">${genNomor(i)} (auto)</em>`;
        const perusahaanCell = (row.perusahaan && row.perusahaan.trim())
            ? row.perusahaan
            : `<span class="text-muted" style="font-size:0.72rem">—</span>`;
        html += `<tr><td>${i+1}</td><td>${row.nama}</td><td>${perusahaanCell}</td><td>${nomorCell}</td></tr>`;
    });
    if (data.length > 6) {
        html += `<tr><td colspan="4" class="text-center text-muted">... +${data.length-6} peserta lainnya</td></tr>`;
    }
    html += '</tbody></table></div>';
    document.getElementById('previewTable').innerHTML = html;
}

// ============================================================
// CONFIG
// ============================================================
let certLang = 'id'; // 'id' atau 'en'

function setLang(lang) {
    certLang = lang;
    document.getElementById('btnLangID').classList.toggle('active', lang === 'id');
    document.getElementById('btnLangEN').classList.toggle('active', lang === 'en');
}

const LANG = {
    id: {
        title:       'SERTIFIKAT',
        givenTo:     'Diberikan Kepada',
        completed:   'telah berhasil menyelesaikan',
        heldOn:      'Diselenggarakan pada',
        heldAt:      'di',
        dateRange:   (from, to, place) => {
            const f = fmtID(from), t = fmtID(to);
            const dateStr = to ? f + ' s.d. ' + t : f;
            return dateStr + (place ? ' di ' + place : '');
        },
        dateSingle:  (d, place) => fmtID(d) + (place ? ' di ' + place : ''),
    },
    en: {
        title:       'CERTIFICATE',
        givenTo:     'This is to certify that',
        completed:   'Has Successfully Completed Training Course on:',
        heldOn:      'Held on',
        heldAt:      'in',
        dateRange:   (from, to, place) => {
            const f = fmtEN(from), t = fmtEN(to);
            const dateStr = to ? f + ' until ' + t : f;
            return dateStr + (place ? ' in ' + place : '');
        },
        dateSingle:  (d, place) => fmtEN(d) + (place ? ' in ' + place : ''),
    }
};

// Format tanggal ID: dd-mm-yy (contoh: 22-04-26)
function fmtID(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr + 'T00:00:00');
    const dd = String(d.getDate()).padStart(2, '0');
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const yy = String(d.getFullYear()).slice(2);
    return dd + '-' + mm + '-' + yy;
}

// Format tanggal EN: mm-dd-yy (contoh: 04-22-26)
function fmtEN(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr + 'T00:00:00');
    const dd = String(d.getDate()).padStart(2, '0');
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const yy = String(d.getFullYear()).slice(2);
    return mm + '-' + dd + '-' + yy;
}

function getDateLine() {
    const place   = document.getElementById('eventPlace').value.trim();
    const isMulti = document.getElementById('multiDayToggle').checked;
    const L = LANG[certLang];

    if (!isMulti) {
        const d = document.getElementById('dateStart').value;
        return d ? L.dateSingle(d, place) : '';
    }
    const from = document.getElementById('dateFrom').value;
    const to   = document.getElementById('dateTo').value;
    return from ? L.dateRange(from, to || null, place) : '';
}

function getCfg() {
    return {
        eventName:   document.getElementById('eventName').value || 'Nama Acara',
        institution: document.getElementById('institution').value || '',
        signerName:  document.getElementById('signerName').value || '',
        signerTitle: document.getElementById('signerTitle').value || '',
        perusahaan:  '', // diisi per-item saat render
        dateLine:    getDateLine(),
        lang:        certLang,
        ttdOpacity:  parseFloat(document.getElementById('ttdOpacity').value),
        capOpacity:  parseFloat(document.getElementById('capOpacity').value),
        ttdPos:      document.getElementById('ttdPos').value,
        capPos:      document.getElementById('capPos').value,
        ttdSize:     document.getElementById('ttdSize').value,
    };
}

// ============================================================
// TANGGAL HELPER
// ============================================================
const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni',
                  'Juli','Agustus','September','Oktober','November','Desember'];

function formatTgl(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr + 'T00:00:00');
    return d.getDate() + ' ' + BULAN_ID[d.getMonth()] + ' ' + d.getFullYear();
}

function toggleMultiDay() {
    const isMulti = document.getElementById('multiDayToggle').checked;
    document.getElementById('singleDayInput').classList.toggle('d-none', isMulti);
    document.getElementById('multiDayInput').classList.toggle('d-none', !isMulti);
    updateDatePreview();
}

function updateDatePreview() {
    // Gunakan getDateLine() agar preview selalu sesuai bahasa yang dipilih
    const text = getDateLine();
    const preview = document.getElementById('datePreview');
    if (text) {
        preview.textContent = '📅 ' + text;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

function getEventDateText() {
    const place   = document.getElementById('eventPlace').value.trim();
    const isMulti = document.getElementById('multiDayToggle').checked;

    if (!isMulti) {
        const d = document.getElementById('dateStart').value;
        return d ? (place ? place + ', ' : '') + formatTgl(d) : '';
    }
    const from = document.getElementById('dateFrom').value;
    const to   = document.getElementById('dateTo').value;
    if (!from) return '';
    if (!to)   return (place ? place + ', ' : '') + formatTgl(from);

    const dFrom = new Date(from + 'T00:00:00');
    const dTo   = new Date(to   + 'T00:00:00');
    let range = '';
    if (dFrom.getMonth() === dTo.getMonth() && dFrom.getFullYear() === dTo.getFullYear()) {
        range = dFrom.getDate() + '–' + dTo.getDate() + ' ' +
                BULAN_ID[dFrom.getMonth()] + ' ' + dFrom.getFullYear();
    } else {
        range = formatTgl(from) + ' – ' + formatTgl(to);
    }
    return place ? place + ', ' + range : range;
}

// Update preview jika tempat diubah
document.getElementById('eventPlace').addEventListener('input', updateDatePreview);

// ============================================================
// VALIDASI SEGMEN
// ============================================================
// ============================================================
// HELPER: reset & set border merah pada field
// ============================================================
function fieldError(id, isErr) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.borderColor = isErr ? '#f87171' : '';
    el.style.background  = isErr ? '#fff5f5' : '';
}

// ============================================================
// VALIDASI UTAMA — semua field pengaturan + segmen
// ============================================================
function validateAll(namaManual) {
    const errors = [];

    // — Pengaturan Sertifikat —
    const eventName = document.getElementById('eventName').value.trim();
    fieldError('eventName', !eventName);
    if (!eventName) errors.push('Nama acara / kegiatan wajib diisi.');

    const eventPlace = document.getElementById('eventPlace').value.trim();
    fieldError('eventPlace', !eventPlace);
    if (!eventPlace) errors.push('Tempat pelaksanaan wajib diisi.');

    // Tanggal
    const isMulti = document.getElementById('multiDayToggle').checked;
    if (!isMulti) {
        const d = document.getElementById('dateStart').value;
        fieldError('dateStart', !d);
        if (!d) errors.push('Tanggal pelaksanaan wajib diisi.');
    } else {
        const from = document.getElementById('dateFrom').value;
        const to   = document.getElementById('dateTo').value;
        fieldError('dateFrom', !from);
        fieldError('dateTo',   !to);
        if (!from || !to) errors.push('Tanggal pelaksanaan (dari & sampai) wajib diisi.');
        else if (from > to) {
            fieldError('dateTo', true);
            errors.push('Tanggal "Sampai" tidak boleh sebelum tanggal "Dari".');
        }
    }

    const institution = document.getElementById('institution').value.trim();
    fieldError('institution', !institution);
    if (!institution) errors.push('Institusi / lembaga wajib diisi.');

    const signerName = document.getElementById('signerName').value.trim();
    fieldError('signerName', !signerName);
    if (!signerName) errors.push('Nama penandatangan wajib diisi.');

    const signerTitle = document.getElementById('signerTitle').value.trim();
    fieldError('signerTitle', !signerTitle);
    if (!signerTitle) errors.push('Jabatan penandatangan wajib diisi.');

    // — Nama peserta divalidasi terpisah di generateManual —

    // — Segmen nomor —
    document.querySelectorAll('.seg-row').forEach(r => {
        r.style.borderColor = '';
        r.style.background  = '';
    });
    segments.forEach((seg, i) => {
        const rowEl = document.querySelectorAll('.seg-row')[i];
        if (seg.type === 'teks' && (!seg.value || !seg.value.trim())) {
            if (rowEl) { rowEl.style.borderColor = '#f87171'; rowEl.style.background = '#fff5f5'; }
            errors.push('Segmen "Teks/Kode" #' + (i+1) + ' kosong — hapus jika tidak digunakan.');
        } else if (seg.type === 'nomor' && (!seg.value || !seg.value.trim())) {
            if (rowEl) { rowEl.style.borderColor = '#f87171'; rowEl.style.background = '#fff5f5'; }
            errors.push('Segmen "Nomor Urut" #' + (i+1) + ': isi angka mulai (contoh: 001).');
        } else if (seg.type === 'tahun' && (!seg.value || !seg.value.trim())) {
            if (rowEl) { rowEl.style.borderColor = '#f87171'; rowEl.style.background = '#fff5f5'; }
            errors.push('Segmen "Tahun" #' + (i+1) + ' tidak boleh kosong.');
        }
    });

    if (errors.length > 0) {
        showValidationAlert(errors);
        // Scroll ke field pertama yang error
        const firstErr = document.querySelector('[style*="border-color: rgb(248"]');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    return true;
}

function showValidationAlert(messages, title) {
    const old = document.getElementById('validationAlert');
    if (old) old.remove();

    const alertEl = document.createElement('div');
    alertEl.id = 'validationAlert';
    alertEl.style.cssText = `
        position: fixed; top: 20px; right: 20px; z-index: 9999;
        background: #fff; border: 1.5px solid #f87171;
        border-left: 5px solid #ef4444;
        border-radius: 12px; padding: 16px 20px 14px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        max-width: 380px; font-size: 0.82rem;
        animation: slideIn .25s ease;
        position: fixed;
    `;
    alertEl.innerHTML = `
        <div style="font-weight:700;color:#b91c1c;margin-bottom:8px;font-size:0.85rem;padding-right:20px">
            ⚠ ${title || 'Form belum lengkap'}
        </div>
        <ul style="margin:0;padding-left:16px;color:#374151;line-height:1.8">
            ${messages.map(m => '<li>' + m + '</li>').join('')}
        </ul>
        <button onclick="this.parentElement.remove()"
                style="position:absolute;top:10px;right:12px;background:none;border:none;
                       font-size:1.1rem;color:#aaa;cursor:pointer;line-height:1">✕</button>
    `;
    document.body.appendChild(alertEl);
    setTimeout(() => { if (alertEl.parentElement) alertEl.remove(); }, 7000);
}

// Hapus highlight merah saat user mulai mengetik/memilih
['eventName','eventPlace','dateStart','dateFrom','dateTo',
 'institution','desc','signerName','signerTitle'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => fieldError(id, false));
    if (el) el.addEventListener('change', () => fieldError(id, false));
});

// CSS animasi toast
const styleEl = document.createElement('style');
styleEl.textContent = `@keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }`;
document.head.appendChild(styleEl);

// ============================================================
// MULTI PESERTA MANUAL
// ============================================================
const MAX_PESERTA = 4;
let manualPesertaList = [{ nama: '', perusahaan: '', nomor: '' }];

function renderManualPeserta() {
    const container = document.getElementById('manualPesertaList');
    container.innerHTML = '';

    manualPesertaList.forEach((p, i) => {
        const card = document.createElement('div');
        card.className = 'peserta-card';
        card.id = 'pesertaCard' + i;
        card.innerHTML = `
            <div class="peserta-card-header">
                <div class="peserta-num">
                    <div class="num-badge">${i + 1}</div>
                    Peserta ${i + 1}
                </div>
                ${manualPesertaList.length > 1
                    ? `<button class="btn-del-peserta" onclick="deletePeserta(${i})" title="Hapus peserta ini">✕</button>`
                    : ''}
            </div>
            <div class="mb-2">
                <label class="form-label-sm">Nama Peserta <span style="color:#ef4444">*</span></label>
                <input type="text" class="form-control form-control-sm" id="nama_${i}"
                       value="${p.nama}" placeholder="Contoh: Budi Santoso, S.T."
                       oninput="updatePeserta(${i}, 'nama', this.value); fieldError('nama_${i}', false)">
            </div>
            <div class="mb-2">
                <label class="form-label-sm">
                    Asal Perusahaan / Instansi
                    <span style="text-transform:none;letter-spacing:0;font-size:0.68rem;color:#9ca3af;font-weight:400"> — opsional</span>
                </label>
                <input type="text" class="form-control form-control-sm" id="perusahaan_${i}"
                       value="${p.perusahaan}" placeholder="Contoh: PT. Maju Bersama"
                       oninput="updatePeserta(${i}, 'perusahaan', this.value)">
            </div>
            <div>
                <label class="form-label-sm">
                    Nomor Sertifikat
                    <span style="text-transform:none;letter-spacing:0;font-size:0.68rem;color:#9ca3af;font-weight:400"> — kosongkan untuk auto-number</span>
                </label>
                <input type="text" class="form-control form-control-sm" id="nomorSert_${i}"
                       value="${p.nomor}" placeholder="Kosongkan = auto-number"
                       oninput="updatePeserta(${i}, 'nomor', this.value)">
            </div>
        `;
        container.appendChild(card);
    });

    // Update tombol & counter
    const btn = document.getElementById('btnAddPeserta');
    const count = document.getElementById('pesertaCount');
    const infoMax = document.getElementById('infoMaxPeserta');

    const isFull = manualPesertaList.length >= MAX_PESERTA;
    btn.disabled = isFull;
    count.textContent = manualPesertaList.length + ' / ' + MAX_PESERTA + ' peserta';
    infoMax.classList.toggle('d-none', !isFull);
}

function updatePeserta(i, field, val) {
    manualPesertaList[i][field] = val;
}

function addPeserta() {
    if (manualPesertaList.length >= MAX_PESERTA) return;
    manualPesertaList.push({ nama: '', perusahaan: '', nomor: '' });
    renderManualPeserta();
    // Scroll ke card baru
    const newCard = document.getElementById('pesertaCard' + (manualPesertaList.length - 1));
    if (newCard) setTimeout(() => newCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
}

function deletePeserta(i) {
    manualPesertaList.splice(i, 1);
    renderManualPeserta();
}

// Init saat load
renderManualPeserta();

// ============================================================
// GENERATE
// ============================================================
function generateManual() {
    // Sync nilai dari DOM ke state (pastikan terbaru)
    manualPesertaList.forEach((p, i) => {
        p.nama       = (document.getElementById('nama_' + i)?.value || '').trim();
        p.perusahaan = (document.getElementById('perusahaan_' + i)?.value || '').trim();
        p.nomor      = (document.getElementById('nomorSert_' + i)?.value || '').trim();
    });

    // Validasi form pengaturan
    if (!validateAll()) return;

    // Validasi nama peserta — semua wajib diisi
    let pesertaOk = true;
    manualPesertaList.forEach((p, i) => {
        if (!p.nama) {
            fieldError('nama_' + i, true);
            pesertaOk = false;
        }
    });
    if (!pesertaOk) {
        showValidationAlert(['Nama peserta wajib diisi untuk semua peserta yang ditambahkan.']);
        return;
    }

    generatedCanvases = [];
    // Hitung offset nomor: peserta pertama dapat genNomor(0), dst
    let autoIdx = 0;
    const list = manualPesertaList.map(p => ({
        nama:       p.nama,
        perusahaan: p.perusahaan,
        nomor:      p.nomor || genNomor(autoIdx++)
    }));
    renderResult(list, getCfg());
}

function generateAll() {
    if (!parsedData.length) return;
    if (!validateAll()) return;
    generatedCanvases = [];
    const list = parsedData.map((item, i) => ({
        nama:       item.nama,
        perusahaan: item.perusahaan || '',
        nomor:      (item.nomor && item.nomor.trim()) ? item.nomor.trim() : genNomor(i)
    }));
    renderResult(list, getCfg());
}

function renderResult(list, cfg) {
    const grid = document.getElementById('certGrid');
    grid.innerHTML = '';
    document.getElementById('results').classList.remove('d-none');

    list.forEach(item => {
        const canvas = drawCert(item.nama, item.nomor, { ...cfg, perusahaan: item.perusahaan || '' });
        generatedCanvases.push({ canvas, nama: item.nama, nomor: item.nomor });

        const col = document.createElement('div');
        col.className = 'col-md-6';
        const card = document.createElement('div');
        card.className = 'cert-card';
        card.appendChild(canvas);

        const nameEl = document.createElement('div');
        nameEl.className = 'cert-card-name';
        nameEl.textContent = item.nama;
        card.appendChild(nameEl);

        const btn = document.createElement('button');
        btn.className = 'btn-dl';
        btn.innerHTML = '<i class="bi bi-download me-1"></i>Download PNG';
        btn.onclick = () => dlOne(canvas, item.nama, item.nomor);
        card.appendChild(btn);

        col.appendChild(card);
        grid.appendChild(col);
    });

    const dlAll = document.getElementById('btnDownloadAll');
    dlAll.style.display = list.length > 1 ? 'block' : 'none';
    document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
}

// ============================================================
// DRAW CERTIFICATE (Canvas)
// ============================================================
function posX(pos, W) {
    return pos === 'left' ? W * 0.25 : pos === 'right' ? W * 0.75 : W / 2;
}

// ── Helper: wrap teks panjang di canvas ──
function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
    const words = text.split(' ');
    let line = '', lines = [];
    for (let w of words) {
        const test = line ? line + ' ' + w : w;
        if (ctx.measureText(test).width > maxWidth && line) { lines.push(line); line = w; }
        else line = test;
    }
    if (line) lines.push(line);
    lines.forEach((l, i) => ctx.fillText(l, x, y + i * lineHeight));
    return lines.length;
}

function drawCert(nama, nomor, cfg) {
    const W = 960, H = 680;
    const canvas = document.createElement('canvas');
    canvas.width = W; canvas.height = H;
    const ctx = canvas.getContext('2d');
    const L = LANG[cfg.lang] || LANG['id'];

    // ─── BACKGROUND ───────────────────────────────────────────
    if (imgs.bg) {
        const bw = imgs.bg.width, bh = imgs.bg.height;
        const scale = Math.max(W / bw, H / bh);
        const dw = bw * scale, dh = bh * scale;
        ctx.drawImage(imgs.bg, (W - dw) / 2, (H - dh) / 2, dw, dh);
    } else {
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, W, H);
        // Watermark diagonal samar
        ctx.save();
        ctx.globalAlpha = 0.035;
        ctx.translate(W / 2, H / 2);
        ctx.rotate(-Math.PI / 7);
        ctx.font = 'bold 96px "Playfair Display", serif';
        ctx.fillStyle = '#0F1E3C';
        ctx.textAlign = 'center';
        ctx.fillText(cfg.institution || 'VALIDLY', 0, 0);
        ctx.restore();
        ctx.globalAlpha = 1;
    }

    ctx.textAlign = 'center';

    // ─── Cursor Y ─────────────────────────────────────────────
    let y = 48;

    // ─── 1. LOGO (opsional) ───────────────────────────────────
    if (imgs.logo) {
        const lh = 64;
        const lw = imgs.logo.width * (lh / imgs.logo.height);
        ctx.drawImage(imgs.logo, W / 2 - lw / 2, y, lw, lh);
        y += lh + 10;
    }

    // ─── 2. JUDUL SERTIFIKAT / CERTIFICATE ───────────────────
    ctx.font = 'bold 64px "Playfair Display", serif';
    ctx.fillStyle = '#111111';
    y += 56; // naik agar judul tidak terlalu tinggi
    ctx.fillText(L.title, W / 2, y);
    y += 16;

    // Garis bawah tipis
    ctx.strokeStyle = '#cccccc'; ctx.lineWidth = 1;
    ctx.beginPath(); ctx.moveTo(W/2-150, y); ctx.lineTo(W/2+150, y); ctx.stroke();
    y += 26;

    // ─── 3. NOMOR SERTIFIKAT ──────────────────────────────────
    ctx.font = '13px Inter, sans-serif';
    ctx.fillStyle = '#555555';
    ctx.fillText(nomor, W / 2, y);
    y += 28;

    // ─── 4. "Diberikan Kepada" / "This is to certify that" ───
    ctx.font = 'italic 16px "Playfair Display", serif';
    ctx.fillStyle = '#444444';
    ctx.fillText(L.givenTo, W / 2, y);
    y += 52;

    // ─── 5. NAMA PESERTA ─────────────────────────────────────
    let namaSize = 54;
    ctx.font = `bold italic ${namaSize}px "Playfair Display", serif`;
    // Scale down kalau nama terlalu panjang
    while (ctx.measureText(nama).width > W - 100 && namaSize > 28) {
        namaSize -= 2;
        ctx.font = `bold italic ${namaSize}px "Playfair Display", serif`;
    }
    ctx.fillStyle = '#111111';
    ctx.fillText(nama, W / 2, y);

    // Underline solid
    const nw = Math.min(ctx.measureText(nama).width + 20, W - 80);
    ctx.strokeStyle = '#111111'; ctx.lineWidth = 1.2;
    ctx.beginPath();
    ctx.moveTo(W/2 - nw/2, y + 8);
    ctx.lineTo(W/2 + nw/2, y + 8);
    ctx.stroke();
    y += 26;

    // ─── 6. ASAL PERUSAHAAN (opsional) ───────────────────────
    if (cfg.perusahaan) {
        ctx.font = '14px Inter, sans-serif';
        ctx.fillStyle = '#666666';
        ctx.fillText(cfg.perusahaan, W / 2, y);
        y += 24;
    }

    // ─── 7. NAMA ACARA / KEGIATAN ────────────────────────────
    ctx.font = '14px Inter, sans-serif';
    ctx.fillStyle = '#444444';
    ctx.fillText(L.completed, W / 2, y);
    y += 26;

    ctx.font = 'bold 17px Inter, sans-serif';
    ctx.fillStyle = '#111111';
    const evLines = wrapText(ctx, cfg.eventName, W / 2, y, W - 160, 24);
    y += evLines * 24 + 18;

    // ─── 8. TANGGAL & TEMPAT ─────────────────────────────────
    if (cfg.dateLine) {
        ctx.font = 'italic 14px "Playfair Display", serif';
        ctx.fillStyle = '#555555';
        ctx.fillText(cfg.dateLine, W / 2, y);
        y += 18;
    }

    // ─── 9. CAP + TTD bersebelahan ───────────────────────────
    // Posisi TTD & Cap selalu bersebelahan: Cap kiri, TTD kanan (atau sesuai setting)
    const sigY = Math.max(y + 20, H - 148);
    const sizes = { sm: 80, md: 105, lg: 135 };
    const sz = sizes[cfg.ttdSize];
    const ttdCX = posX(cfg.ttdPos, W);
    const capCX = posX(cfg.capPos, W);

    if (imgs.cap) {
        const cw = sz * 1.1, ch = imgs.cap.height * (cw / imgs.cap.width);
        ctx.globalAlpha = cfg.capOpacity;
        ctx.drawImage(imgs.cap, capCX - cw / 2, sigY - ch + 8, cw, ch);
        ctx.globalAlpha = 1;
    }
    if (imgs.ttd) {
        const tw = sz, th = imgs.ttd.height * (tw / imgs.ttd.width);
        ctx.globalAlpha = cfg.ttdOpacity;
        ctx.drawImage(imgs.ttd, ttdCX - tw / 2, sigY - th - 2, tw, th);
        ctx.globalAlpha = 1;
    }

    // ─── 10. NAMA PENANDATANGAN + JABATAN ────────────────────
    // Garis atas nama
    ctx.strokeStyle = '#111111'; ctx.lineWidth = 1;
    ctx.beginPath(); ctx.moveTo(ttdCX - 100, sigY); ctx.lineTo(ttdCX + 100, sigY); ctx.stroke();

    // Nama penandatangan bold + underline (gaya referensi)
    ctx.font = 'bold 13px Inter, sans-serif';
    ctx.fillStyle = '#111111';
    ctx.fillText(cfg.signerName, ttdCX, sigY + 18);
    const snw = ctx.measureText(cfg.signerName).width;
    ctx.beginPath();
    ctx.moveTo(ttdCX - snw/2, sigY + 20);
    ctx.lineTo(ttdCX + snw/2, sigY + 20);
    ctx.stroke();

    // Jabatan
    ctx.font = '12px Inter, sans-serif';
    ctx.fillStyle = '#555555';
    ctx.fillText(cfg.signerTitle, ttdCX, sigY + 36);

    return canvas;
}


function dlOne(canvas, nama) {
    const a = document.createElement('a');
    a.download = `sertifikat_${nama.replace(/\s+/g,'_')}.png`;
    a.href = canvas.toDataURL('image/png');
    a.click();
}

async function downloadAllCerts() {
    if (!generatedCanvases.length) return;
    const zip = new JSZip();
    generatedCanvases.forEach(({ canvas, nama, nomor }) => {
        const b64 = canvas.toDataURL('image/png').split(',')[1];
        const safe = `${nomor.replace(/[\\/]/g,'-')}_${nama.replace(/\s+/g,'_')}`;
        zip.file(`${safe}.png`, b64, { base64: true });
    });
    const blob = await zip.generateAsync({ type: 'blob' });
    const a = document.createElement('a'); a.download = 'sertifikat_semua.zip';
    a.href = URL.createObjectURL(blob); a.click();
}
</script>
@endpush
