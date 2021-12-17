<?php

namespace App\Http\Controllers;

use App\Models\Web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    private KategoriController $kategoriController;
    private $idKategori;
    public function __construct()
    {
        $this->kategoriController = new KategoriController();
    }

    public function setIdKategori($id)
    {
        $this->idKategori = $id;
    }

    public function index()
    {
        $listWeb = DB::table('webs')->paginate(10);

        $kategori = $this->kategoriController->index();

        return view('home', ['listWeb' => $listWeb, 'kategori' => $kategori]);
    }

    public function compare()
    {
        $listWeb = DB::table('webs')->paginate(10);

        return view('compare', ['listWeb' => $listWeb]);
    }

    public function getId()
    {
        if ($this->idKategori == 0) {
            $data = Web::select('id')->get();
        } else {
            $data = Web::select('id')
                ->where('id_kategori', $this->idKategori)
                ->get();
        }
        return $data;
    }

    public function getBrokenLink()
    {
        if ($this->idKategori == 0) {
            $data = Web::select('broken_link')->get();
        } else {
            $data = Web::select('broken_link')
                ->where('id_kategori', $this->idKategori)
                ->get();
        }
        return $data;
    }

    public function getPageLoadTime()
    {
        // print( $this->idKategori);
        if ($this->idKategori == 0) {
            $data = Web::select('page_load_time')->get();
        } else {
            $data = Web::select('page_load_time')
                ->where('id_kategori', $this->idKategori)
                ->get();
        }
        return $data;
    }

    public function getSizeWeb()
    {
        if ($this->idKategori == 0) {
            $data = Web::select('size_web')->get();
        } else {
            $data = Web::select('size_web')
                ->where('id_kategori', $this->idKategori)
                ->get();
        }
        return $data;
    }

    public function getAll()
    {
        if ($this->idKategori == 0) {
            $data = Web::select('broken_link', 'page_load_time', 'size_web')->get();
        } else {
            $data = Web::select('broken_link', 'page_load_time', 'size_web')
                ->where('id_kategori', $this->idKategori)
                ->get();
        }
        return $data;
    }

    public function find($id)
    {
        return DB::table('webs')->find($id);
    }
}
