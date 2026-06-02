<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Piutang;
use App\Mail\WeeklyBranchDataMail;
use Illuminate\Support\Facades\Mail;

class SendWeeklyBranchDataEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weekly-branch-data-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly branch data via email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai mengambil data cabang...');

        $branchData = Piutang::all()->groupBy('branch');

        if ($branchData->isEmpty()) {
            $this->info('Tidak ada data cabang yang ditemukan.');
            return;
        }

        // Anda bisa menyesuaikan daftar email tujuan di bawah ini
        $emailTujuan = [
            'ahmadmad122131@gmail.com',
            'm.rizky@smkwikrama.sch.id'
        ];

        $this->info('Mengirim email ke beberapa alamat tujuan...');

        Mail::to($emailTujuan)->send(new WeeklyBranchDataMail($branchData));

        $this->info('Email berhasil dikirim!');
    }
}
