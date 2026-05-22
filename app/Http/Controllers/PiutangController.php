<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    private const GR_BRANCHES = ['cinere', 'jatiasih', 'cianjur', 'ciawi'];

    public function indexBp()
    {
        return view('BP.index', ['records' => Piutang::where('branch', 'bp')->orderByDesc('id')->get()]);
    }

    public function storeBp(Request $request)
    {
        return $this->store($request, 'bp');
    }

    public function editBp($id)
    {
        $record = Piutang::where('branch', 'bp')->findOrFail($id);

        return view('BP.edit', compact('record', 'id'));
    }

    public function updateBp(Request $request, $id)
    {
        return $this->update($request, 'bp', $id);
    }

    public function destroyBp($id)
    {
        Piutang::where('branch', 'bp')->findOrFail($id)->delete();

        return redirect('/bp');
    }

    public function indexGr($branch)
    {
        $this->validateBranch($branch);

        return view("GR.$branch.index", ['records' => Piutang::where('branch', $branch)->orderByDesc('id')->get()]);
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
    }

    private function store(Request $request, string $branch)
    {
        $data = $this->validateData($request);
        $data['branch'] = $branch;
        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data);

        Piutang::create($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function update(Request $request, string $branch, $id)
    {
        $record = Piutang::where('branch', $branch)->findOrFail($id);
        $data = $this->validateData($request);
        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data);

        $record->update($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_konsumen' => ['nullable', 'string', 'max:255'],
            'tgl_bukti' => ['nullable', 'date'],
            'no_bukti' => ['nullable', 'string', 'max:100'],
            'saldo_awal' => ['nullable', 'numeric'],
            'debet' => ['nullable', 'numeric'],
            'kredit' => ['nullable', 'numeric'],
            'tgl_bukti_rek' => ['nullable', 'date'],
            'no_bukti_rek' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'no_polisi' => ['nullable', 'string', 'max:100'],
            'no_polis' => ['nullable', 'string', 'max:100'],
            'spk_type' => ['nullable', 'string', 'in:ASURANSI,REGULER'],
            'no_spk' => ['nullable', 'string', 'max:100'],
        ]);
    }

    private function calculateSaldoAkhir(array $data): float
    {
        $saldoAwal = isset($data['saldo_awal']) ? floatval($data['saldo_awal']) : 0;
        $debet = isset($data['debet']) ? floatval($data['debet']) : 0;
        $kredit = isset($data['kredit']) ? floatval($data['kredit']) : 0;

        return $saldoAwal + $debet - $kredit;
    }
}
