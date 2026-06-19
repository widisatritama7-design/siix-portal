<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MissingUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['nik' => '14071263', 'name' => 'Lilis Waliah'],
            ['nik' => '14071397', 'name' => 'Mey Nurjanah'],
            ['nik' => '14081599', 'name' => 'Cucu Hayati'],
            ['nik' => '14101824', 'name' => 'Rajuni Saragih'],
            ['nik' => '14101833', 'name' => 'Tati Uswatun Khasanah'],
            ['nik' => '14101835', 'name' => 'Sarip Hidayat'],
            ['nik' => '15022439', 'name' => 'Nofi Priyatini'],
            ['nik' => '15042590', 'name' => 'Dian Susanti'],
            ['nik' => '15052919', 'name' => 'Ertin Dwi Aryani'],
            ['nik' => '15083154', 'name' => 'Citra Virgiana Putri'],
            ['nik' => '16073427', 'name' => 'Alief Yusma Z'],
            ['nik' => '17033673', 'name' => 'Febri Fitriyani'],
            ['nik' => '17053788', 'name' => 'Imelda Wati Nainggolan'],
            ['nik' => '17083965', 'name' => 'Kusmiati'],
            ['nik' => '17103977', 'name' => 'Yudi Nur Prasetyo'],
            ['nik' => '20014730', 'name' => 'Syarif Chandra Kurniawan'],
            ['nik' => '20124906', 'name' => 'Siti Kholisoh'],
            ['nik' => '21075158', 'name' => 'Zahida Fairuz Syifa'],
            ['nik' => '21125361', 'name' => 'Dera Farika Triani'],
            ['nik' => '21125385', 'name' => 'Siti Nurlela'],
            ['nik' => '21125412', 'name' => 'Nadia Rizka Salsabila'],
            ['nik' => '22055559', 'name' => 'Resti Amelia'],
            ['nik' => '22115695', 'name' => 'Wisna Diningrat'],
            ['nik' => '23015777', 'name' => 'Natasya Azharani'],
            ['nik' => '23075916', 'name' => "Husnul Iffat Zaa'idah"],
            ['nik' => '23075918', 'name' => 'Rizki Rahayu'],
            ['nik' => '23105981', 'name' => 'Rheisya Vascahalia Putri'],
            ['nik' => '25076146', 'name' => 'Zaki Fahlepi'],
            ['nik' => '25096192', 'name' => 'Daffa Zain Hibatullah'],
            ['nik' => '25116252', 'name' => 'Saraswati'],
            ['nik' => '25126253', 'name' => 'Berliana Mareta'],
            ['nik' => '26036291', 'name' => 'Frika Sheifana Pratidina'],
            ['nik' => '26036292', 'name' => 'Iman Rahman'],
            ['nik' => '26046305', 'name' => 'Lesi Puspita'],
            ['nik' => '26056312', 'name' => 'Muhamad Fajar'],
            ['nik' => '26056322', 'name' => 'Ima Maftuhah'],
            ['nik' => '26066363', 'name' => 'Widiyono'],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['nik' => $user['nik']],
                [
                    'name'       => $user['name'],
                    'password'   => Hash::make($user['nik']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}