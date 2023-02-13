<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DAFTAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style/main.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <form>
        <div>
            <div class="col-md-12">
                <h3 class="mx-0 fs-4">NIK</h3>
                <label for="nik" class="form-label">Nomer Induk Kependudukan</label>
                <input type="text" class="form-control" id="nik" required maxlength="16">
            </div>
        </div>
        <div class="row mt-3">
            <h3 class="mx-0 fs-4">Nama</h3>
            <div class="col-md-6">
                <label for="firstname" class="form-label">Nama Depan</label>
                <input type="text" class="form-control" id="firstname" required>
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Nama Belakang</label>
                <input type="text" class="form-control" id="lastname" required>
            </div>
        </div>
        <div class="mt-3">
            <h3 class="mx-0 fs-4">Jenis Kelamin</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" checked required>
                <label class="form-check-label" for="male">
                    Laki-laki
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" required>
                <label class="form-check-label" for="female">
                    Perempuan
                </label>
            </div>
        </div>
        <div class="row mt-3">
            <h3 class="mx-0 fs-4">Tempat Tanggal Lahir</h3>
            <div class="col-8">
                <label for="place-of-birth" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="place-of-birth" required>
            </div>
            <div class="col-4">
                <label for="date-of-birth" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="date-of-birth" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="mx-0 fs-4">Alamat</h3>
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
            </div>
            <div class="col-md-6">
                <label for="city" class="form-label">Kota</label>
                <input type="text" class="form-control" id="city">
            </div>
            <div class="col-md-4">
                <label for="districts" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="districts">
            </div>
            <div class="col-md-2">
                <label for="postcode" class="form-label">Kode Pos</label>
                <input type="text" class="form-control" id="postcode">
            </div>
        </div>
        <div class="col-12 mt-3 c">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<div class="container">
    <footer class="py-3 border-top">
        <p class="text-center text-muted">&copy; 2022, Design and Develop By Bahtiar Rifa'i</p>
    </footer>
</div>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

<div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3" id="exampleModalLabel">Daftar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Nama Depan</label>
                            <input class="form-control" id="firstname" placeholder="Nama Depan *"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nama Belakang</label>
                            <input class="form-control" id="lastname" placeholder="Nama Belakang *"
                                   required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="nik" class="form-label">Email</label>
                        <input class="form-control" id="nik" placeholder="Massukkan Alamat Email Anda *" required>
                    </div>
                    <div class="mt-3">
                        <label for="nik" class="form-label">Password</label>
                        <input type="password" class="form-control" id="nik" placeholder="Massukkan Password Anda *"
                               required minlength="8" maxlength="20">
                        <div id="passwordHelpBlock" class="form-text">
                            Kata sandi Anda harus sepanjang 8-20 karakter.
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="date-of-birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="date-of-birth"
                               placeholder="Masukkan Tanggal Lahir Anda *" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" checked required>
                            <label class="form-check-label" for="male">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" required>
                            <label class="form-check-label" for="female">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-dark">Daftar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>