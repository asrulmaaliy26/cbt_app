<?php

namespace App\Controllers\Admin\Tugasakhir;

use App\Controllers\BaseController;
use App\Models\SkripsiModel;
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

class Skripsi extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->validation = \Config\Services::validation();
        $this->skripsi = new SkripsiModel($request);
        $this->halaman_controller = "skripsi";
        $this->halaman_label = "Skripsi";
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
                $dt = $this->skripsi->find($this->request->getVar('id'));
                if($dt['id_munaqasyah']){ #memastikan ada data
                    $cekPenguji = dataDinamis('penguji_skripsi', ['id_munaqasyah' => $dt['id_munaqasyah']]);
                    $cekHasil = dataDinamis('hasil_skripsi', ['id_munaqasyah' => $dt['id_munaqasyah']]);
                    
                    $aksi = $this->skripsi->delete($this->request->getVar('id'));
                    if($aksi == true){
                        if(!empty($cekPenguji)){
                            deleteDataDinamis('penguji_skripsi', ['id_munaqasyah' => $dt['id_munaqasyah']]);
                        }
                        if(!empty($cekHasil)){
                            deleteDataDinamis('hasil_skripsi', ['id_munaqasyah' => $dt['id_munaqasyah']]);
                        }
                        
                        @unlink(substr($dt['kwitansi_pendaftaran'],34));
                        @unlink(substr($dt['bebas_bak'],34));
                        @unlink(substr($dt['ktm'],34));
                        @unlink(substr($dt['khs'],34));
                        @unlink(substr($dt['kartu_bimbingan'],34));
                        @unlink(substr($dt['persetujuan_munaqasyah'],34));
                        @unlink(substr($dt['posmaru'],34));
                        @unlink(substr($dt['sertifikat_kkn'],34));
                        @unlink(substr($dt['ppl'],34));
                        @unlink(substr($dt['sertifikat_seminar'],34));
                        @unlink(substr($dt['toefl_toafl'],34));
                        @unlink(substr($dt['plagiasi'],34));
                        @unlink(substr($dt['kuesioner'],34));
                        @unlink(substr($dt['skripsi'],34));
                        @unlink(substr($dt['powerpoint'],34));
                        @unlink(substr($dt['bag_depan'],34));
                        @unlink(substr($dt['bab1'],34));
                        @unlink(substr($dt['bab2'],34));
                        @unlink(substr($dt['bab3'],34));
                        @unlink(substr($dt['bab4'],34));
                        @unlink(substr($dt['bab5'],34));
                        @unlink(substr($dt['bab6'],34));
                        @unlink(substr($dt['pustaka'],34));
                        @unlink(substr($dt['lampiran'],34));
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
            $lists = $this->skripsi->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $link_detail= site_url("tugasakhir/$this->halaman_controller/detail?id=").$list->id_munaqasyah;
                if($list->status=='1'){
    			    $status= '<span class="badge badge-success">Diterima</span>';
    			}elseif($list->status=='2'){
    			    $status= '<span class="badge badge-danger">Ditolak</span>';
    			}elseif($list->status=='3'){
    			    $status= '<span class="badge badge-primary">Menunggu Koraksi</span>';
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
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_munaqasyah.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags($list->judul_skripsi);
                $row[] = (!empty($list->dosen_pembimbing))?getDataRow('data_dosen', ['Kode' => $list->dosen_pembimbing])['Nama_Dosen']:'';
                $row[] = $status;
                $row[] = $list->tgl_dibuat/*tgl_indonesia_short($list->tgl_dibuat)*/;
                    if(session()->get('akun_level') == "Admin" || session()->get('akun_level') == "Panitia Tugas Akhir"){
                        $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Skripsi"><i class="fa fa-eye"></i></a>
                                <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_skripsi?id=$list->id_munaqasyah', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                                <a onclick="hapus('."'".$list->id_munaqasyah."','".str_replace("'", "`",$list->Nama_Lengkap)."'".'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus Skripsi"><i class="fa fa-trash"></i></a>
                                ';
                    }else{
                        $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Skripsi"><i class="fa fa-eye"></i></a>
                            <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_skripsi?id=$list->id_munaqasyah', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                            ';
                    }
                }
                if(session()->get('akun_level') == "Mahasiswa"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_munaqasyah.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = strip_tags($list->judul_skripsi);
                $row[] = (!empty($list->dosen_pembimbing))?getDataRow('data_dosen', ['Kode' => $list->dosen_pembimbing])['Nama_Dosen']:'';
                $row[] = $status;
                $row[] = $list->tgl_dibuat/*tgl_indonesia_short($list->tgl_dibuat)*/;
                $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Skripsi"><i class="fa fa-eye"></i></a>
                        <a onclick="window.open('."'".base_url()."/tugasakhir/$this->halaman_controller/cetak_hasil_skripsi?id=$list->id_munaqasyah', '', 'width=800, height=600, status=1,scrollbar=yes'".'); return false;" class="btn btn-xs btn-success" data-placement="top" title="Cetak Hasil Seminar"><i class="fa fa-print"></i></a>    
                            
                            ';
                }
                if(session()->get('akun_level') == "Dosen"){
                $row[] = '<input type="checkbox" class="data-check" name="check" value="'.$list->id_munaqasyah.'" />';
                $row[] = $no;
                $row[] = getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['tahunAkademik']." ".(getDataRow('tahun_akademik',['kode'=>$list->tahun_akademik])['semester'] == '1'?'Gasal':'Genap');
                $row[] = $list->Nama_Lengkap;
                $row[] = $list->Prodi;
                $row[] = strip_tags($list->judul_skripsi);
                $row[] = (!empty($list->dosen_pembimbing))?getDataRow('data_dosen', ['Kode' => $list->dosen_pembimbing])['Nama_Dosen']:'';
                $row[] = 'Ke-'.getDataRow('penguji_skripsi', ['id_munaqasyah'=>$list->id_munaqasyah, 'kd_dosen' => $this->request->getVar('kd_dosen')])['tugas'];
                $row[] = $status;
                $row[] = '<a href="'.$link_detail.'" target="_blank" class="btn btn-xs btn-primary" data-placement="top" title="Detail Skripsi"><i class="fa fa-eye"></i></a>
                    
                    ';
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->skripsi->countAll(),
                'recordsFiltered' => $this->skripsi->countFiltered(),
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
			$data = $this->skripsi->find($this->request->getVar('id'));
			$data['id_data_diri'] = getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['id_data_diri'];
		}
		if(session()->get('akun_level') == "Dosen"){
		    $kd_dosen = getDataRow('data_dosen',['username'=>session()->get('akun_username')])['Kode'];
		    $data['penguji'] = getDataRow('penguji_skripsi', ['id_munaqasyah'=>$this->request->getVar('id'), 'kd_dosen' => $kd_dosen])['tugas'];
		    $data['hasil'] = getDataRow('hasil_skripsi', ['id_munaqasyah'=>$this->request->getVar('id'), 'penguji' => $data['penguji']]);
		}
		
        $data['templateJudul'] = $this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'detail';
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    public function getValidasi()
    {
		
		$id = $this->request->getVar('id');	
		$field = $this->request->getVar('field');
		
		$data = getDataRow('munaqasyah_skripsi', ['id_munaqasyah' => $id])[$field];

        return json_encode(array('nilai'=>$data,'field'=>$field));
		
    }
    
    public function validasi()
    {
		
		if($this->request->getMethod()=="post"){
		    
            $record = [
                'id_munaqasyah' => $this->request->getVar('id'),
                $this->request->getVar('field') => $this->request->getVar('nilai')
            ];
            $aksi = $this->skripsi->simpanData($record);
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
                'id_munaqasyah' => $this->request->getVar('id'),
                $this->request->getVar('field') => $this->request->getVar('catatan')
            ];
            $aksi = $this->skripsi->simpanData($record);
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
		    $cekPenguji = getDataRow('penguji_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'tugas' => $this->request->getVar('tugas')]);
		    if(empty($cekPenguji)){
		        $record = [
                    'id_munaqasyah' => $this->request->getVar('id_munaqasyah'),
                    'tugas' => $this->request->getVar('tugas'),
                    'kd_dosen' => $this->request->getVar('kd_dosen')
                ];
                
                if(setDataDinamis('penguji_skripsi', $record)){
                    return json_encode(array("msg" => "success", "pesan" => "Penguji berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Penguji gagal disimpan."));
                }
		    }else{
		        $record = [
                    
                    'kd_dosen' => $this->request->getVar('kd_dosen')
                ];
                if(updateDataDinamis('penguji_skripsi', $record, ['id_penguji' => $cekPenguji['id_penguji']])){
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
                'abstrak-part-inp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Abstrak tidak boleh kosong!!',
                        //'min_length' => 'Abstrak tidak boleh kurang dari 1000 karakter!!'
                    ]
                ],
                'kesimpulan-part-inp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Rumusan malasah / fokus penelitian tidak boleh kosong!!',
                        //'min_length' => 'Kesimpulan tidak boleh kurang dari 1000 karakter!!'
                    ]
                ],
                'dosen_pembimbing' => [
                    'rules' => 'required',
                    'errors' => [
                        'required'=>'Pembimbing tidak boleh kosong!!'
                    ]
                ],
                
                'kwitansi_pendaftaran' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kwitansi pendaftaran munaqasyah skripsi harus diupload!!',
                    ]
                ],
                'bebas_bak' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Surat Keterangan Bebas Tanggungan dari BAK harus diupload!!',
                    ]
                ],
                'ktm' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kartu Tanda Mahasiswa (KTM) harus diupload!!',
                    ]
                ],
                'khs' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'KHS Semester 1 s.d 7 dengan nilai Lulus harus diupload!!',
                    ]
                ],
                'kartu_bimbingan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kartu bimbingan harus diupload!!',
                    ]
                ],
                'persetujuan_munaqasyah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lembar Persetujuan Munaqasyah harus diupload!!',
                    ]
                ],
                'posmaru' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Sertifikat PBAK harus diupload!!',
                    ]
                ],
                'sertifikat_kkn' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Sertifikat KKN harus diupload!!',
                    ]
                ],
                'ppl' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Sertifikat PPL harus diupload!!',
                    ]
                ],
                'sertifikat_seminar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Sertifikat Seminar 3 kegiatan harus diupload!!',
                    ]
                ],
                'toefl_toafl' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Sertifikat TOEFL / TOAFL harus diupload!!',
                    ]
                ],
                'plagiasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Surat keterangan bebas plagiasi dari LPJI harus diupload!!',
                    ]
                ],
                'kuesioner' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angket kuesioner bimbingan tugas akhir harus diupload!!',
                    ]
                ],
                'skripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angket kuesioner bimbingan tugas akhir harus diupload!!',
                    ]
                ],
                'powerpoint' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Powerpoint presentasi harus diupload!!',
                    ]
                ],
                'bag_depan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bagian halaman depan skripsi harus diupload!!',
                    ]
                ],
                'bab1' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'BAB I harus diupload!!',
                    ]
                ],
                'bab2' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'BAB II harus diupload!!',
                    ]
                ],
                'bab3' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'BAB III harus diupload!!',
                    ]
                ],
                'bab4' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'BAB IV harus diupload!!',
                    ]
                ],
                'bab5' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'BAB V harus diupload!!',
                    ]
                ],
                'pustaka' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Daftar pustaka harus diupload!!',
                    ]
                ]
            ];
            
            
            if(!$this->validate($aturan)){
                return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali formulir Anda!!"));
			}else{
			    
                $record = [
                    'tahun_akademik' => getDataRow('tahun_akademik', ['aktif' => 'y'])['kode'],
                    'id_his_pdk' => $this->request->getVar('id_his_pdk'),
                    'dosen_pembimbing' => $this->request->getVar('dosen_pembimbing'),
                    'judul_skripsi' => $this->request->getVar('judul-part-inp'),
                    'abstrak' => $this->request->getVar('abstrak-part-inp'),
                    'kesimpulan' => $this->request->getVar('kesimpulan-part-inp'),
                    'kwitansi_pendaftaran' => $this->request->getVar('kwitansi_pendaftaran'),
                    'bebas_bak' => $this->request->getVar('bebas_bak'),
                    'ktm' => $this->request->getVar('ktm'),
                    'khs' => $this->request->getVar('khs'),
                    'kartu_bimbingan' => $this->request->getVar('kartu_bimbingan'),
                    'persetujuan_munaqasyah' => $this->request->getVar('persetujuan_munaqasyah'),
                    'posmaru' => $this->request->getVar('posmaru'),
                    'sertifikat_kkn' => $this->request->getVar('sertifikat_kkn'),
                    'ppl' => $this->request->getVar('ppl'),
                    'sertifikat_seminar' => $this->request->getVar('sertifikat_seminar'),
                    'toefl_toafl' => $this->request->getVar('toefl_toafl'),
                    'plagiasi' => $this->request->getVar('plagiasi'),
                    'kuesioner' => $this->request->getVar('kuesioner'),
                    'skripsi' => $this->request->getVar('skripsi'),
                    'powerpoint' => $this->request->getVar('powerpoint'),
                    'bag_depan' => $this->request->getVar('bag_depan'),
                    'bab1' => $this->request->getVar('bab1'),
                    'bab2' => $this->request->getVar('bab2'),
                    'bab3' => $this->request->getVar('bab3'),
                    'bab4' => $this->request->getVar('bab4'),
                    'bab5' => $this->request->getVar('bab5'),
                    'bab6' => $this->request->getVar('bab6'),
                    'pustaka' => $this->request->getVar('pustaka'),
                    'lampiran' => $this->request->getVar('lampiran'),
                ];
                $aksi = $this->skripsi->simpanData($record);
                if($aksi){
                    return json_encode(array("msg" => "success", "pesan" => "Formulir pendaftaran munaqasyah skripsi berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Formulir pendaftaran munaqasyah skripsi gagal disimpan."));
                }
			}
        }
         
        $data['templateJudul'] = "Formulir Pendaftaran Munaqasyah ".$this->halaman_label;
        $data['controller'] = $this->halaman_controller;
        $data['metode']    = 'formulir';
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function upload_berkas()
    {
        if($this->request->getMethod()=="post"){
            $rules = 'uploaded[berkas]|ext_in[berkas,pdf,jpg,jpeg]|mime_in[berkas,application/pdf,image/jpg,image/jpeg]|max_size[berkas,1024]';
		    
		    if($this->request->getVar('jenis_berkas') == 'bag_depan' || $this->request->getVar('jenis_berkas') == 'bab1' || $this->request->getVar('jenis_berkas') == 'bab2' || $this->request->getVar('jenis_berkas') == 'bab3' || $this->request->getVar('jenis_berkas') == 'bab4' || $this->request->getVar('jenis_berkas') == 'bab5' || $this->request->getVar('jenis_berkas') == 'lampiran' || $this->request->getVar('jenis_berkas') == 'bab6' || $this->request->getVar('jenis_berkas') == 'pustaka'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,doc,docx,rtf]|mime_in[berkas,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/rtf]';
		    }
		    if($this->request->getVar('jenis_berkas') == 'powerpoint'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,pptx,ppt]|mime_in[berkas,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint]';
		    }
		    if($this->request->getVar('jenis_berkas') == 'skripsi'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,pdf]|mime_in[berkas,application/pdf]';
		    }
		    $aturan = [
                
                'berkas' => [
                    'rules' => $rules,
                    'errors' => [
                        'max_size' => 'File '.$this->request->getVar('nm_berkas').' Anda terlalu besar. Ukuran maksimal yang diijinkan 1 Mb.',
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
			    
			    $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $this->request->getVar('id_his_pdk_upload')])['id_data_diri']])['Nama_Lengkap']);
                if($berkas->getName()){
					$nm_file = $berkas->getRandomName();
                    $path = "berkas_mahasiswa/$nmFolder/$this->halaman_controller";
                    $post_berkas = base_url().'/'.$path.'/'.$nm_file;
                    $aksi = $berkas->move($path, $nm_file);
				}
                
                if($aksi){
                    return json_encode(array("msg" => "success", "pesan" => "File berhasil diupload.", "link" => $post_berkas));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "File gagal diupload."));
                }
			}
        }
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
			    $dtSkripsi = $this->skripsi->find($this->request->getVar('id_munaqasyah'));
			    //dd($dtProposal);
			    $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dtSkripsi['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']);
                if($berkas->getName()){
					$nm_file = $berkas->getRandomName();
                    $path = "berkas_mahasiswa/$nmFolder/$this->halaman_controller";
                    $post_berkas = base_url().'/'.$path.'/'.$nm_file;
                    $berkas->move($path, $nm_file);
                    if($dtSkripsi[$this->request->getVar('jenis_berkas')]){
						@unlink(substr($dtSkripsi[$this->request->getVar('jenis_berkas')],34));
					}
				}
				
				$record = [
				    'id_munaqasyah' => $dtSkripsi['id_munaqasyah'],
				    $this->request->getVar('jenis_berkas') => $post_berkas
				];
				
                
                if($this->skripsi->save($record)){
                    return json_encode(array("msg" => "success", "pesan" => "File berhasil diupload."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "File gagal diupload."));
                }
			}
        }
    }
    
    public function cetak_hasil_skripsi()
    {
        
        $data['templateJudul'] = "Cetak Hasil Munaqasyah Skripsi";
        $data['metode']    = 'cetak_hasil_skripsi';
        $id_munaqasyah = $this->request->getvar('id');
        $data['skripsi']         = $this->skripsi->find($id_munaqasyah);
		$data['id_data_diri']      = getDataRow('histori_pddk', ['id_his_pdk' => $data['skripsi']['id_his_pdk']])['id_data_diri'];
		
		$writer = new PngWriter();

        // Create QR code
        $dataQr = base_url('tugasakhir/skripsi/cetak_hasil_skripsi?id=').$id_munaqasyah;
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
        
        $html_berita = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/cetak_berita_skripsi",["data" => $data]);
        $html_nilai = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/cetak_nilai_skripsi",["data" => $data]);
        $html_kesanggupan = view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/cetak_lembar_kesanggupan_revisi",["data" => $data]);
        $output ="Hasil_Munaqasyah_Skripsi_".getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap'].".pdf";
        $stylesheet = file_get_contents('./assets/mpdfstyletables.css');
        $mpdf->defaultheaderline = 0;
        $mpdf->SetHeader("<div ><img src='".base_url()."/assets/kop.jpg'></div>");
        $mpdf->SetFooter('Printed @ {DATE j-m-Y}|{PAGENO}/{nb}|<a href="'.base_url('tugasakhir/skripsi/cetak_hasil_skripsi?id=').$id_munaqasyah.'">IAIBAFA</a>');
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        //$mpdf->SetHTMLHeader($htmlHeader);
        
        $mpdf->WriteHTML($html_berita);
        $mpdf->WriteHTML('<pagebreak margin-left="2mm" margin-right="2mm" margin-top="40mm" margin-bottom="20mm" />');
		$mpdf->WriteHTML($html_nilai);
		$mpdf->WriteHTML('<pagebreak margin-left="2mm" margin-right="2mm" margin-top="40mm" margin-bottom="20mm" />');
		$mpdf->WriteHTML($html_kesanggupan);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($output,'I');

        //return view(session()->get('akun_group_folder')."/akademik/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function komentar()
    {
        
	    $data = [];
        
        if($this->request->getMethod()=="post"){
            
           $cekHasil = getDataRow('hasil_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'penguji' => $this->request->getVar('penguji')]);
		    if(empty($cekHasil)){
		        $record = [
                    'id_munaqasyah' => $this->request->getVar('id_munaqasyah'),
                    'penguji' => $this->request->getVar('penguji'),
                    $this->request->getVar('field') => $this->request->getVar('komentar')
                ];
                
                if(setDataDinamis('hasil_skripsi', $record)){
                    return json_encode(array("msg" => "success", "pesan" => "Komentar berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Komentar gagal disimpan."));
                }
		    }else{
		        $record = [
                    $this->request->getVar('field') => $this->request->getVar('komentar')
                ];
                if(updateDataDinamis('hasil_skripsi', $record, ['id_hasil_skripsi' => $cekHasil['id_hasil_skripsi']])){
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
    
    function getKomen()
    {
        $komen1 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'penguji' => '1']);
        $komen2 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'penguji' => '2']);
        $komen3 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'penguji' => '3']);
        if(!empty($komen1[$this->request->getVar('field')]) || !empty($komen2[$this->request->getVar('field')]) || !empty($komen3[$this->request->getVar('field')])){
        
            if(!empty($komen1[$this->request->getVar('field')])){
                echo  '
                <b class="d-block">Penguji 1</b>
                  <div class="post clearfix">';
                      
                        echo $komen1[$this->request->getVar('field')];
                      
                echo '</div>';
            } 
          
            if(!empty($komen2[$this->request->getVar('field')])){
                echo  '
                    <b class="d-block">Penguji 2</b>
                    <div class="post clearfix">';
              
                        echo $komen2[$this->request->getVar('field')];
              
                echo '</div> ';   
            }
            
            if(!empty($komen3[$this->request->getVar('field')])){
                echo  '
                    <b class="d-block">Sekretaris</b>
                    <div class="post clearfix">';
              
                        echo $komen3[$this->request->getVar('field')];
              
                echo '</div> ';   
            }
        
        }
    }
    
    function input_nilai()
    {
        
	    $data = [];
        
        if($this->request->getMethod()=="post"){
            
           $cekHasil = getDataRow('hasil_skripsi', ['id_munaqasyah' => $this->request->getVar('id_munaqasyah'), 'penguji' => $this->request->getVar('penguji')]);
		    if(empty($cekHasil)){
		        if($this->request->getVar('field') == 'penyampaian'){
		            $rules = 'decimal|less_than_equal_to[10]|greater_than_equal_to[1]';
		        }elseif($this->request->getVar('field') == 'penulisan' || $this->request->getVar('field') == 'metode'){
		            $rules = 'decimal|less_than_equal_to[25]|greater_than_equal_to[1]';
		        }elseif($this->request->getVar('field') == 'konten'){
		            $rules = 'decimal|less_than_equal_to[40]|greater_than_equal_to[1]';
		        }
		        $aturan = [
                    'val' => [
                        'rules' => $rules,
                        'errors' => [
                            'decimal' => 'Nilai '.$this->request->getVar('field').' harus berupa angka!!',
                            'less_than_equal_to' => 'Nilai '.$this->request->getVar('field').' tidak boleh lebih dari {param}',
                            'greater_than_equal_to' => 'Nilai '.$this->request->getVar('field').' tidak boleh kurang dari {param}'
                        ]
                    ]
                ];
		        $record = [
                    'id_munaqasyah' => $this->request->getVar('id_munaqasyah'),
                    'penguji' => $this->request->getVar('penguji'),
                    $this->request->getVar('field') => $this->request->getVar('val')
                ];
                if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai yang Anda masukkan !!"));
                }else{
                    if(setDataDinamis('hasil_skripsi', $record)){
                        return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
                    }
                }
		    }else{
		        if($this->request->getVar('field') == 'penyampaian'){
		            $rules = 'decimal|less_than_equal_to[10]|greater_than_equal_to[1]';
		        }elseif($this->request->getVar('field') == 'penulisan' || $this->request->getVar('field') == 'metode'){
		            $rules = 'decimal|less_than_equal_to[25]|greater_than_equal_to[1]';
		        }elseif($this->request->getVar('field') == 'konten'){
		            $rules = 'decimal|less_than_equal_to[40]|greater_than_equal_to[1]';
		        }
		        $aturan = [
                    'val' => [
                        'rules' => $rules,
                        'errors' => [
                            'decimal' => 'Nilai '.$this->request->getVar('field').' harus berupa angka!!',
                            'less_than_equal_to' => 'Nilai '.$this->request->getVar('field').' tidak boleh lebih dari {param}',
                            'greater_than_equal_to' => 'Nilai '.$this->request->getVar('field').' tidak boleh kurang dari {param}'
                        ]
                    ]
                ];
		        $record = [
                    $this->request->getVar('field') => $this->request->getVar('val')
                ];
                if(!$this->validate($aturan)){
                    return json_encode(array("msg" => "warning", "validation" => $this->validation->getErrors(), "pesan" => "Periksa kembali Nilai yang Anda masukkan !!"));
                }else{
                    if(updateDataDinamis('hasil_skripsi', $record, ['id_hasil_skripsi' => $cekHasil['id_hasil_skripsi']])){
                        return json_encode(array("msg" => "success", "pesan" => "Data berhasil disimpan."));
                    }else{
                        return json_encode(array("msg" => "error", "pesan" => "Data gagal disimpan."));
                    }
                }
		    }
        }
	    
	    
	    $data = $this->request->getVar();
	    $data['p1'] = getDataRow('hasil_skripsi', ['penguji' => '1', 'id_munaqasyah' => $this->request->getVar('id')]);
	    $data['p2'] = getDataRow('hasil_skripsi', ['penguji' => '2', 'id_munaqasyah' => $this->request->getVar('id')]);
	    
	    $data['templateJudul'] = "Input Nilai";
        $data['controller'] = $this->halaman_controller;
        $data['aktif_menu'] = $this->halaman_controller;
        $data['metode']    = 'input_nilai';
        
        return view(session()->get('akun_group_folder')."/tugasakhir/$this->halaman_controller/".$data['metode'], $data);
    }
    
    function uploadUlang()
    {
        $data = [];
        
		
		if($this->request->getMethod()=="post"){
		    
		    $rules = 'uploaded[berkas]|ext_in[berkas,pdf,jpg,jpeg]|mime_in[berkas,application/pdf,image/jpg,image/jpeg]|max_size[berkas,1024]';
		    
		    if($this->request->getVar('field') == 'bag_depan' || $this->request->getVar('field') == 'bab1' || $this->request->getVar('field') == 'bab2' || $this->request->getVar('field') == 'bab3' || $this->request->getVar('field') == 'bab4' || $this->request->getVar('field') == 'bab5' || $this->request->getVar('field') == 'lampiran' || $this->request->getVar('field') == 'bab6' || $this->request->getVar('field') == 'pustaka'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,doc,docx,rtf]|mime_in[berkas,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/rtf]';
		    }
		    if($this->request->getVar('field') == 'powerpoint'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,pptx,ppt]|mime_in[berkas,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint]';
		    }
		    if($this->request->getVar('field') == 'skripsi'){
		        $rules = 'uploaded[berkas]|ext_in[berkas,pdf]|mime_in[berkas,application/pdf]';
		    }
		    $aturan = [
                
                'berkas' => [
                    'rules' => $rules,
                    'errors' => [
                        'max_size' => 'File Anda terlalu besar. Ukuran maksimal yang diijinkan 1 Mb.',
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
			    $dataSkripsi = $this->skripsi->find($this->request->getVar('id_munaqasyah'));
			    $nmFolder    = str_replace( "'", "", getDataRow('db_data_diri_mahasiswa', ['id' => getDataRow('histori_pddk', ['id_his_pdk' => $dataSkripsi['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']);
                if($berkas->getName()){
					$nm_file = $berkas->getRandomName();
                    $path = "berkas_mahasiswa/$nmFolder/$this->halaman_controller";
                    $post_berkas = base_url().'/'.$path.'/'.$nm_file;
                    //$aksi = $berkas->move($path, $nm_file);
                    if($berkas->move($path, $nm_file)){
                        @unlink(substr($dataSkripsi[$this->request->getVar('field')],34));
                    }
				}
                $record = [
                    'id_munaqasyah' => $this->request->getVar('id_munaqasyah'),
                    $this->request->getVar('field') => $post_berkas,
                    "v_".$this->request->getVar('field') => "0",
                ];
                if($this->request->getVar('field') == 'kwitansi_pendaftaran'){
                    $record = [
                    'id_munaqasyah' => $this->request->getVar('id_munaqasyah'),
                    $this->request->getVar('field') => $post_berkas,
                    "v_kwitansi" => "0",
                ];
                }
                $aksi = $this->skripsi->simpanData($record);
                if($aksi){
                    return json_encode(array("msg" => "success", "pesan" => "Persyaratan pendaftaran munaqasyah skripsi berhasil disimpan."));
                }else{
                    return json_encode(array("msg" => "error", "pesan" => "Persyaratan pendaftaran munaqasyah skripsi gagal disimpan."));
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
		$dataSkripsi 				= [];
		//$index 				= 0;
		foreach ($list_id as $id ) {
		    //$mk = getDataRow('mata_kuliah',['id' => $id]);
		    $skripsi = $this->skripsi->find($id);
		    $his_pdk = getDataRow('histori_pddk', ['id_his_pdk' => $skripsi['id_his_pdk']]);
		    
			array_push($dataSkripsi, array(
				'nama_mhs' => getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['Nama_Lengkap'],
				'nim' => $his_pdk['NIM'],
				'prodi' => $his_pdk['Prodi'],
				'judul' => strip_tags($skripsi['judul_skripsi']),
				'pembimbing' => getDataRow('data_dosen', ['Kode' => $skripsi['dosen_pembimbing']])['Nama_Dosen']
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
        
        $sheet->setCellValue('A1', "DATA SKRIPSI"); // Set kolom A1 dengan tulisan "DATA SISWA"
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
        
        $sheet->setCellValue('G2', "PENGUJI 1"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('G2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('G2')->applyFromArray($style_col);
        
        $sheet->setCellValue('H2', "PENGUJI 2"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('H2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('H2')->applyFromArray($style_col);
        
        $sheet->setCellValue('I2', "KETUA & SEKRETARIS"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('I2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('I2')->applyFromArray($style_col);
        
        $sheet->setCellValue('J2', "WAKTU"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('J2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('J2')->applyFromArray($style_col);
        
        $sheet->setCellValue('K2', "MAJELIS / RUANG"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->getStyle('K2')->getFont()->setBold(true); // Set bold kolom A1
        $sheet->getStyle('K2')->applyFromArray($style_col);
        
        
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 3; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($dataSkripsi as $data){ // Lakukan looping pada variabel siswa
            
          $sheet->setCellValue('A'.$numrow, $no);
          $sheet->setCellValue('B'.$numrow, $data['nama_mhs']);
          $sheet->setCellValue('C'.$numrow, $data['nim']);
          $sheet->setCellValue('D'.$numrow, $data['prodi']);
          $sheet->setCellValue('E'.$numrow, strtoupper($data['judul']));
          $sheet->setCellValue('F'.$numrow, $data['pembimbing']);
          $sheet->setCellValue('G'.$numrow, '');
          $sheet->setCellValue('H'.$numrow, '');
          $sheet->setCellValue('I'.$numrow, '');
          $sheet->setCellValue('J'.$numrow, '');
          $sheet->setCellValue('K'.$numrow, '');
          
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
        $sheet->getStyle('J'.$numrow)->applyFromArray($style_row); 
        $sheet->getStyle('K'.$numrow)->applyFromArray($style_row); 
          
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
        $sheet->setTitle("DATA SKRIPSI");
        $sheet->getStyle('A:AY')->getNumberFormat()->setFormatCode('@');
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-Data-Skripsi';

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
