<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PiutangController extends Controller
{
    private const GR_BRANCHES = ['cinere', 'jatiasih', 'cianjur', 'ciawi'];

    public function indexBp()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $records = Piutang::when(! ($user->is_admin ?? false), fn($q) => $q->where('branch', 'bp'))->orderByDesc('id')->get();

        // Calculate totals
        $totalSaldoAwal = $records->sum('saldo_awal');
        $totalDebet = $records->sum('debet');
        $totalKredit = $records->sum('kredit');
        $totalSaldoAkhir = $records->sum('saldo_akhir');

        $totalSelisih = $records->sum(function ($item) {
            return ($item->saldo_awal + $item->debet - $item->kredit) - $item->saldo_akhir;
        });

        return view('BP.index', [
            'records' => $records,
            'totalSaldoAwal' => $totalSaldoAwal,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'totalSaldoAkhir' => $totalSaldoAkhir,
            'totalSelisih' => $totalSelisih,
        ]);
    }

    public function storeBp(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');
        return $this->store($request, 'bp');
    }

    public function editBp($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::when(! ($user->is_admin ?? false), fn($q) => $q->where('branch', 'bp'))
            ->findOrFail($id);

        return view('BP.edit', compact('record', 'id'));
    }

    public function updateBp(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::when(! ($user->is_admin ?? false), fn($q) => $q->where('branch', 'bp'))
            ->findOrFail($id);

        $data = $this->validateData($request);
        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        if (! isset($data['saldo_akhir']) || $data['saldo_akhir'] === null || $data['saldo_akhir'] === '') {
            $data['saldo_akhir'] = $this->calculateSaldoAkhir($data);
        }

        $record->update($data);

        return redirect('/bp');
    }

    public function destroyBp($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::when(! ($user->is_admin ?? false), fn($q) => $q->where('branch', 'bp'))
            ->findOrFail($id);
        $record->delete();

        return redirect('/bp');
    }

    public function indexGr($branch)
    {
        $this->validateBranch($branch);

        $records = Piutang::where('branch', $branch)->orderByDesc('id')->get();

        // Calculate totals
        $totalSaldoAwal = $records->sum('saldo_awal');
        $totalDebet = $records->sum('debet');
        $totalKredit = $records->sum('kredit');
        $totalSaldoAkhir = $records->sum('saldo_akhir');

        $totalSelisih = $records->sum(function ($item) {
            return ($item->saldo_awal + $item->debet - $item->kredit) - $item->saldo_akhir;
        });

        return view("GR.$branch.index", [
            'records' => $records,
            'totalSaldoAwal' => $totalSaldoAwal,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'totalSaldoAkhir' => $totalSaldoAkhir,
            'totalSelisih' => $totalSelisih,
        ]);
    }

    public function storeGr(Request $request, $branch)
    {
        $this->validateBranch($branch);

        return $this->store($request, $branch);
    }

    public function editGr($branch, $id)
    {
        $this->validateBranch($branch);

        $record = Piutang::where('branch', $branch)->findOrFail($id);

        return view("GR.$branch.edit", compact('record', 'id'));
    }

    public function updateGr(Request $request, $branch, $id)
    {
        $this->validateBranch($branch);

        return $this->update($request, $branch, $id);
    }

    public function destroyGr($branch, $id)
    {
        $this->validateBranch($branch);

        Piutang::where('branch', $branch)->findOrFail($id)->delete();

        return redirect("/gr/$branch");
    }

    private function validateBranch(string $branch): void
    {
        if (! in_array($branch, self::GR_BRANCHES, true)) {
            abort(404);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== $branch, 403, 'Unauthorized action.');
    }

    private function store(Request $request, string $branch)
    {
        $data = $this->validateData($request);
        $data = $this->normalizeNumericData($data);
        $data['branch'] = $branch;

        if (! isset($data['saldo_akhir']) || $data['saldo_akhir'] === null || $data['saldo_akhir'] === '') {
            $data['saldo_akhir'] = $this->calculateSaldoAkhir($data);
        }

        Piutang::create($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function update(Request $request, string $branch, $id)
    {
        $record = Piutang::where('branch', $branch)->findOrFail($id);
        $data = $this->validateData($request);
        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        if (! isset($data['saldo_akhir']) || $data['saldo_akhir'] === null || $data['saldo_akhir'] === '') {
            $data['saldo_akhir'] = $this->calculateSaldoAkhir($data);
        }

        $record->update($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_konsumen' => ['nullable', 'string', 'max:255'],
            'nama_asuransi' => ['nullable', 'string', 'max:255'],
            'tgl_bukti' => ['nullable', 'date'],
            'no_bukti' => ['nullable', 'string', 'max:100'],
            'saldo_awal' => ['nullable', 'numeric'],
            'debet' => ['nullable', 'numeric'],
            'kredit' => ['nullable', 'numeric'],
            'tgl_bukti_rek' => ['nullable', 'date'],
            'no_bukti_rek' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'tgl_bukti_rek_2' => ['nullable', 'date'],
            'no_bukti_rek_2' => ['nullable', 'string', 'max:100'],
            'keterangan_2' => ['nullable', 'string', 'max:255'],
            'tgl_bukti_rek_3' => ['nullable', 'date'],
            'no_bukti_rek_3' => ['nullable', 'string', 'max:100'],
            'keterangan_3' => ['nullable', 'string', 'max:255'],
            'no_polisi' => ['nullable', 'string', 'max:100'],
            'no_polis' => ['nullable', 'string', 'max:100'],
            'spk_type' => ['nullable', 'string', 'in:ASURANSI,REGULER,INTERNAL'],
            'no_spk' => ['nullable', 'string', 'max:100'],
            'saldo_akhir' => ['nullable', 'numeric'],
        ]);
    }

    private function normalizeNumericData(array $data): array
    {
        $numericKeys = ['saldo_awal', 'debet', 'kredit'];

        foreach ($numericKeys as $key) {
            if (! isset($data[$key]) || $data[$key] === null || $data[$key] === '') {
                $data[$key] = 0;
            }
        }

        return $data;
    }

    private function calculateSaldoAkhir(array $data): float
    {
        $saldoAwal = isset($data['saldo_awal']) ? floatval($data['saldo_awal']) : 0;
        $debet = isset($data['debet']) ? floatval($data['debet']) : 0;
        $kredit = isset($data['kredit']) ? floatval($data['kredit']) : 0;

        return $saldoAwal + $debet - $kredit;
    }

    private function preserveHiddenPaymentStages(array $data, Piutang $record): array
    {
        foreach (
            [
                'tgl_bukti_rek_2',
                'no_bukti_rek_2',
                'keterangan_2',
                'tgl_bukti_rek_3',
                'no_bukti_rek_3',
                'keterangan_3',
            ] as $field
        ) {
            if (array_key_exists($field, $data) && ($data[$field] === null || $data[$field] === '')) {
                unset($data[$field]);
            }
        }

        return $data;
    }
}
