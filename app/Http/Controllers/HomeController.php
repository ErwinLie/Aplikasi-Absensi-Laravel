<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\M_projek;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
//use Illuminate\View\View;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{ 
    public function login()
	{
        $model = new M_projek;
        $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);

        echo view('header', $data1);
		echo view('login', $data1);
	}

    // public function post_aksilogin()
    // {
    //     $u = Request::input('username');
    //     $p = Request::input('password');
    //     $captchaAnswer = Request::input('captcha_answer');

	// 	// $this->log_activity('User melakukan Login');

    //     $model = new M_projek();
    //     $where = array(
    //         'username' => $u,
    //         'password' => md5($p)
    //     );

    //     $cek = $model->getWhere('tb_user', $where);

    //     // Offline CAPTCHA answer (should match the one generated in the view)
    //     if (!$this->isOnline() && !empty($captchaAnswer)) {
    //         $correctAnswer = Request::input('correct_captcha_answer');
    //         if ($captchaAnswer != $correctAnswer) {
    //             return redirect()->to('Home/login')->with('error', 'Incorrect offline CAPTCHA.');
    //         }
    //     }

    //     if ($cek > 0) {
    //         // Handle sessions as usual
    //         session()->set('id_user', $cek->id_user);
    //         session()->set('id_level', $cek->id_level);
    //         session()->set('email', $cek->email);
    //         session()->set('username', $cek->username);

    //         // Redirect to the dashboard
    //         return redirect()->to('Home/dashboard');
    //     } else {
    //         return redirect()->to('Home/login');
    //     }
    // }

    public function post_aksilogin(Request $request)
{
    // Ambil username dan password dari request
    $username = request()->post('username');
    $password = request()->post('password');

    // Menyiapkan kondisi untuk pencarian
    $where = [
        'username' => $username,
        'password' => md5($password),
    ];

    // Mencari pengguna berdasarkan username
    $model = new M_projek();
    $user = $model->getWhere('tb_user', $where);

    // Memeriksa apakah pengguna ditemukan
    if ($user) { // Verifikasi password dengan MD5
        // Jika password cocok, set session
        session()->put('username', $user->username); 
        session()->put('id', $user->id_user);

        // Debugging: Pastikan session di-set
        Log::info('User logged in: ' . $user->username);
        
        // Redirect ke dashboard
        return redirect()->to('home/dashboard'); 
    } else {
        // Jika tidak, kembalikan dengan pesan error
        return redirect()->back()->with('error', 'Invalid username or password.');
    }
}
    

    // Function to check if the client is online
    private function isOnline()
    {
        // A simple method to check if the client is online (can be more sophisticated)
        return @fopen("http://www.google.com:80/", "r");
    }

    public function logout()
	{
		session()->forget(['username', 'id']); // Remove specific session variables
    return redirect()->to('home/login');
	}

    public function dashboard()
    {
        if (session()->get('id') > 0) {
        // Debugging: Cek apakah session id ada
        Log::info('Session ID: ' . session()->get('id'));

        $model = new M_projek;
        $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);

        // Fetch user data from 'tb_user' table where 'id_user' equals the session value
        $user = session()->get('username');

        // Prepare the data for the views
        $data = [
            'username' => $user        ];
    
        
            echo view('header', $data,$data1);
            echo view('menu', $data, $data1);
            echo view('footer');
        } else {
            return redirect()->to('home/login');
        }
    }

    public function user()
        {
            if (session()->get('id') > 0) {
                
            $model = new M_projek;
            $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
            $data['erwin'] = $model-> tampil('tb_user');
            $data['kelas'] = $model-> tampil('tb_kelas');
            echo view('header', $data1);
            echo view('menu', $data1);
            echo view('user', $data);
            echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer

        } else {
            return redirect()->to('home/login');
        }
        }

        // public function post_aksi_t_user()
        // {
        //     // Get input values using the Request facade
        //     $a = Request::input('username'); // Get 'namakelas' input
        //     $b = Request::input('email'); // Get 'posisi_kelas' input
        //     $c = Request::input('id_level');
        //     $d = Request::input('jk');

        //      // Automatically set password to '1' and bcrypt hash it
        //     $hashedPassword = md5('1');
    
        //     // Prepare the data for insertion
        //     $data = [
        //         'username' => $a,
        //         'email' => $b,
        //         'id_level' => $c,
        //         'jk' => $d,
        //         'password' => $hashedPassword,
        //         'foto' => 'avatar-1.png',

        //     ];
    
        //     // Create a new instance of M_projek and insert the data
        //     $model = new M_projek();
        //     $model->tambah('tb_user', $data); // Use your method to add the data
    
        //     // Redirect to the kelas page with a success message
        //     return redirect()->to('home/user')->with('success', 'User berhasil ditambahkan!');
        // }

        public function post_aksi_t_user()
{
    $a = Request::input('username');
    $b = Request::input('email');
    $c = Request::input('id_level');
    $d = Request::input('jk');
    $e = Request::input('id_kelas'); // Get the selected class

    $hashedPassword = md5('1');

    // Prepare the data for insertion
    $data = [
        'username' => $a,
        'email' => $b,
        'id_level' => $c,
        'jk' => $d,
        'password' => $hashedPassword,
        'foto' => 'avatar-1.png',
    ];

    // If the user is a student (Level 5), include the selected class
    if ($c == 5) {
        $data['id_kelas'] = $e;
    }

    // Insert the data into tb_user
    $model = new M_projek();
    $model->tambah('tb_user', $data);

    // Redirect back to the user page with a success message
    return redirect()->to('home/user')->with('success', 'User berhasil ditambahkan!');
}

        public function post_aksi_e_user()
    {
        // Get input values from the request
        $id = Request::input('id'); // Get user ID from hidden input field
        $username = Request::input('username'); // Get the updated username
        $email = Request::input('email'); // Get the updated email
        $id_level = Request::input('id_level'); // Get the updated level
        $jk = Request::input('jk'); // Get the updated gender

        // Prepare data for update
        $data = [
            'username' => $username,
            'email' => $email,
            'id_level' => $id_level,
            'jk' => $jk,
        ];

        // Create an instance of M_projek and update the data
        $model = new M_projek();
        $where = ['id_user' => $id]; // Condition to match the user by id_user
        $model->edit('tb_user', $data, $where); // Use your method to update the data

        // Redirect to the user page with a success message
        return redirect()->to('home/user')->with('success', 'User berhasil diupdate!');
    }

    public function hapus_user($id)
    {
        // Create an instance of the model
        $model = new M_projek();

        // Define the condition for deletion
        $where = ['id_user' => $id];

        // Call the hapus method to delete the record
        $model->hapus('tb_user', $where);

        // Redirect to the 'penilaian' page
        return redirect()->to('home/user')->with('success', 'User berhasil dihapus!');
    }

    public function mapel()
        {
            if (session()->get('id') > 0) {

            $model = new M_projek;
            $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
            $data['mapels'] = M_projek::tampil('tb_mapel');
            echo view('header', $data1);
            echo view('menu', $data1);
            echo view('mapel', $data);
            echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer

        } else {
            return redirect()->to('home/login');
        }
        }

        public function post_aksi_t_mapel()
{
    // Retrieve the 'nama_mapel' from the form input
    $nama_mapel = Request::input('nama_mapel');

    // Prepare the data for insertion
    $data = [
        'nama_mapel' => $nama_mapel,
    ];

    // Insert the data into 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->tambah('tb_mapel', $data);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/mapel')->with('success', 'Mata Pelajaran berhasil ditambahkan!');
}

public function post_aksi_e_mapel()
{
    // Retrieve 'id' and 'nama_mapel' from the form input
    $id_mapel = Request::input('id');
    $nama_mapel = Request::input('nama_mapel');

    // Prepare the data for updating
    $data = [
        'nama_mapel' => $nama_mapel,
    ];

    // Update the data in 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->edit('tb_mapel', $data, ['id_mapel' => $id_mapel]);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/mapel')->with('success', 'Mata Pelajaran berhasil diupdate!');
}

public function hapus_mapel($id)
{
    // Create an instance of the model
    $model = new M_projek();

    // Define the condition for deletion
    $where = ['id_mapel' => $id];

    // Call the hapus method to delete the record
    $model->hapus('tb_mapel', $where);

    // Redirect to the 'penilaian' page
    return redirect()->to('home/mapel')->with('success', 'Mapel berhasil dihapus!');
}

public function kelas()
{
    if (session()->get('id') > 0) {

    $model = new M_projek;

    $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    $data['kelas'] = M_projek::tampil('tb_kelas');
    echo view('header', $data1);
    echo view('menu', $data1);
    echo view('kelas', $data);
    echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer
} else {
    return redirect()->to('home/login');
}
}

public function post_aksi_t_kelas()
{
    // Retrieve the 'nama_mapel' from the form input
    $nama_kelas = Request::input('nama_kelas');

    // Prepare the data for insertion
    $data = [
        'nama_kelas' => $nama_kelas,
    ];

    // Insert the data into 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->tambah('tb_kelas', $data);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/kelas')->with('success', 'Kelas berhasil ditambahkan!');
}

public function post_aksi_e_kelas()
{
    // Retrieve 'id' and 'nama_mapel' from the form input
    $id_kelas = Request::input('id');
    $nama_kelas = Request::input('nama_kelas');

    // Prepare the data for updating
    $data = [
        'nama_kelas' => $nama_kelas,
    ];

    // Update the data in 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->edit('tb_kelas', $data, ['id_kelas' => $id_kelas]);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/kelas')->with('success', 'Kelas berhasil diupdate!');
}

public function hapus_kelas($id)
{
    // Create an instance of the model
    $model = new M_projek();

    // Define the condition for deletion
    $where = ['id_kelas' => $id];

    // Call the hapus method to delete the record
    $model->hapus('tb_kelas', $where);

    // Redirect to the 'penilaian' page
    return redirect()->to('home/kelas')->with('success', 'Kelas berhasil dihapus!');
}

public function blok()
{
    if (session()->get('id') > 0) {

    $model = new M_projek;
    $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    $data['blok'] = M_projek::tampil('tb_blok');
    echo view('header', $data1);
    echo view('menu', $data1);
    echo view('blok', $data);
    echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer

} else {
    return redirect()->to('home/login');
}
}

public function post_aksi_t_blok()
{
    // Retrieve the 'nama_mapel' from the form input
    $nama_blok = Request::input('nama_blok');
    $semester = Request::input('semester');

    // Prepare the data for insertion
    $data = [
        'nama_blok' => $nama_blok,
        'semester' => $semester,
    ];

    // Insert the data into 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->tambah('tb_blok', $data);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/blok')->with('success', 'Blok berhasil ditambahkan!');
}

public function post_aksi_e_blok()
{
    // Retrieve 'id' and 'nama_mapel' from the form input
    $id_blok = Request::input('id');
    $nama_blok = Request::input('nama_blok');
    $semester = Request::input('semester');

    // Prepare the data for updating
    $data = [
        'nama_blok' => $nama_blok,
        'semester' => $semester,
    ];

    // Update the data in 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->edit('tb_blok', $data, ['id_blok' => $id_blok]);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/blok')->with('success', 'Blok berhasil diupdate!');
}

public function hapus_blok($id)
{
    // Create an instance of the model
    $model = new M_projek();

    // Define the condition for deletion
    $where = ['id_blok' => $id];

    // Call the hapus method to delete the record
    $model->hapus('tb_blok', $where);

    // Redirect to the 'penilaian' page
    return redirect()->to('home/blok')->with('success', 'Blok berhasil dihapus!');
}

public function setting()
    {
        // Check if the logged-in user has 'id_level' == 1
        if (session()->get('id') == 1) {
            // Instantiate your model
            $model = new M_projek;

            // // Fetch user data from 'tb_user' table where 'id_user' equals the session value
            // $user = $model->getWhere('tb_user', ['id_user' => session()->get('id_user')]);

            // Fetch setting data from 'tb_setting' where 'id_setting' equals 1
            $setting = $model->getWhere('tb_setting', ['id_setting' => 1]);

            // Prepare the data to pass to views
            $data = [
                // 'user' => $user,
                'setting' => $setting,
            ];

            echo view('header', $data);
            echo view('menu', $data);
            echo view('setting', $data);
            echo view('footer');
        } else {
            // If unauthorized, redirect to error page
            return redirect()->to('home/error404');
        }
    }

    public function post_aksi_e_setting()
{
    // Log activity (optional, you can implement this logging function as needed)
    // $this->log_activity('User Melakukan Edit Setting');

    $model = new M_projek();

    // Get input data using Request facade
    $nama_web = Request::input('nama_web');
    $icon = Request::file('logo_tab');
    $dash = Request::file('logo_dashboard');
    $login = Request::file('logo_login');

    // Debugging: Log received data (Laravel's log functionality)
    Log::debug('Website Name: ' . $nama_web);
    Log::debug('Tab Icon: ' . ($icon ? $icon->getClientOriginalName() : 'None'));
    Log::debug('Dashboard Icon: ' . ($dash ? $dash->getClientOriginalName() : 'None'));
    Log::debug('Login Icon: ' . ($login ? $login->getClientOriginalName() : 'None'));

    $data = ['nama_web' => $nama_web];

    // Handle logo_tab upload
    if ($icon && $icon->isValid()) {
        $imageName = $icon->getClientOriginalName();
        $icon->move(public_path('img/avatar/'), $imageName);
        $data['logo_tab'] = $imageName;
    }

    // Handle logo_dashboard upload
    if ($dash && $dash->isValid()) {
        $imageName = $dash->getClientOriginalName();
        $dash->move(public_path('img/avatar/'), $imageName);
        $data['logo_dashboard'] = $imageName;
    }

    // Handle logo_login upload
    if ($login && $login->isValid()) {
        $imageName = $login->getClientOriginalName();
        $login->move(public_path('img/avatar/'), $imageName);
        $data['logo_login'] = $imageName;
    }

    // Update the settings in the database
    $model->edit('tb_setting', $data, ['id_setting' => 1]);

    // Redirect back to settings page
    return redirect()->to('home/setting')->with('success', 'Setting berhasil diupdate!');
}

    public function error404()
    {
        // Check if the user has an id_level greater than 1
        if (session()->get('id') > 1) {
            // Instantiate the model
            $model = new M_projek;

            // Fetch setting data from 'tb_setting' where 'id_setting' equals 1
            $setting = $model->getWhere('tb_setting', ['id_setting' => 1]);

            // Prepare the data for the views
            $data = [
                'setting' => $setting,
            ];

            // Load views with the data
            echo view('header', $data);
            echo view('error404');
            echo view('footer');
        } else {
            // If not authorized, redirect to the error page
            return redirect()->to('home/error404');
        }
    }

//     public function profile()
// {
//     // Check if the user has an id greater than 0
//     if (session()->get('id') > 0) { 
//         // Instantiate the model
//         $model = new M_projek();

//         // Fetch user data from 'tb_user' where 'id_user' equals the logged-in user's id
//         $whereUser = ['id_user' => session()->get('id_user')];
//         $data['user'] = $model->getWhere('tb_user', $whereUser);
//         $data['darren'] = $model->getWhere('tb_user', $whereUser); // This is redundant, you can remove it if it's the same data as 'user'

//         // Fetch setting data from 'tb_setting' where 'id_setting' equals 1
//         $whereSetting = ['id_setting' => 1];
//         $data['setting'] = $model->getWhere('tb_setting', $whereSetting);

//         // Load views with the data
//         echo view('header', $data);
//         echo view('menu', $data);
//         echo view('profile', $data);
//         echo view('footer');
//     } else {
//         // If not authorized, redirect to the login page
//         return redirect()->to('home/login');
//     }
// }

public function profile()
{
    if (session()->get('id') > 0) {
        $model = new M_projek();

        // Fetch user data from 'tb_user' where 'id_user' equals the logged-in user's id
        $whereUser = ['id_user' => session()->get('id')];
        $user = $model->getWhere('tb_user', $whereUser);

        // Check if the user data is fetched correctly
        // if ($user == null || empty($user)) {
        //     // Log the issue or return an error
        //     return abort(404, 'User not found');
        // }

        // Prepare data for the view
        $data['user'] = $user;
        $data['darren'] = $user; // If 'darren' is the same as 'user', reuse the same data

        $whereSetting = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('tb_setting', $whereSetting);

        
        echo view('header', $data);
        echo view('menu', $data);
        echo view('profile', $data);
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
}

public function jadwal()
{
    if (session()->get('id') > 0) {

    $model = new M_projek;

    $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    $data['kelas'] = M_projek::tampil('tb_kelas');
    $data['blok'] = M_projek::tampil('tb_blok');

    echo view('header', $data1);
    echo view('menu', $data1);
    echo view('jadwal', $data);
    echo view('footer');
} else {
    return redirect()->to('home/login');
}
}

public function getJadwal(Request $request)
{
    $model = new M_projek;
    $kelas = 1; // Memanggil metode input pada objek Request
    $blok =1;

    // Log nilai id_kelas dan id_blok
    Log::info('ID Kelas: ' . $kelas);
    Log::info('ID Blok: ' . $blok);

    // Validasi input
    if (!$kelas || !$blok) {
        return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
    }

    // Ambil data jadwal
    $jadwal = $model->getJadwalByKelasBlok($kelas, $blok);

    if ($jadwal->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Tidak ada data jadwal.']);
    }

    return response()->json(['success' => true, 'data' => $jadwal]);
}

// public function hapusJadwal(Request $request)
// {
//     $model = new M_projek;

//     $kelas = $request->input('kelas');
//     $blok = $request->input('blok');

//     // Validasi input
//     if (!$kelas || !$blok) {
//         return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
//     }

//     // Menghapus jadwal berdasarkan kelas dan blok
//     $deleted = $model->hapus('tb_jadwal', [
//         'id_kelas' => $kelas,
//         'id_blok' => $blok
//     ]);

//     if ($deleted) {
//         return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus.']);
//     } else {
//         return response()->json(['success' => false, 'message' => 'Gagal menghapus jadwal.']);
//     }
// }

// public function hapus_jadwal(Request $request)
// {
//     $model = new M_projek;

//     $kelas = $request->input('kelas');
//     $blok = $request->input('blok');

//     // Log received values
//     Log::info('ID Kelas untuk hapus: ' . $kelas);
//     Log::info('ID Blok untuk hapus: ' . $blok);

//     // Validasi input
//     if (!$kelas || !$blok) {
//         return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
//     }

//     // Menghapus jadwal berdasarkan kelas dan blok
//     $deleted = $model->hapus('tb_jadwal', [
//         'id_kelas' => $kelas,
//         'id_blok' => $blok
//     ]);

//     // Log hasil delete operation
//     Log::info('Hasil hapus: ' . ($deleted ? 'Berhasil' : 'Gagal'));

//     if ($deleted) {
//         return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus.']);
//     } else {
//         return response()->json(['success' => false, 'message' => 'Gagal menghapus jadwal.']);
//     }
// }

// public function hapus_jadwal(Request $request)
// {
//     $kelas = $request->input('kelas');
//     $blok = $request->input('blok');

//     Log::info('ID Kelas untuk hapus: ' . $kelas);
//     Log::info('ID Blok untuk hapus: ' . $blok);

//     if (!$kelas || !$blok) {
//         return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
//     }

//     // Attempt to delete the record
//     $deleted = DB::table('tb_jadwal')
//                 ->where('id_kelas', $kelas)
//                 ->where('id_blok', $blok)
//                 ->delete();

//     Log::info('Hasil hapus: ' . ($deleted ? 'Berhasil' : 'Gagal'));

//     if ($deleted) {
//         return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus.']);
//     } else {
//         return response()->json(['success' => false, 'message' => 'Gagal menghapus jadwal.']);
//     }
// }

// public function hapus_jadwal(Request $request)
//     {
//         $model = new M_projek;

//         $kelas = $request->input('kelas');
//         $blok = $request->input('blok');

//         Log::info('ID Kelas untuk hapus: ' . $kelas);
//         Log::info('ID Blok untuk hapus: ' . $blok);

//         if (!$kelas || !$blok) {
//             return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
//         }

//         // Panggil metode hapus dari model
//    $model->hapus('tb_jadwal', [
//             'id_kelas' => $kelas,
//             'id_blok' => $blok,
//         ]);

        
//     }

public function post_hapus_jadwal(Request $request)
{
    $model = new M_projek();
    $kelas = Request::input('kelas');
    $blok = Request::input('blok');

    Log::info('ID Kelas: ' . $kelas);
    Log::info('ID Blok: ' . $blok);

    // Validate input
    if (!$kelas || !$blok) {
        Log::warning('Validation failed: Kelas or Blok not set.');
        return response()->json(['success' => false, 'message' => 'Kelas dan blok harus dipilih.']);
    }

    $where = ['id_kelas' => $kelas, 'id_blok' => $blok];
    $deleted = $model->hapus('tb_jadwal', $where);
    //$deleted = $this->hapus('tb_jadwal', $where);

    Log::info('Deleted records count: ' . $deleted);

    if ($deleted) {
        return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Gagal menghapus jadwal.']);
    }
}




public function t_jadwal()
{
    if (session()->get('id') > 0) {

    $model = new M_projek;

    $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    $data['erwin'] = M_projek::tampil('tb_kelas');
    $data['yoga'] = M_projek::tampil('tb_blok');
    $data['darren'] = M_projek::tampil('tb_user');
    $data['leo'] = M_projek::tampil('tb_mapel');

    echo view('header', $data1);
    echo view('menu', $data1);
    echo view('t_jadwal', $data);
    echo view('footer');
} else {
    return redirect()->to('home/login');
}
}

public function post_aksi_t_jadwal()
{
    // Retrieve the 'nama_mapel' from the form input
    $kelas = Request::input('kelas');
    $blok = Request::input('blok');
    $guru = Request::input('guru');
    $mapel = Request::input('mapel');
    $sesi = Request::input('sesi');
    $jam_mulai = Request::input('jam_mulai');
    $jam_selesai = Request::input('jam_selesai');

    // Prepare the data for insertion
    $data = [
        'id_kelas' => $kelas,
        'id_blok' => $blok,
        'id_guru' => $guru,
        'id_mapel' => $mapel,
        'sesi' => $sesi,
        'jam_mulai' => $jam_mulai,
        'jam_selesai' => $jam_selesai
    ];

    // Insert the data into 'tb_mapel'
    $model = new M_projek();  // Assuming you have a model named 'M_projek'
    $model->tambah('tb_jadwal', $data);

    // Redirect back to the 'Mata Pelajaran' page with a success message
    return redirect()->to('home/jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
}

public function pilih_kelas()
{
    if (session()->get('id') > 0) {

    $model = new M_projek;
    $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    $data['kelas'] = M_projek::tampil('tb_kelas');
    $data['blok'] = M_projek::tampil('tb_blok');
    $data['mapel'] = M_projek::tampil('tb_mapel');

    echo view('header', $data1);
    echo view('menu', $data1);
    echo view('pilih_kelas', $data);
    echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer

} else {
    return redirect()->to('home/login');
}
}

public function absensi()
{
    // Check if the user is logged in
    if (session()->get('id') > 0) {
        // Get attendance data
        $model = new M_projek();
        $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
        // $data['absensi'] = $model->tampil('tb_absensi'); // Adjust this according to your model's method
        // $data['siswa'] = $model->tampil('tb_user'); // Assuming you have a method to get students
        // $data['absensi'] = $model->join(
        // 'tb_user',
        // 'tb_absensi',
        // 'tb_user.id_user = tb_absensi.id_siswa'); // Assuming you have a method to get students

        $data['absensi'] = DB::table('tb_absensi')
            ->join('tb_user', 'tb_absensi.id_siswa', '=', 'tb_user.id_user')
            ->select('tb_absensi.*', 'tb_user.username') // Select the fields you need
            ->get();

            $data['siswa'] = DB::table('tb_user')
            ->where('id_level', 5) // Filter to only include students
            ->get();
            
        // Render views
        echo view('header', $data1);
        echo view('menu', $data1);
        echo view('absensi', $data); // Adjust this to your view path
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
}

public function post_aksi_t_absensi()
{
    // Retrieve input data from the form
    $tanggal = Request::input('tanggal');
    $id_siswa = Request::input('id_siswa');
    $status_absensi = Request::input('status_absensi');
    $pokok_bahasan = Request::input('pokok_bahasan');
    $metode_pengajaran = Request::input('metode_pengajaran');

    // Prepare data for insertion
    $data = [
        'tanggal' => $tanggal,
        'id_siswa' => $id_siswa,
        'status_absensi' => $status_absensi,
        'pokok_bahasan' => $pokok_bahasan,
        'metode_pengajaran' => $metode_pengajaran,
    ];

    // Use the model to insert data into 'tb_absensi'
    $model = new M_projek(); // Ensure M_projek has a 'tambah' method
    $model->tambah('tb_absensi', $data);

    // Redirect with a success message
    return redirect()->to('home/absensi')->with('success', 'Absensi berhasil ditambahkan!');
}

// Method to handle editing an existing 'absensi' record
public function post_aksi_e_absensi()
{
    // Retrieve form data
    $id_absensi = Request::input('id');
    $tanggal = Request::input('tanggal');
    $id_siswa = Request::input('id_siswa');
    $status_absensi = Request::input('status_absensi');
    $pokok_bahasan = Request::input('pokok_bahasan');
    $metode_pengajaran = Request::input('metode_pengajaran');

    // Prepare data for updating
    $data = [
        'tanggal' => $tanggal,
        'id_siswa' => $id_siswa,
        'status_absensi' => $status_absensi,
        'pokok_bahasan' => $pokok_bahasan,
        'metode_pengajaran' => $metode_pengajaran,
    ];

    // Use the model to update 'tb_absensi'
    $model = new M_projek(); // Ensure M_projek has an 'edit' method
    $model->edit('tb_absensi', $data, ['id_absensi' => $id_absensi]);

    // Redirect with a success message
    return redirect()->to('home/absensi')->with('success', 'Absensi berhasil diupdate!');
}

// Method to delete an 'absensi' record
public function hapus_absensi($id)
{
    $model = new M_projek(); // Ensure M_projek has a 'delete' method

    $where = ['id_absensi' => $id];
    
    $model->hapus('tb_absensi', $where);

    return redirect()->to('home/absensi')->with('success', 'Absensi berhasil dihapus!');
}

private function log_activity($activity)
    {
		$model = new M_projek();
        $data = [
            'id_user'    => session()->get('id'),
            'activity'   => $activity,
			'timestamp' => date('Y-m-d H:i:s'),
			// 'delete_at' => '0'
        ];

        $model->tambah('tb_activity', $data);
	}

    // public function activity()
    //     {
    //         if (session()->get('id') > 0) {

    //         $model = new M_projek;
    //         $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
    //         $data['mapels'] = M_projek::tampil('tb_mapel');
    //         echo view('header', $data1);
    //         echo view('menu', $data1);
    //         echo view('mapel', $data);
    //         echo view('footer'); // Mengembalikan view dashboard yang menggabungkan header, menu, dan footer

    //     } else {
    //         return redirect()->to('home/login');
    //     }
    //     }

    public function activity()
    {
        if (session()->get('id')>0) {
            $model = new M_projek();
            
            // $where = array('id_user'=>session()->get('id_user'));
            // $data['user'] = $model->getWhere('tb_user', $where);
            
            $data1 ['setting']= $model->getWhere('tb_setting', ['id_setting' => 1]);
            
            $this->log_activity('User membuka Log Activity');
            
            // $data['erwin'] = $model->join('tb_activity', 'tb_user',
            // 'tb_activity.id_user = tb_user.id_user',$where);

            $data['erwin'] = $model->join('tb_activity', 'tb_user', ['tb_activity.id_user', 'tb_user.id_user']);

        echo view('header' ,$data1);
		echo view('menu',$data1);
		echo view('activity',$data);
		echo view('footer');
	
		}else{
			return redirect()->to('home/login');
		}
        }

// public function absensi(Request $request)
// {
//     if (session()->get('id') > 0) {

//         $model = new M_projek;

//         $data1['setting'] = $model->getWhere('tb_setting', ['id_setting' => 1]);

//         // Retrieve the passed data from the request
//         $id_jadwal = $request->input('id_jadwal');
//         $id_blok = $request->input('id_blok');
//         $id_kelas = $request->input('id_kelas');

//         // Use the retrieved data in the where clause
//         $where = ['id_kelas' => $id_kelas, 'id_blok' => $id_blok, 'id_jadwal' => $id_jadwal];
//         $data['absensi'] = $model->joinThreeWhere(
//             'tb_absensi',
//             'tb_user',
//             'tb_jadwal',
//             'tb_absensi.id_jadwal = tb_jadwal.id_jadwal',
//             'tb_absensi.id_siswa = tb_user.id_user',
//             $where
//         );

//         echo view('header', $data1);
//         echo view('menu', $data1);
//         echo view('absensi', $data);
//         echo view('footer');
//     } else {
//         return redirect()->to('home/login');
//     }
// }

}