<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="text-muted">Edit Data Alternatif</h6>
    </div>
    <div class="col">
        <div class="row">
            <?php if(session()->getFlashdata('errors')) : ?>
                <div class="mt-1 col-md-5">
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('errors') ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <form action="/alternatif/update/<?= $alternatif['id_alternatif'] ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body px-5 py-4 mb-4">
            <input type="hidden" name="id" value="<?= $alternatif['id_alternatif'] ?>">

            <div class="row">
                <div class="form-group col-md-12 mt-2">
                    <label class="form-label">Nama Alternatif</label>
                    <input onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" type="text" name="alternatif" class="form-control <?= ($validation->hasError('alternatif')) ? 'is-invalid' : ''; ?>" value="<?= $alternatif['alternatif'] ?>" />
                    <div class="invalid-feedback">
                        <?= $validation->getError('alternatif'); ?>
                    </div>
                </div>

                <div class="form-group col-md-12 mt-2">
                    <label class="form-label">Nomor NIK</label>
                    <input autocomplete="off" inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="16" name="nik" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" value="<?= $alternatif['nik'] ?>" />
                    <div class="invalid-feedback">
                        <?= $validation->getError('nik'); ?>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-2">
                    <label class="form-label">Foto KTP</label>
                </div>
                <div class="col">
                    <img src="<?= base_url('img/' . $alternatif['foto_ktp']) ?>" alt="" width="300" height="300" class="img-thumbnail">
                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success btn-sm"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('/alternatif') ?>" class="btn btn-secondary btn-sm"></span>
                <i class="bi bi-backspace"></i><span class="text"> Kembali</span>
            </a>
        </div>
    </form>
</div>
<?= $this->endSection('content') ?>