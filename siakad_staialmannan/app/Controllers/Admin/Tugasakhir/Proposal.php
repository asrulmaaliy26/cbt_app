<?php

namespace App\Controllers\Admin\Tugasakhir;

use App\Controllers\BaseController;
use App\Models\ProposalModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Proposal extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->proposal = new ProposalModel($request);
        $this->halaman_controller = "proposal";
        $this->halaman_label = "Proposal";

        if (!session()->has('akun_username')) {
            // Jika sesi habis, kembalikan respons JSON
            return $this->response->setJSON(['session_expired' => true]);
        }
    }
    
    public function index()
    {
        $data = [];
        
        if(session()->get('akun_level') == 'Mahasiswa'){
            $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
            $data ['id_data_diri']= getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
            $data ['id_his_pdk'] = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
        }
        
        if ($this->request->getMethod(true)=='POST') {
            if($this->request->getVar('aksi')=='hapus' && $this->request->getVar('id')){
                $dt = $this->proposal->find($this->request->getVar('id'));
                if($dt['id']){ #memastikan ada data
                    $cekPenguji = dataDinamis('penguji_sempro', ['id_sempro' => $dt['id']]);
                    $cekHasil = dataDinamis('hasil_sempro', ['id_sempro' => $dt['id']]);
                    
                    $aksi = $this->proposal->delete($this->request->getVar('id'));
                    if($aksi == true){
                        if(!empty($cekPenguji)){
                            deleteDataDinamis('penguji_sempro', ['id_sempro' => $dt['id']]);
                        }
                        if(!empty($cekHasil)){
                            deleteDataDinamis('hasil_sempro', ['id_sempro' => $dt['id']]);
                        }
                        
                        @unlink(substr($dt['kwitansi'],34));
                        @unlink(substr($dt['rekom'],34));
                        @unlink(substr($dt['proposal'],34));
                        @unlink(substr($dt['plagiasi'],34));
                        return json_encode(array("status" => TRUE));
                    }else{
                        return json_encode(array("status" => false));
                    }
                }
            }
        }

        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'index';
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function ajaxList()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->proposal->getDatatables();
            
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $link_detail= site_url("tugasakhir/$this->halaman_controller/detail?id=").$list->id;
                if($list->status=='1'){
                 $status= '<span class="badge badge-primary">Diterima</span>';
             }elseif($list->status=='2'){
                 $status= '<span class="badge badge-danger">Ditolak</span>';
             }elseif($list->status=='3'){
                 $status= '<span class="badge badge-primary">Menunggu Koreksi</span>';
             }elseif($list->status=='4'){
                 $status= '<span class="badge badge-success">Siap Diujikan</span>';
             }elseif($list->status=='5'){
                 $status= '<span class="badge badge-success">Telah Diujikan</span>';
             }elseif($list->status=='6'){
                 $status= '<span class="badge badge-success">Lulus Dengan Revisi</span>';
             }
             
             $no++;
             $row = [];
             if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "Kaprodi" || session()->get('akun_level') == "Fakultas" || session()->get('akun_level') == "Panitia Tugas Akhir"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags($list->judul);
                $row[] = (!empty($list->id_dosen))?getDataRow('data_dosen', ['Kode' => $list->id_dosen])['Nama_Dosen']:'';
                $row[] = $status;
                $row[] = /*$list->tgl_dibuat*/tgl_indonesia_short($list->created_at);
                if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "Panitia Tugas Akhir"){
                    $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Proposal"><i class="fa fa-eye"></i></a>
                    <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_seminar?id=$list->id', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                    <a onclick="hapus('."'".$list->id."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Skripsi"><i class="fa fa-trash"></i></a>
                    ';
                }else{
                    $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Proposal"><i class="fa fa-eye"></i></a>
                    <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_seminar?id=$list->id', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                    ';
                }
            }
            if(session()->get('akun_level') == "Mahasiswa"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = strip_tags($list->judul);
                $row[] = (!empty($list->id_dosen))?getDataRow('data_dosen', ['Kode' => $list->id_dosen])['Nama_Dosen']:'';
                $row[] = $status;
                $row[] = /*$list->tgl_dibuat*/tgl_indonesia_short($list->created_at);
                $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Proposal"><i class="fa fa-eye"></i></a>
                <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_seminar?id=$list->id', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                ';
            }
            
            if(session()->get('akun_level') == "Dosen"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags($list->judul);
                $row[] = (!empty($list->id_dosen))?getDataRow('data_dosen', ['Kode' => $list->id_dosen])['Nama_Dosen']:'';
                $row[] = 'Ke-'.getDataRow('penguji_sempro', ['id_sempro'=>$list->id, 'kd_dosen' => $this->request->getVar('kd_dosen')])['tugas'];
                $row[] = $status;
                $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Proposal"><i class="fa fa-eye"></i></a>
                <!--<a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_seminar?id=$list->id', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>-->    
                ';
            }
            $data[] = $row;
        }

        $output = [
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $this->proposal->countAll(),
            'recordsFiltered' => $this->proposal->countFiltered(),
            'data' => $data
        ];

        echo json_encode($output);
    }
}

public function getData()
{
    
    $data = $this->disposisi->find($this->request->getVar('id'));

    if(empty($data)){
        echo json_encode(array("status" => false));
    }else{
        echo json_encode(array("status" => true));
    }
    
}


function detail()
{
    $data = [];
    
    if($this->request->getVar('id')){
     $data = $this->proposal->find($this->request->getVar('id'));
     $data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
 }
 
 if(session()->get('akun_level') == "Dosen"){
  $kd_dosen = getDataRow('data_dosen',['username'=>session()->get('akun_username')])['Kode'];
  $data['penguji'] = getDataRow('penguji_sempro', ['id_sempro'=>$this->request->getVar('id'), 'kd_dosen' => $kd_dosen])['tugas'];
  $data['hasil'] = getDataRow('hasil_sempro', ['id_sempro'=>$this->request->getVar('id'), 'penguji' => $data['penguji']]);
}

$data['templateJudul'] = $this->halaman_label;
$data['controller'] = $this->halaman_controller;
$data['aktif_menu'] = $this->halaman_controller;
$data['metode']    = 'detail';
return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
}

public function getValidasi()
{
  
  $id = $this->request->getVar('id');	$field = $this->request->getVar('field');
  
  $data = getDataRow('sempro', ['id' => $id])[$field];

  return json_encode(array('nilai'=>$data,'field'=>$field));
  
}

public function validasi()
{
  
  if($this->request->getMethod()=="post"){
      
    $record = [
        'id' => $this->request->getVar('id'),
        $this->request->getVar('field') => $this->request->getVar('nilai')
    ];
    $aksi = $this->proposal->simpanData($record);
    if($aksi){
        return json_encode(array("msg" => "success", "pesan" => "Validasi persyaratan berhasil disimpan.", 'nilai'=>$this->request->getVar('nilai'),'field'=>$this->request->getVar('field')));
    }else{
        return json_encode(array("msg" => "error", "pesan" => "Validasi persyaratan gagal disimpan."));
    }
}
}

function simpan_catatan()
{
  if($this->request->getMethod()=="post"){
      
    $record = [
        'id' => $this->request->getVar('id'),
        $this->request->getVar('field') => $this->request->getVar('catatan')
    ];
    $aksi = $this->proposal->simpanData($record);
    if($aksi){
        return json_encode(array("msg" => "success", "pesan" => "berhasil disimpan."));
    }else{
        return json_encode(array("msg" => "error", "pesan" => "gagal disimpan."));
    }
}
}

function simpan_penguji()
{
  if($this->request->getMethod()=="post"){
      $cekPenguji = getDataRow('penguji_sempro', ['id_sempro' => $this->request->getVar('id_sempro'), 'tugas' => $this->request->getVar('tugas')]);
      if(empty($cekPenguji)){
          $record = [
            'id_sempro' => $this->request->getVar('id_sempro'),
            'tugas' => $this->request->getVar('tugas'),
            'kd_dosen' => $this->request->getVar('kd_dosen')
        ];
        
        if(setDataDinamis('penguji_sempro', $record)){
            return json_encode(array("msg" => "success", "pesan" => "Penguji berhasil disimpan."));
        }else{
            return json_encode(array("msg" => "error", "pesan" => "Penguji gagal disimpan."));
        }
    }else{
      $record = [
        
        'kd_dosen' => $this->request->getVar('kd_dosen')
    ];
    if(updateDataDinamis('penguji_sempro', $record, ['id_penguji' => $cekPenguji['id_penguji']])){
        return json_encode(array("msg" => "success", "pesan" => "Penguji berhasil diupdate."));
    }else{
        return json_encode(array("msg" => "error", "pesan" => "Penguji gagal diupdate."));
    }
}
}
}


function formulir()
{
    $data = [];
    
    if($this->request->getVar('id_his_pdk')){
        $krsModel = new \App\Models\KrsModel($this->request);
        $MahasiswaModel = new \App\Models\MahasiswaModel($this->request);
        $data ['id_data_diri']= getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')])['id_data_diri'];
        $data ['id_his_pdk'] = $this->request->getVar('id_his_pdk');
        $dtKrs = $krsModel->where(['id_his_pdk' => $this->request->getVar('id_his_pdk'), 'kode_ta' => getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']])->first();
        
        if(empty($dtKrs) || $dtKrs['stat_mhs'] != 'A'){
          session()->setFlashdata("info", "warning");
      }
      
  }
  
  if($this->request->getMethod()=="post"){
      
      $aturan = [
        'judul-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Rencana judul skripsi tidak boleh kosong!!'
            ]
        ],
        'pembimbing' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Pembimbing tidak boleh kosong!!'
            ]
        ],
        'latar-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Latar belakang / konteks penelitian tidak boleh kosong!!'
            ]
        ],
        'rumusan-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Rumusan malasah / fokus penelitian tidak boleh kosong!!'
            ]
        ],
        'tujuan-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Tujuan penelitian tidak boleh kosong!!'
            ]
        ],
        'metode-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Metode penelitian tidak boleh kosong!!'
            ]
        ],
        'konsep-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Konsep / kajian teori penelitian tidak boleh kosong!!'
            ]
        ],
        'kajian-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Review penelitian terdahulu tidak boleh kosong!!'
            ]
        ],
        'sistematika-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Sitematika pembahasan tidak boleh kosong!!'
            ]
        ],
        'pustaka-part-inp' => [
            'rules' => 'required',
            'errors' => [
                'required'=>'Daftar pustaka tidak boleh kosong!!'
            ]
        ],
        'kwitansi' => [
            'rules' => 'uploaded[kwitansi]|mime_in[kwitansi,application/pdf]|ext_in[kwitansi,pdf]|max_size[kwitansi,512]',
            'errors' => [
                'uploaded' => 'Kwitansi pembayaran seminar proposal harus diupload!!',
                'mime_in' => 'Kwitansi pembayaran seminar proposal harus berformat PDF',
                'ext_in' => 'Kwitansi pembayaran seminar proposal Anda bukan PDF',
                'max_size' => 'Ukuran file kwitansi terlalu besar, Maksimal 512 kb'
            ]
        ],
        'rekom' => [
            'rules' => 'uploaded[rekom]|mime_in[rekom,application/pdf]|ext_in[rekom,pdf]|max_size[rekom,512]',
            'errors' => [
                'uploaded' => 'Rekomendasi pembimbing mengikuti seminar proposal harus diupload!!',
                'mime_in' => 'Rekomendasi pembimbing mengikuti seminar proposal harus berformat PDF',
                'ext_in' => 'Rekomendasi pembimbing mengikuti seminar proposal Anda bukan PDF',
                'max_size' => 'Rekomendasi pembimbing mengikuti seminar proposal terlalu besar, Maksimal 512 kb'
            ]
        ],
        'plagiasi' => [
            'rules' => 'uploaded[plagiasi]|mime_in[plagiasi,application/pdf]|ext_in[plagiasi,pdf]|max_size[plagiasi,512]',
            'errors' => [
                'uploaded' => 'Surat keterangan bebas plagiasi harus diupload!!',
                'mime_in' => 'Surat keterangan bebas plagiasi harus berformat PDF',
                'ext_in' => 'Surat keterangan bebas plagiasi Anda bukan PDF',
                'max_size' => 'Surat keterangan bebas plagiasi terlalu besar, Maksimal 512 kb'
            ]
        ],
        'proposal' => [
            'rules' => 'uploaded[proposal]|mime_in[proposal,application/pdf]|ext_in[proposal,pdf]|max_size[proposal,2048]',
            'errors' => [
                'uploaded' => 'File proposal harus diupload!!',
                'mime_in' => 'File proposal harus berformat PDF',
                'ext_in' => 'File proposal Anda bukan PDF',
                'max_size' => 'File proposal terlalu besar, Maksimal 2 Mb'
            ]
        ]
    ];
    
    $kwitansi = $this->request->getFile('kwitansi');
    $rekom = $this->request->getFile('rekom');
    $plagiasi = $this->request->getFile('plagiasi');
    $proposal = $this->request->getFile('proposal');
    
    if(!$this->validate($aturan)){
        return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
    }else{
     $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk')])['id_data_diri']])['Nama_Lengkap']);
     if($kwitansi->getName()){
       $nm_file = $kwitansi->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/seminar_proposal";
       $post_kwitansi = base_url().'/'.$path.'/'.$nm_file;
       $kwitansi->move($path, $nm_file);
   }
   if($rekom->getName()){
       $nm_file = $rekom->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/seminar_proposal";
       $post_rekom = base_url().'/'.$path.'/'.$nm_file;
       $rekom->move($path, $nm_file);
   }
   if($plagiasi->getName()){
       $nm_file = $plagiasi->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/seminar_proposal";
       $post_plagiasi = base_url().'/'.$path.'/'.$nm_file;
       $plagiasi->move($path, $nm_file);
   }
   if($proposal->getName()){
       $nm_file = $proposal->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/seminar_proposal";
       $post_proposal = base_url().'/'.$path.'/'.$nm_file;
       $proposal->move($path, $nm_file);
   }
   $record = [
    'tahun' => getDataRow('tahun_akademik', ['aktif' => 'y'])['kode'],
    'id_his_pdk' => $this->request->getVar('id_his_pdk'),
    'id_dosen' => $this->request->getVar('pembimbing'),
    'judul' => $this->request->getVar('judul-part-inp'),
    'rumusan' => $this->request->getVar('rumusan-part-inp'),
    'metode_penelitian' => $this->request->getVar('metode-part-inp'),
    'latar_konteks' => $this->request->getVar('latar-part-inp'),
    'tujuan' => $this->request->getVar('tujuan-part-inp'),
    'kajian_terdahulu' => $this->request->getVar('kajian-part-inp'),
    'konsep_teori' => $this->request->getVar('konsep-part-inp'),
    'rencana_pembahasan' => $this->request->getVar('sistematika-part-inp'),
    'daftar_pustaka' => $this->request->getVar('pustaka-part-inp'),
    'kwitansi' => $post_kwitansi,
    'rekom' => $post_rekom,
    'proposal' => $post_proposal,
    'plagiasi' => $post_plagiasi,
];
$aksi = $this->proposal->simpanData($record);
if($aksi){
    return json_encode(array("msg" => "success", "pesan" => "Formulir pendaftaran seminar proposal berhasil disimpan."));
}else{
    return json_encode(array("msg" => "error", "pesan" => "Formulir pendaftaran seminar proposal gagal disimpan."));
}
}
}

$data['templateJudul'] = "Formulir Pendaftaran Seminar ".$this->halaman_label;
$data['controller'] = $this->halaman_controller;
$data['metode']    = 'formulir';
return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
}

function upload_berkas_revisi()
{
    if($this->request->getMethod()=="post"){
        
      $aturan = [
        
        'berkas' => [
            'rules' => 'uploaded[berkas]|ext_in[berkas,pdf,jpg,jpeg,png]|mime_in[berkas,application/pdf,image/jpg,image/jpeg,image/png]',
            'errors' => [
                
                'mime_in' => 'Tipe '.$this->request->getVar('nm_berkas').' file yang anda upload bukan {param}.',
                'uploaded' => 'Pilih file '.$this->request->getVar('nm_berkas').' yang akan diupload',
                'ext_in' => 'Tipe file '.$this->request->getVar('nm_berkas').' yang diijinkan adalah {param}.'
            ],
        ]
    ];
    
    $berkas = $this->request->getFile('berkas');
    if(!$this->validate($aturan)){
        return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
    }else{
     $dtProposal = $this->proposal->find($this->request->getVar('id_sempro'));
			    //dd($dtProposal);
     $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dtProposal['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']);
     if($berkas->getName()){
       $nm_file = $berkas->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/$this->halaman_controller";
       $post_berkas = base_url().'/'.$path.'/'.$nm_file;
       $berkas->move($path, $nm_file);
       if($dtProposal[$this->request->getVar('jenis_berkas')]){
          @unlink(substr($dtProposal[$this->request->getVar('jenis_berkas')],34));
      }
  }
  
  $record = [
    'id' => $dtProposal['id'],
    $this->request->getVar('jenis_berkas') => $post_berkas
];


if($this->proposal->save($record)){
    return json_encode(array("msg" => "success", "pesan" => "File berhasil diupload."));
}else{
    return json_encode(array("msg" => "error", "pesan" => "File gagal diupload."));
}
}
}
}

public function cetak_hasil_seminar()
{
    
    $data['templateJudul'] = "Cetak Hasil Seminar";
    $data['metode']    = 'cetak_hasil_seminar';
    $id_sempro = $this->request->getvar('id');
    $data['proposal']         = $this->proposal->find($id_sempro);
    $data['id_data_diri']      = getDataRow('histori_pddk', ['id_his_pdk' => $data['proposal']['id_his_pdk']])['id_data_diri'];
    
    $writer = new PngWriter();

        // Create QR code
    $dataQr = base_url('tugasakhir/proposal/cetak_hasil_seminar?id=').$id_sempro;
    $qrCode = QrCode::create($dataQr)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));
    
        // Create generic logo
    $logo = Logo::create(FCPATH .'assets/logo_iaibafa.png')
    ->setResizeToWidth(70)
    ->setPunchoutBackground(true)
    ;
    
        // Create generic label
        //$label = Label::create('Label')->setTextColor(new Color(255, 0, 0));
    
        //$result = $writer->write($qrCode, $logo, $label);
    $result = $writer->write($qrCode, $logo);
    
    $data['qrcode'] = $result->getDataUri();
    
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 2,
        'margin_right' => 2,
        'margin_top' => 40,
        'margin_bottom' => 20,]);
    
    $html_berita = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/cetak_berita_sempro",["data" => $data]);
    $html_nilai = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/cetak_nilai_sempro",["data" => $data]);
    $output ="Hasil_Seminar_Proposal_".getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap'].".pdf";
    $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
    $mpdf->defaultheaderline = 0;
    $mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
    $mpdf->SetFooter('Printed @ {DATE j-m-Y}|{PAGENO}/{nb}|<a href="'.base_url('tugasakhir/proposal/cetak_hasil_seminar?id=').$id_sempro.'">IAIBAFA</a>');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        $mpdf->WriteHTML($html_berita);
        $mpdf->WriteHTML('<pagebreak margin-left="2mm" margin-right="2mm" margin-top="40mm" margin-bottom="20mm" />');
        $mpdf->WriteHTML($html_nilai);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');

        //return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function komentar()
    {
        
       $data = [];
       
       if($this->request->getMethod()=="post"){
        
         $cekHasil = getDataRow('hasil_sempro', ['id_sempro' => $this->request->getVar('id_sempro'), 'penguji' => $this->request->getVar('penguji')]);
         if(empty($cekHasil)){
          $record = [
            'id_sempro' => $this->request->getVar('id_sempro'),
            'penguji' => $this->request->getVar('penguji'),
            $this->request->getVar('field') => $this->request->getVar('komentar')
        ];
        
        if(setDataDinamis('hasil_sempro', $record)){
            return json_encode(array("msg" => "success", "pesan" => "Komentar berhasil disimpan."));
        }else{
            return json_encode(array("msg" => "error", "pesan" => "Komentar gagal disimpan."));
        }
    }else{
      $record = [
        $this->request->getVar('field') => $this->request->getVar('komentar')
    ];
    if(updateDataDinamis('hasil_sempro', $record, ['id_hasil_sempro' => $cekHasil['id_hasil_sempro']])){
        return json_encode(array("msg" => "success", "pesan" => "Komentar berhasil disimpan."));
    }else{
        return json_encode(array("msg" => "error", "pesan" => "Komentar gagal disimpan."));
    }
}
}


$data = $this->request->getVar();

$data['templateJudul'] = "Komentar ".$this->request->getVar('konten');
$data['controller'] = $this->halaman_controller;
$data['aktif_menu'] = $this->halaman_controller;
$data['metode']    = 'komentar';

return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
}

function input_nilai()
{
    
   $data = [];
   
   if($this->request->getMethod()=="post"){
    
     $cekHasil = getDataRow('hasil_sempro', ['id_sempro' => $this->request->getVar('id_sempro'), 'penguji' => $this->request->getVar('penguji')]);
     if(empty($cekHasil)){
      if($this->request->getVar('field') == 'nilai'){
          $rules = 'decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]';
      }else{
          $rules = 'permit_empty';
      }
      $aturan = [
        'val' => [
            'rules' => $rules,
            'errors' => [
                'decimal' => 'Nilai harus berupa angka!!',
                'less_than_equal_to' => 'Nilai tidak boleh lebih dari 4.00',
                'greater_than_equal_to' => 'Nilai tidak boleh kurang dari 3.1'
            ]
        ]
    ];
    $record = [
        'id_sempro' => $this->request->getVar('id_sempro'),
        'penguji' => $this->request->getVar('penguji'),
        $this->request->getVar('field') => $this->request->getVar('val')
    ];
    if(!$this->validate($aturan)){
        return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai yang Anda masukkan !!"));
    }else{
        if(setDataDinamis('hasil_sempro', $record)){
            return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
        }else{
            return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
        }
    }
}else{
  if($this->request->getVar('field') == 'nilai'){
      $rules = 'decimal|less_than_equal_to[4]|greater_than_equal_to[3.1]';
  }else{
      $rules = 'permit_empty';
  }
  $aturan = [
    'val' => [
        'rules' => $rules,
        'errors' => [
            'decimal' => 'Nilai harus berupa angka!!',
            'less_than_equal_to' => 'Nilai tidak boleh lebih dari 4.00',
            'greater_than_equal_to' => 'Nilai tidak boleh kurang dari 3.1'
        ]
    ]
];
$record = [
    $this->request->getVar('field') => $this->request->getVar('val')
];
if(!$this->validate($aturan)){
    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai yang Anda masukkan !!"));
}else{
    if(updateDataDinamis('hasil_sempro', $record, ['id_hasil_sempro' => $cekHasil['id_hasil_sempro']])){
        return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
    }else{
        return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
    }
}
}
}


$data = $this->request->getVar();
$data['p1'] = getDataRow('hasil_sempro', ['penguji' => '1', 'id_sempro' => $this->request->getVar('id')]);
$data['p2'] = getDataRow('hasil_sempro', ['penguji' => '2', 'id_sempro' => $this->request->getVar('id')]);

$data['templateJudul'] = "Input Nilai";
$data['controller'] = $this->halaman_controller;
$data['aktif_menu'] = $this->halaman_controller;
$data['metode']    = 'input_nilai';

return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
}

function getKomen()
{
    $komen1 = getDataRow('hasil_sempro', ['id_sempro' => $this->request->getVar('id_sempro'), 'penguji' => '1']);
    $komen2 = getDataRow('hasil_sempro', ['id_sempro' => $this->request->getVar('id_sempro'), 'penguji' => '2']);
    if(!empty($komen1[$this->request->getVar('field')]) || !empty($komen2[$this->request->getVar('field')])){
        echo '
        <div class="info-box bg-light">
        <div class="info-box-content">';
        if(!empty($komen1[$this->request->getVar('field')])){
            echo  '
            <b class="d-block">Komentar Penguji 1</b>
            <div class="post clearfix">';
            
            echo $komen1[$this->request->getVar('field')];
            
            echo '</div>';
        } 
        
        if(!empty($komen2[$this->request->getVar('field')])){
            echo  '
            <b class="d-block">Komentar Penguji 2</b>
            <div class="post clearfix">';
            
            echo $komen2[$this->request->getVar('field')];
            
            echo '</div> ';   
        }
        echo '
        </div>
        </div>
        ';
    }
}

function uploadUlang()
{
    $data = [];
    
    
    if($this->request->getMethod()=="post"){
      
      
      $aturan = [
        
        'berkas' => [
            'rules' => 'uploaded[berkas]|ext_in[berkas,pdf]|mime_in[berkas,application/pdf]|max_size[berkas,4096]',
            'errors' => [
                'max_size' => 'File Anda terlalu besar. Ukuran maksimal yang diijinkan 4 Mb.',
                'mime_in' => 'Tipe file yang anda upload bukan {param}.',
                'uploaded' => 'Pilih file yang akan diupload',
                'ext_in' => 'Tipe file yang diijinkan adalah {param}.'
            ],
        ]
    ];
    
    $berkas = $this->request->getFile('berkas');
    if(!$this->validate($aturan)){
        return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
    }else{
     $dataProposal = $this->proposal->find($this->request->getVar('id'));
     $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dataProposal['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']);
     if($berkas->getName()){
       $nm_file = $berkas->getRandomName();
       $path = "berkas_mahasiswa/$nmFolder/seminar_proposal";
       $post_berkas = base_url().'/'.$path.'/'.$nm_file;
                    //$aksi = $berkas->move($path, $nm_file);
       if($berkas->move($path, $nm_file)){
        @unlink(substr($dataProposal[$this->request->getVar('field')],34));
    }
}
$record = [
    'id' => $this->request->getVar('id'),
    $this->request->getVar('field') => $post_berkas,
    "v_".$this->request->getVar('field') => "0",
];
$aksi = $this->proposal->simpanData($record);
if($aksi){
    return json_encode(array("msg" => "success", "pesan" => "Persyaratan pendaftaran seminar proposal berhasil disimpan."));
}else{
    return json_encode(array("msg" => "error", "pesan" => "Persyaratan pendaftaran seminar proposal gagal disimpan."));
}
}
}
$data = $this->request->getVar() ;
$data['templateJudul'] = "Upload Ulang Persyaratan ".$this->halaman_label;
$data['controller'] = $this->halaman_controller;
$data['metode']    = 'uploadUlang';
return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
}

public function ekspor()
{
    
    
    $list_id = $this->request->getVar('id');
    $dataProp 				= [];
		//$index 				= 0;
    foreach ($list_id as $id ) {
		    //$mk = getDataRow('mata_kuliah',['id' => $id]);
      $prop = $this->proposal->find($id);
      $his_pdk = getDataRow('histori_pddk', ['id_his_pdk' => $prop['id_his_pdk']]);
      
      array_push($dataProp, array(
        'nama_mhs' => getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['Nama_Lengkap'],
        'nim' => $his_pdk['NIM'],
        'prodi' => $his_pdk['Prodi'],
        'judul' => strip_tags($prop['judul']),
        'pembimbing' => getDataRow('data_dosen', ['Kode' => $prop['id_dosen']])['Nama_Dosen']
    ));
      
  }

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $style_col = [
          'font' => ['bold' => true], // Set font nya jadi bold
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
        ]
    ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = [
      'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
        ]
    ];
    
        $sheet->setCellValue('A1', "DATA PROPOSAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:AU1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        $sheet->setCellValue('A2', "No"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('A2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('A2')->applyFromArray($style_col);
        
        $sheet->setCellValue('B2', "NAMA MAHASISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('B2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('B2')->applyFromArray($style_col);
        
        $sheet->setCellValue('C2', "NIM"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('C2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('C2')->applyFromArray($style_col);
        
        $sheet->setCellValue('D2', "PRODI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('D2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('D2')->applyFromArray($style_col);
        
        $sheet->setCellValue('E2', "JUDUL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('E2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('E2')->applyFromArray($style_col);
        
        $sheet->setCellValue('F2', "PEMBIMBING"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('F2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('F2')->applyFromArray($style_col);
        
        $sheet->setCellValue('G2', "PENGUJI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('G2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('G2')->applyFromArray($style_col);
        
        $sheet->setCellValue('H2', "WAKTU"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('H2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('H2')->applyFromArray($style_col);
        
        $sheet->setCellValue('I2', "MAJELIS / RUANG"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('I2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('I2')->applyFromArray($style_col);
        
        
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 3; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($dataProp as $data){ // Lakukan looping pada variabel siswa
            
          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $data['nama_mhs']);
          $sheet->setCellValue('C'.$numrow, $data['nim']);
          $sheet->setCellValue('D'.$numrow, $data['prodi']);
          $sheet->setCellValue('E'.$numrow, strtoupper($data['judul']));
          $sheet->setCellValue('F'.$numrow, $data['pembimbing']);
          $sheet->setCellValue('G'.$numrow, '');
          $sheet->setCellValue('H'.$numrow, '');
          $sheet->setCellValue('I'.$numrow, '');
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
          $sheet->getStyle('I'.$numrow)->applyFromArray($style_row); 
          
          $no++; // Tambah 1 setiap kali looping
          $numrow++; // Tambah 1 setiap kali looping
      }
      
      for($i='A'; $i != $sheet->getHighestColumn(); $i++){
        $sheet->getColumnDimension($i)->setAutoSize(true);
    }
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya Maksimum 31 karakter
    $sheet->setTitle("DATA PROPOSAL");
    $sheet->getStyle('A:AY')->getNumberFormat()->setFormatCode('@');
    $writer = new Xlsx($spreadsheet);
    $filename = date('Y-m-d-His'). '-Data-Proposal';

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header('Content-Disposition: attachment; filename='.$filename.'.xlsx');
		//$writer = new Xlsx($spreadsheet);
    ob_start();
    $writer->save('php://output');
    
    $xlsData = ob_get_contents();
    ob_end_clean();
    
    $response =  array(
        'nama_file' => $filename.'.xlsx',
        'op' => 'ok',
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );
    
    die(json_encode($response));
}

}
