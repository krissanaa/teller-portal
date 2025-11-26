<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\OnboardingRequest;
use App\Models\TellerPortal\BranchUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OnboardingController extends Controller
{
    // Ã°Å¸Â§Â¾ Ã Â¸Å¸Ã Â¸Â­Ã Â¸Â£Ã Â¹Å’Ã Â¸Â¡Ã Â¸ÂªÃ Â¸Â£Ã Â¹â€°Ã Â¸Â²Ã Â¸â€¡Ã Â¸â€žÃ Â¸Â³Ã Â¸â€šÃ Â¸Â­Ã Â¹Æ’Ã Â¸Â«Ã Â¸Â¡Ã Â¹Ë†
    public function create()
    {
        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        return view('teller.requests.create', compact('tellerProfile'));
    }

    // Ã°Å¸â€™Â¾ Ã Â¸Å¡Ã Â¸Â±Ã Â¸â„¢Ã Â¸â€”Ã Â¸Â¶Ã Â¸ÂÃ Â¸â€žÃ Â¸Â³Ã Â¸â€šÃ Â¸Â­Ã Â¹Æ’Ã Â¸Â«Ã Â¸Â¡Ã Â¹Ë†
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name'        => 'required|string|max:255',
            'business_type'     => 'nullable|string|max:255',
            'store_address'     => 'nullable|string',
            'pos_serial'        => 'nullable|string|max:255',
            'bank_account'      => 'nullable|string|max:255',
            'installation_date' => 'required|date',
            'attachments.*'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data['pos_serial'] = trim($data['pos_serial'] ?? '') ?: null;

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        $data['branch_id'] = $tellerProfile->branch_id;
        $data['unit_id'] = $tellerProfile->unit_id;

        $this->ensureUnitMatchesBranch($data['branch_id'], $data['unit_id']);

        // Ã¢Å“â€¦ Ã Â¸Â­Ã Â¸Â±Ã Â¸â€ºÃ Â¹â€šÃ Â¸Â«Ã Â¸Â¥Ã Â¸â€Ã Â¹â€žÃ Â¸Å¸Ã Â¸Â¥Ã Â¹Å’Ã Â¹ÂÃ Â¸â„¢Ã Â¸Å¡
        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($paths) ? json_encode($paths) : null;
        $data['teller_id'] = Auth::user()->teller_id;
        $data['approval_status'] = 'pending';

        DB::transaction(function () use (&$data) {
            $latest = OnboardingRequest::lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($latest) {
                $raw = (string) ($latest->refer_code ?? '');
                $lastNumeric = preg_match('/^\d+$/', $raw) ? $raw : (string) $latest->id;
                $nextNumber = (int) substr(str_pad($lastNumeric, 8, '0', STR_PAD_LEFT), -8) + 1;
            }

            // Format ໃໝ່: ເລກ 8 ຫຼັກ (ເພີ່ມ 0 ນຳໜ້າ)
            $data['refer_code'] = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);

            OnboardingRequest::create($data);
        });

        return redirect()->route('teller.dashboard')->with('success');
    }

    // Ã°Å¸Â§Â° Ã Â¸Å¸Ã Â¸Â­Ã Â¸Â£Ã Â¹Å’Ã Â¸Â¡Ã Â¹ÂÃ Â¸ÂÃ Â¹â€°Ã Â¹â€žÃ Â¸â€š
    public function edit($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::user()->teller_id)
            ->firstOrFail();

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);

        return view('teller.requests.edit', compact('request', 'tellerProfile'));
    }

    // Ã°Å¸â€â€ž Ã Â¸Â­Ã Â¸Â±Ã Â¸â€ºÃ Â¹â‚¬Ã Â¸â€Ã Â¸â€¢Ã Â¸â€šÃ Â¹â€°Ã Â¸Â­Ã Â¸Â¡Ã Â¸Â¹Ã Â¸Â¥
    public function update(Request $request, $id)
    {
        $record = OnboardingRequest::where('teller_id', auth()->user()->teller_id)->findOrFail($id);
        $wasRejected = $record->approval_status === 'rejected';

        $data = $request->validate([
            'store_name'         => 'required|string|max:255',
            'business_type'      => 'nullable|string|max:255',
            'store_address'      => 'nullable|string',
            'pos_serial'         => 'nullable|string|max:255',
            'bank_account'       => 'nullable|string|max:50',
            'installation_date'  => 'required|date',
            'attachments.*'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'delete_attachments' => 'array',
            'delete_attachments.*' => 'integer',
        ]);
        $data['pos_serial'] = trim($data['pos_serial'] ?? '') ?: null;


        // Ã Â¸â€Ã Â¸Â¶Ã Â¸â€¡Ã Â¸Â£Ã Â¸Â²Ã Â¸Â¢Ã Â¸ÂÃ Â¸Â²Ã Â¸Â£Ã Â¹â€žÃ Â¸Å¸Ã Â¸Â¥Ã Â¹Å’Ã Â¹â‚¬Ã Â¸â€Ã Â¸Â´Ã Â¸Â¡
        $existing = json_decode($record->attachments ?? '[]', true);

        // Ã¢Å“â€¦ Ã Â¸Â¥Ã Â¸Å¡Ã Â¹â€žÃ Â¸Å¸Ã Â¸Â¥Ã Â¹Å’Ã Â¸â€”Ã Â¸ÂµÃ Â¹Ë†Ã Â¹â‚¬Ã Â¸Â¥Ã Â¸Â·Ã Â¸Â­Ã Â¸Â
        $toDelete = $request->input('delete_attachments', []);
        foreach ($toDelete as $idx) {
            if (isset($existing[$idx])) {
                Storage::disk('public')->delete($existing[$idx]);
                unset($existing[$idx]);
            }
        }
        $existing = array_values($existing);

        // Ã¢Å“â€¦ Ã Â¹â‚¬Ã Â¸Å¾Ã Â¸Â´Ã Â¹Ë†Ã Â¸Â¡Ã Â¹â€žÃ Â¸Å¸Ã Â¸Â¥Ã Â¹Å’Ã Â¹Æ’Ã Â¸Â«Ã Â¸Â¡Ã Â¹Ë†
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $existing[] = $file->store('attachments', 'public');
            }
        }

        $data['attachments'] = !empty($existing) ? json_encode($existing) : null;

        $tellerProfile = Auth::user()->loadMissing(['branch', 'unit']);
        $data['branch_id'] = $tellerProfile->branch_id;
        $data['unit_id'] = $tellerProfile->unit_id;

        $this->ensureUnitMatchesBranch($data['branch_id'], $data['unit_id']);

        // Ã¢Å“â€¦ Ã Â¸Â­Ã Â¸Â±Ã Â¸â€ºÃ Â¹â‚¬Ã Â¸â€Ã Â¸â€¢Ã Â¸â€šÃ Â¹â€°Ã Â¸Â­Ã Â¸Â¡Ã Â¸Â¹Ã Â¸Â¥
        $record->update($data);

        if ($wasRejected) {
            $record->approval_status = 'pending';
            $record->admin_remark = null;
            $record->save();
        }

        return redirect()
            ->route('teller.requests.show', $record->id)
            ->with('success', 'ບັນທຶກການແກ້ໄຂສຳເລັດ');
    }

    // Ã°Å¸â€˜ÂÃ¯Â¸Â Ã Â¹ÂÃ Â¸ÂªÃ Â¸â€Ã Â¸â€¡Ã Â¸Â£Ã Â¸Â²Ã Â¸Â¢Ã Â¸Â¥Ã Â¸Â°Ã Â¹â‚¬Ã Â¸Â­Ã Â¸ÂµÃ Â¸Â¢Ã Â¸â€Ã Â¸â€žÃ Â¸Â³Ã Â¸â€šÃ Â¸Â­
    public function show($id)
    {
        $request = OnboardingRequest::where('id', $id)
            ->where('teller_id', Auth::user()->teller_id)
            ->with(['branch', 'unit'])
            ->firstOrFail();

        return view('teller.requests.show', compact('request'));
    }

    protected function ensureUnitMatchesBranch(?int $branchId, ?int $unitId): void
    {
        if (!$unitId) {
            return;
        }

        if (!$branchId) {
            throw ValidationException::withMessages([
                'branch_id' => __('Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½TÃ¯Â¿Â½Ã¯Â¿Â½^Ã¯Â¿Â½Ã¯Â¿Â½?Ã¯Â¿Â½Ã¯Â¿Â½?Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½%Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½,Ã¯Â¿Â½Ã¯Â¿Â½Ã¯Â¿Â½'),
            ]);
        }

        $unit = BranchUnit::find($unitId);

        if (!$unit) {
            throw ValidationException::withMessages([
                'unit_id' => __('Ã ÂºÂ«Ã Âºâ„¢Ã Â»Ë†Ã ÂºÂ§Ã ÂºÂÃ ÂºÂÃ Â»Ë†Ã ÂºÂ­Ã ÂºÂÃ Âºâ€”Ã ÂºÂµÃ Â»Ë†Ã Â»â‚¬Ã ÂºÂ¥Ã ÂºÂ·Ã ÂºÂ­Ã ÂºÂÃ ÂºÅ¡Ã Â»ÂÃ Â»Ë†Ã Âºâ€“Ã ÂºÂ·Ã ÂºÂÃ Âºâ€¢Ã Â»â€°Ã ÂºÂ­Ã Âºâ€¡'),
            ]);
        }

        if ($branchId && (int) $unit->branch_id !== (int) $branchId) {
            throw ValidationException::withMessages([
                'unit_id' => __('Ã ÂºÂ«Ã Âºâ„¢Ã Â»Ë†Ã ÂºÂ§Ã ÂºÂÃ ÂºÂÃ Â»Ë†Ã ÂºÂ­Ã ÂºÂÃ ÂºÅ¡Ã Â»ÂÃ Â»Ë†Ã ÂºÂÃ ÂºÂ»Ã Âºâ€¡Ã ÂºÂÃ ÂºÂ±Ã ÂºÅ¡Ã ÂºÂªÃ ÂºÂ²Ã Âºâ€šÃ ÂºÂ²Ã Âºâ€”Ã ÂºÂµÃ Â»Ë†Ã Â»â‚¬Ã ÂºÂ¥Ã ÂºÂ·Ã ÂºÂ­Ã ÂºÂ'),
            ]);
        }
    }
}
