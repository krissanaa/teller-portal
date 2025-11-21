<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpKernel\DependencyInjection\AddAnnotatedClassesToCachePass;

class FullOnboardingExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($r) {
            return [
                $r->id,
                $r->refer_code,
                $r->teller_id,
                $r->branch_id,
                $r->unit_id,
                $r->store_name,
                $r->store_address,
                $r->business_type,
                $r->pos_serial,
                $r->bank_account,
                $r->installation_date,
                $r->store_status,
                $r->approval_status,
                $r->admin_remark,
                $r->created_at,
                $r->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Refer Code',
            'Teller ID',
            'Branch ID',
            'Unit ID',
            'Store Name',
            'Store Address',
            'Business Type',
            'POS Serial',
            'Bank Account',
            'Installation Date',
            'Store Status',
            'Approval Status',
            'Admin Remark',
            'Created At',
            'Updated At',
        ];
    }
}
