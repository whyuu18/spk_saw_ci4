<?php

namespace App\Controllers;

use App\Models\HasilModel;

class Hasil extends BaseController
{
    protected $hasil;
    protected $dataBulan;
    protected $dataTahun;

    public function __construct()
    {
        $this->hasil = new HasilModel();
    }

    public function index()
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Data Hasil',
            'hasil' => $this->hasil->getDataHasil(),
            'countHasil' => $this->hasil->getCountHasilUnik(),
        ];
        return view('Hasil/index', $data);
    }

    public function cetak()
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'cetak',
            'hasil' => $this->hasil->getDataHasil(),
        ];
        return view('Hasil/cetak', $data);
    }

    public function hapus($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $this->hasil->delete($id);

        // Set pesan berhasil
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');

        return redirect()->to('/hasil');
    }
}
