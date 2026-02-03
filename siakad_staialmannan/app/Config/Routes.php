<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Home');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index',['filter'=>'noauth']);
$routes->post('login','Login::index');
$routes->get('logout','Login::logout');
$routes->get('lupapassword','Login::lupapassword',['filter'=>'noauth']);
$routes->post('lupapassword','Login::lupapassword');
$routes->get('resetpassword','Login::resetpassword',['filter'=>'noauth']);
$routes->post('resetpassword','Login::resetpassword');
$routes->add('sukses','Login::sukses',['filter'=>'auth']);
$routes->get('dashboard','Dashboard::index',['filter'=>'auth']);

$routes->group('masterdata',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    
    $routes->group('tahunakademik',function($routes){
        $routes->add('/','Masterdata\Tahunakademik::index');
        $routes->add('(:any)','Masterdata\Tahunakademik::$1');
        $routes->add('(:any)/(:any)','Masterdata\Tahunakademik::$1/$2');
    });
    $routes->group('mastermatakuliah',function($routes){
        $routes->add('/','Masterdata\MasterMataKuliah::index');
        $routes->add('(:any)','Masterdata\MasterMataKuliah::$1');
        $routes->add('(:any)/(:any)','Masterdata\MasterMataKuliah::$1/$2');
    });
    $routes->group('dosen',function($routes){
        $routes->add('/','Masterdata\Dosen::index');
        $routes->add('(:any)','Masterdata\Dosen::$1');
        $routes->add('(:any)/(:any)','Masterdata\Dosen::$1/$2');
    });
    $routes->group('kelas',function($routes){
        $routes->add('/','Masterdata\Kelas::index');
        $routes->add('(:any)','Masterdata\Kelas::$1');
        $routes->add('(:any)/(:any)','Masterdata\Kelas::$1/$2');
    });
    $routes->group('kurikulum',function($routes){
        $routes->add('/','Masterdata\Kurikulum::index');
        $routes->add('(:any)','Masterdata\Kurikulum::$1');
        $routes->add('(:any)/(:any)','Masterdata\Kurikulum::$1/$2');
    });
    $routes->group('mahasiswa',function($routes){
        $routes->add('/','Masterdata\Mahasiswa::index');
        $routes->add('(:any)','Masterdata\Mahasiswa::$1');
        $routes->add('(:any)/(:any)','Masterdata\Mahasiswa::$1/$2');
    });
});
$routes->group('akademik',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    
    $routes->group('distribusi_matakuliah',function($routes){
        $routes->add('/','Akademik\Distribusi_matakuliah::index');
        $routes->add('(:any)','Akademik\Distribusi_matakuliah::$1');
        $routes->add('(:any)/(:any)','Akademik\Distribusi_matakuliah::$1/$2');
    });
    $routes->group('perkuliahan',function($routes){
        $routes->add('/','Akademik\Perkuliahan::index');
        $routes->add('(:any)','Akademik\Perkuliahan::$1');
        $routes->add('(:any)/(:any)','Akademik\Perkuliahan::$1/$2');
    });
    $routes->group('krs',function($routes){
        $routes->add('/','Akademik\Krs::index');
        $routes->add('(:any)','Akademik\Krs::$1');
        $routes->add('(:any)/(:any)','Akademik\Krs::$1/$2');
    });
    $routes->group('khs',function($routes){
        $routes->add('/','Akademik\Khs::index');
        $routes->add('(:any)','Akademik\Khs::$1');
        $routes->add('(:any)/(:any)','Akademik\Khs::$1/$2');
    });    
    $routes->group('transkrip',function($routes){
        $routes->add('/','Akademik\Transkrip::index');
        $routes->add('(:any)','Akademik\Transkrip::$1');
        $routes->add('(:any)/(:any)','Akademik\Transkrip::$1/$2');
    });    
    $routes->group('akm',function($routes){
        $routes->add('/','Akademik\Akm::index');
        $routes->add('(:any)','Akademik\Akm::$1');
        $routes->add('(:any)/(:any)','Akademik\Akm::$1/$2');
    });  
    $routes->group('nilai',function($routes){
        $routes->add('/','Akademik\Nilai::index');
        $routes->add('(:any)','Akademik\Nilai::$1');
        $routes->add('(:any)/(:any)','Akademik\Nilai::$1/$2');
    });  
    $routes->group('hasilstudi',function($routes){
        $routes->add('/','Akademik\Nilai::index');
        $routes->add('(:any)','Akademik\Nilai::$1');
        $routes->add('(:any)/(:any)','Akademik\Nilai::$1/$2');
    });  
    $routes->group('kuliahulang',function($routes){
        $routes->add('/','Akademik\Kuliahulang::index');
        $routes->add('(:any)','Akademik\Kuliahulang::$1');
        $routes->add('(:any)/(:any)','Akademik\Kuliahulang::$1/$2');
    });  
    $routes->group('cuti',function($routes){
        $routes->add('/','Akademik\Cuti::index');
        $routes->add('(:any)','Akademik\Cuti::$1');
        $routes->add('(:any)/(:any)','Akademik\Cuti::$1/$2');
    });  
    $routes->group('aktkuliahdosen',function($routes){
        $routes->add('/','Akademik\Aktkuliahdosen::index');
        $routes->add('(:any)','Akademik\Aktkuliahdosen::$1');
        $routes->add('(:any)/(:any)','Akademik\Aktkuliahdosen::$1/$2');
    });  
    $routes->group('ujian',function($routes){
        $routes->add('/','Akademik\Ujian::index');
        $routes->add('(:any)','Akademik\Ujian::$1');
        $routes->add('(:any)/(:any)','Akademik\Ujian::$1/$2');
    });
    $routes->group('kelulusan',function($routes){
        $routes->add('/','Akademik\Kelulusan::index');
        $routes->add('(:any)','Akademik\Kelulusan::$1');
        $routes->add('(:any)/(:any)','Akademik\Kelulusan::$1/$2');
    });
});

$routes->group('tugasakhir',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    
    $routes->group('disposisi',function($routes){
        $routes->add('/','Tugasakhir\Disposisi::index');
        $routes->add('(:any)','Tugasakhir\Disposisi::$1');
        $routes->add('(:any)/(:any)','Tugasakhir\Disposisi::$1/$2');
    });
    $routes->group('proposal',function($routes){
        $routes->add('/','Tugasakhir\Proposal::index');
        $routes->add('(:any)','Tugasakhir\Proposal::$1');
        $routes->add('(:any)/(:any)','Tugasakhir\Proposal::$1/$2');
    });
    $routes->group('skripsi',function($routes){
        $routes->add('/','Tugasakhir\Skripsi::index');
        $routes->add('(:any)','Tugasakhir\Skripsi::$1');
        $routes->add('(:any)/(:any)','Tugasakhir\Skripsi::$1/$2');
    });
    
});

$routes->group('pmb',['namespace' => 'App\Controllers\Admin\Pmb'],function($routes){
    $routes->get('/','Pmb::index');
    $routes->post('/','Pmb::index',['filter'=>'auth']);
    $routes->get('(:any)','Pmb::$1',['filter'=>'auth']);
    $routes->post('(:any)','Pmb::$1',['filter'=>'auth']);
    $routes->add('(:any)/(:any)','Pmb::$1/$2',['filter'=>'auth']);
});

$routes->group('users',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    $routes->add('/','Users::index');
    $routes->add('(:any)','Users::$1');
    $routes->add('(:any)/(:any)','Users::$1/$2');
});

$routes->group('akun',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    $routes->add('/','Akun::index');
    $routes->add('(:any)','Akun::$1');
    $routes->add('(:any)/(:any)','Akun::$1/$2');
});
$routes->group('profil',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    $routes->add('/','Profil::index');
    $routes->add('(:any)','Profil::$1');
    $routes->add('(:any)/(:any)','Profil::$1/$2');
});
$routes->group('ijazah',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    $routes->add('/','Ijazah::index');
    $routes->add('(:any)','Ijazah::$1');
    $routes->add('(:any)/(:any)','Ijazah::$1/$2');
});

$routes->group('pendaftaran',['namespace' => 'App\Controllers'],function($routes){
    $routes->add('/','Pendaftaran::index');
    $routes->add('(:any)','Pendaftaran::$1');
    $routes->add('(:any)/(:any)','Pendaftaran::$1/$2');
});

$routes->group('proyek',['namespace' => 'App\Controllers\Admin\Proyek','filter'=>'auth'],function($routes){
    $routes->group('perencanaan',function($routes){
        $routes->add('/','Perencanaan::index');
        $routes->add('(:any)','Perencanaan::$1');
        $routes->add('(:any)/(:any)','Perencanaan::$1/$2');
    });
    $routes->add('/','Proyek::index');
    $routes->add('(:any)','Proyek::$1');
    $routes->add('(:any)/(:any)','Proyek::$1/$2');
    
    
});

$routes->group('tracer_study',['namespace' => 'App\Controllers'],function($routes){
    $routes->add('/','Tracer_study::index');
    $routes->add('(:any)','Tracer_study::$1');
    $routes->add('(:any)/(:any)','Tracer_study::$1/$2');
});

$routes->group('file_manager',['namespace' => 'App\Controllers\Admin','filter'=>'auth'],function($routes){
    $routes->add('/','File_manager::index');
    $routes->add('(:any)','File_manager::$1');
});
$routes->group('instrument_akreditasi',['namespace' => 'App\Controllers\Admin\Akreditasi','filter'=>'auth'],function($routes){
    $routes->add('/','Instrument_akreditasi::index');
    $routes->add('(:any)','Instrument_akreditasi::$1');
    $routes->add('(:any)/(:any)','Instrument_akreditasi::$1/$2');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes){
    $routes->post('violations/save', 'Violations::save');
    $routes->options('violations/save', 'Violations::save');
});

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

