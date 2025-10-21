<?php

namespace App\Http\Controllers\ERuang;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\eruang_ref;
use App\Models\eruang;
use App\Models\roles;
use App\Models\User;
use Carbon\Carbon;
use Storage;
use Auth;
use \PDF;
use Validator,Redirect,Response,File;

class ERuangController extends Controller
{
    function index()
    {
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $show = eruang::get();
        $ruangan = eruang_ref::orderBy('nama','ASC')->get();

        $data = [
            'role' => $role,
            'show' => $show,
            'ruangan' => $ruangan,
        ];

        return view('pages.eruang.index')->with('list',$data);
    }

    function store(Request $request) {
        $carbon = Carbon::now();
        $push = $carbon->isoFormat('dddd, D MMMM Y, HH:mm a');

        $tgl = Carbon::parse($request->tgl)->isoFormat('YYYY-MM-DD'); // 28-05-2024 menjadi 2024-05-28

        // $query_string = "SELECT * FROM eruang WHERE (tgl_mulai BETWEEN '2024-05-28' AND '2024-05-29') AND deleted_at IS NULL";
        // $query_string = "SELECT * FROM eruang WHERE (tgl_mulai >= $tgl_mulai OR tgl_mulai <= $tgl_selesai) OR (tgl_selesai <= $tgl_selesai OR tgl_selesai >= $tgl_mulai) AND deleted_at IS NULL";
        // $query_string = "SELECT * FROM eruang WHERE (tgl_mulai BETWEEN $tgl_mulai AND $tgl_selesai) OR (tgl_selesai BETWEEN $tgl_mulai AND $tgl_selesai) AND deleted_at IS NULL";
        // $show = DB::select($query_string);
        // $cek = abs(strtotime($tgl_selesai) - strtotime($tgl_mulai));
        // $years = floor($cek / (365*60*60*24));
        // $months = floor(($cek - $years * 365*60*60*24) / (30*60*60*24));
        // $days = floor(($cek - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        // printf("%d days\n", $days);
        // die();

        // INITIALIZE
        // print_r("Snack : ".$request->snack);
        // die();
        $gizi = '';
        if ($request->snack != 0) {
            $gizi .= "Snack : ".$request->snack."\n";
        }
        if ($request->makan != 0) {
            $gizi .= "Makan : ".$request->makan."\n";
        }
        if ($request->minum != 0) {
            $gizi .= "Minum : ".$request->minum;
        }

        // VALIDASI TANGGAL
        $getData = eruang::select('eruang.*','users.nama as nama_user','eruang_ref.nama as nama_ruangan')
                            ->where('eruang.tgl',$tgl)
                            ->where('eruang.id_ruangan',$request->ruangan)
                            ->where('eruang.status_penolakan',null)
                            ->join('users','users.id','=','eruang.id_user')
                            ->join('eruang_ref','eruang_ref.id','=','eruang.id_ruangan')
                            ->orderBy('eruang.jam_mulai', 'ASC')
                            ->get();
        $getJamMulai = Carbon::parse($request->jam_mulai)->isoFormat('HH');
        $getJamSelesai = Carbon::parse($request->jam_selesai)->isoFormat('HH');
        $getMenitMulai = Carbon::parse($request->jam_mulai)->isoFormat('mm');
        $getMenitSelesai = Carbon::parse($request->jam_selesai)->isoFormat('mm');
        // print_r($getMenitMulai);
        // die();

        if (!empty($getData)) {
            $cekVal = null;
            $bonama_ruangan = null;
            $bonama_user = null;
            $bojam_mulai = null;
            $bojam_selesai = null;
            foreach ($getData as $chain => $loc) {
                $dbJamMulai = Carbon::parse($loc->jam_mulai)->isoFormat('HH:mm');
                $dbJamSelesai = Carbon::parse($loc->jam_selesai)->isoFormat('HH:mm');
                $dbMulai = Carbon::parse($loc->jam_mulai)->isoFormat('HH');
                $dbSelesai = Carbon::parse($loc->jam_selesai)->isoFormat('HH');
                $diffdb = $dbSelesai - $dbMulai;
                $diffinp = $getJamSelesai - $getJamMulai;

                for ($i=0; $i <= $diffdb; $i++) { // 9,10,11
                    for ($y=0; $y <= $diffinp; $y++) { // 11,12
                        if ($dbMulai+$i == $getJamMulai+$y) {
                            $cekVal = $dbMulai+$i;
                        }
                    }
                }

                if ($cekVal != null) {
                    $bonama_ruangan = $loc->nama_ruangan;
                    $bonama_user = $loc->nama_user;
                    $bojam_mulai = $dbJamMulai;
                    $bojam_selesai = $dbJamSelesai;
                }
            }

            // VALIDATION
            if ($getJamMulai == $getJamSelesai) {
                if ($getMenitMulai == $getMenitSelesai) {
                    return Response::json(array(
                        'message' => 'Jam tidak valid/tidak boleh sama!',
                        'code' => 400,
                    ));
                } else {
                    if ($getMenitMulai > $getMenitSelesai) {
                        return Response::json(array(
                            'message' => 'Menit jam mulai tidak valid / tidak boleh melebihi menit jam selesai!',
                            'code' => 400,
                        ));
                    } else {
                        if ($cekVal == null) {
                            $data = new eruang;
                            $data->id_user      = $request->user;
                            $data->id_ruangan   = $request->ruangan;
                            $data->agenda       = $request->agenda;
                            $data->tgl          = $tgl;
                            $data->jam_mulai    = $request->jam_mulai;
                            $data->jam_selesai  = $request->jam_selesai;
                            $data->ket          = $request->ket;
                            $data->gizi         = $gizi;
                            $data->save();
                            return Response::json(array(
                                'message' => 'Peminjaman Ruangan Berhasil pada 3 '.$push,
                                'code' => 200,
                            ));
                        } else {
                            return Response::json(array(
                                'message' => 'Ruangan '.$bonama_ruangan.' sudah terpesan oleh '.$bonama_user.' pada jam '.$bojam_mulai.' - '.$bojam_selesai.', silakan memilih Ruangan/Jam lainnya',
                                'code' => 400,
                            ));
                        }
                    }
                }
            } else {
                if ($getJamMulai > $getJamSelesai) {
                    return Response::json(array(
                        'message' => 'Jam Mulai tidak boleh melebihi Jam Selesai',
                        'code' => 400,
                    ));
                } else {
                    if ($cekVal == null) {
                        $data = new eruang;
                        $data->id_user      = $request->user;
                        $data->id_ruangan   = $request->ruangan;
                        $data->agenda       = $request->agenda;
                        $data->tgl          = $tgl;
                        $data->jam_mulai    = $request->jam_mulai;
                        $data->jam_selesai  = $request->jam_selesai;
                        $data->ket          = $request->ket;
                        $data->gizi         = $gizi;
                        $data->save();
                        return Response::json(array(
                            'message' => 'Peminjaman Ruangan Berhasil pada 3 '.$push,
                            'code' => 200,
                        ));
                    } else {
                        return Response::json(array(
                            'message' => 'Ruangan '.$bonama_ruangan.' sudah terpesan oleh '.$bonama_user.' pada jam '.$bojam_mulai.' - '.$bojam_selesai.', silakan memilih Ruangan/Jam lainnya',
                            'code' => 400,
                        ));
                    }
                }
            }
        } else {
            if ($getJamMulai == $getJamSelesai) {
                if ($getMenitMulai == $getMenitSelesai) {
                    return Response::json(array(
                        'message' => 'Jam dan Menit tidak valid/tidak boleh sama!',
                        'code' => 400,
                    ));
                } else {
                    if ($getMenitMulai < $getMenitSelesai) {
                        $data = new eruang;
                        $data->id_user      = $request->user;
                        $data->id_ruangan   = $request->ruangan;
                        $data->agenda       = $request->agenda;
                        $data->tgl          = $tgl;
                        $data->jam_mulai    = $request->jam_mulai;
                        $data->jam_selesai  = $request->jam_selesai;
                        $data->ket          = $request->ket;
                        $data->gizi         = $gizi;
                        $data->save();
                        return Response::json(array(
                            'message' => 'Peminjaman Ruangan Berhasil pada 2 '.$push,
                            'code' => 200,
                        ));
                    } else {
                        return Response::json(array(
                            'message' => 'Menit jam mulai tidak valid / tidak boleh melebihi menit jam selesai!',
                            'code' => 400,
                        ));
                        // return response()->json('Menit Jam Mulai tidak boleh melebihi Menit Jam Selesai', 400);
                    }
                }
            } else {
                if ($getJamMulai < $getJamSelesai) {
                    $data = new eruang;
                    $data->id_user      = $request->user;
                    $data->id_ruangan   = $request->ruangan;
                    $data->agenda       = $request->agenda;
                    $data->tgl          = $tgl;
                    $data->jam_mulai    = $request->jam_mulai;
                    $data->jam_selesai  = $request->jam_selesai;
                    $data->ket          = $request->ket;
                    $data->gizi         = $gizi;
                    $data->save();
                    return Response::json(array(
                        'message' => 'Peminjaman Ruangan Berhasil pada 1 '.$push,
                        'code' => 200,
                    ));
                } else {
                    return Response::json(array(
                        'message' => 'Jam Mulai tidak boleh melebihi Jam Selesai',
                        'code' => 400,
                    ));
                }
            }
        }
    }

    function table()
    {
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
        $show = eruang::select('eruang.*','users.nama as nama_user','users.no_hp','eruang_ref.nama as nama_ruangan','eruang_ref.kapasitas')
                    ->join('users','users.id','=','eruang.id_user')
                    ->join('eruang_ref','eruang_ref.id','=','eruang.id_ruangan')
                    ->orderBy('eruang.updated_at','DESC')
                    ->get();
        // $ruangan = eruang_ref::orderBy('nama','ASC')->get();

        $data = [
            'role' => $role,
            'show' => $show,
            // 'ruangan' => $ruangan,
        ];

        return response()->json($data);
    }

    function getUbah($id)
    {
        $show = eruang::select('eruang.*','users.nama as nama_user','eruang_ref.id as id_ruangan_ref','eruang_ref.nama as nama_ruangan','eruang_ref.kapasitas')
                    ->join('users','users.id','=','eruang.id_user')
                    ->join('eruang_ref','eruang_ref.id','=','eruang.id_ruangan')
                    ->where('eruang.id',$id)
                    ->orderBy('eruang.updated_at','DESC')
                    ->first();

        $ruangan = eruang_ref::orderBy('nama','ASC')->get();

        $data = [
            'show' => $show,
            'ruangan' => $ruangan,
        ];

        return response()->json($data, 200);
    }

    function ubah(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = eruang::find($request->id);
        $data->id_user = $request->user;
        $data->id_ruangan = $request->ruangan;
        $data->agenda = $request->agenda;
        $data->tgl = $request->tgl;
        $data->ket = $request->ket;
        $data->gizi = $request->gizi;

        $data->save();

        return response()->json($tgl, 200);
    }

    function hapus($id)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = eruang::find($id);
        $data->delete();

        return response()->json($tgl, 200);
    }

    function tolak(Request $request){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');
        // print_r($request->id);
        // die();
        // Inisialisasi
        $data = eruang::find($request->id);
        if ($data->gizi_verif != null) {
            return response()->json('Peminjaman Ruangan sudah diverifikasi oleh Gizi sehingga tidak dapat ditolak', 400);
        } else {
            $data->status_penolakan = true;
            $data->alasan_penolakan = $request->alasan;
            $data->save();
            return response()->json($tgl, 200);
        }
    }

    function display(Request $request)
    {
        // print_r("ini ruangan ".$request->ruangan.", dan tgl ".$request->tgl);
        // die();
        $input1 = $request->tgl;
        $input2 = $request->ruangan;
        $input3 = $request->status;
        $tigahariyanglalu = Carbon::now()->subDays(3)->isoFormat('YYYY-MM-DD'); // 28-05-2024 menjadi 2024-05-28
        // if ($request->status != 1) {
        //     $input3 = null;
        // } else {
        //     $input3 = $request->status;
        // }

        $show = eruang::select('eruang.*','users.nama as nama_user','users.no_hp','users_foto.filename as foto_profil','eruang_ref.id as id_ruangan_ref','eruang_ref.nama as nama_ruangan','eruang_ref.kapasitas')
                ->leftJoin('users','users.id','=','eruang.id_user')
                ->leftJoin('users_foto','users.id','=','users_foto.user_id')
                ->join('eruang_ref','eruang_ref.id','=','eruang.id_ruangan')
                ->when($input1 != null, function ($q) use ($input1) {
                    $q->where('eruang.tgl',$input1);
                })
                ->when($input2 != null, function ($q) use ($input2) {
                    $q->where('eruang.id_ruangan',$input2);
                })
                // ->when($input3 != 0, function ($q) use ($input3) {
                //     $q->where('eruang.tgl','>=',$tigahariyanglalu);
                // })
                ->when($input3 == 0, function ($q) use ($input3) {
                    // $q->where('eruang.status_penolakan',null);
                    $q->orderBy('eruang.tgl','desc');
                    $q->orderBy('eruang.jam_mulai','desc');
                })
                ->when($input3 == 1, function ($q) use ($input3,$tigahariyanglalu) {
                    $q->where('eruang.status_penolakan',null);
                    $q->where('gizi_verif',null);
                    $q->where('eruang.tgl','>=',$tigahariyanglalu);
                    $q->orderBy('eruang.tgl','asc');
                    $q->orderBy('eruang.jam_mulai','asc');
                    $q->limit(9);
                })
                ->when($input3 == 2, function ($q) use ($input3) {
                    $q->where('eruang.status_penolakan',null);
                    $q->where('gizi_verif',1);
                    $q->orderBy('eruang.tgl','asc');
                    $q->orderBy('eruang.jam_mulai','asc');
                    $q->limit(9);
                })
                ->when($input3 == 3, function ($q) use ($input3) {
                    $q->where('status_penolakan',1);
                    $q->orderBy('eruang.tgl','desc');
                    $q->orderBy('eruang.jam_mulai','desc');
                    // $q->limit(9);
                })
                // if ($input3 == 1) {
                //     $show->where('eruang.gizi_verif',1);
                // } else {
                //     if ($input3 == 2) {
                //         $show->where('eruang.gizi_verif',null);
                //     }
                // }
                // ->orderBy('eruang.tgl','asc')
                // ->orderBy('eruang.jam_mulai','asc')
                // ->limit(9)
                ->get();
        $now = Carbon::now()->isoFormat('HH:mm:ss');

        $data = [
            'show' => $show,
            'now' => $now,
        ];

        return response()->json($data, 200);
    }

    function verifGizi($id){
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $data = eruang::find($id);
        $data->gizi_verif = true;
        $data->save();

        return response()->json($tgl, 200);
    }

    function verifEditHapus($id){
        // Inisialisasi
        $data = eruang::find($id);
        return response()->json($data, 200);
    }

    ///////////////////////////////////////////////////////// DAFTAR RUANGAN
    function indexRuangan()
    {
        if (Auth::user()->getPermission('admin_eruang')) {
            $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();
            // $show = eruang::get();
            $ruangan = eruang_ref::orderBy('nama','ASC')->get();

            $data = [
                'role' => $role,
                // 'show' => $show,
                'ruangan' => $ruangan,
            ];

            return view('pages.eruang.ruangan')->with('list',$data);
        } else {
            return redirect()->back()->withErrors('Maaf, Anda tidak memiliki akses daftar ruangan');
        }
    }

    function getRuangan()
    {
        $show = eruang_ref::get();
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();

        $data = [
            'role' => $role,
            'show' => $show,
        ];

        return response()->json($data, 200);
    }

    function storeRuangan(Request $request)
    {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = new eruang_ref;
        $data->nama = $request->ruangan;
        $data->deskripsi = $request->deskripsi;
        $data->kapasitas = $request->kapasitas;
        $data->fasilitas = $request->fasilitas;
        if ($request->akses) {
            $data->akses = json_encode($request->akses);
        } else {
            $data->akses = null;
        }
        $data->save();

        return response()->json($tgl, 200);
    }

    function getUbahRuangan($id)
    {
        $show = eruang_ref::where('id',$id)->first();
        $role = roles::where('name', '<>','administrator')->orderBy('updated_at','desc')->get();

        $data = [
            'show' => $show,
            'role' => $role,
        ];

        return response()->json($data, 200);
    }

    function updateRuangan(Request $request) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        $data = eruang_ref::find($request->id);
        $data->nama = $request->ruangan;
        $data->deskripsi = $request->deskripsi;
        $data->kapasitas = $request->kapasitas;
        $data->fasilitas = $request->fasilitas;
        if ($request->akses != '') {
            $data->akses = "[".str_replace(',','","',json_encode($request->akses))."]";
        } else {
            $data->akses = null;
        }


        $data->save();

        return response()->json($tgl, 200);
    }

    function destroyRuangan($id) {
        $tgl = Carbon::now()->isoFormat('dddd, D MMMM Y, HH:mm a');

        // Inisialisasi
        $hapusData = eruang_ref::find($id);
        $hapusData->delete();

        return response()->json($tgl, 200);
    }
}
