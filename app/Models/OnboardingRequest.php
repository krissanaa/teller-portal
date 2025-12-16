<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingRequest extends Model
{
    use HasFactory;

    /**
     * เก็บข้อมูลในตาราง workflow ใหม่ที่มีเฉพาะสถานะ
     */
    protected $table = 'onboarding_request_flows';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * ฟิลด์ที่เปิดให้กรอกค่า (ตามที่ผู้ใช้ต้องการ)
     */
    protected $fillable = [
        'teller_id',
        'status',
        'remark',
        'store_name',
        'business_type',
        'store_address',
        'bank_account',
        'installation_date',
        'branch_id',
        'unit_id',
        'attachments',
        'refer_code',
        'approval_status',
        'admin_remark',
    ];

    /**
     * ค่าเริ่มต้นของ status เมื่อสร้างเรคคอร์ดใหม่
     */
    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    /**
     * ช่วยกรองเฉพาะคำขอที่รออนุมัติ
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * ช่วยกรองคำขอของเทลเลอร์คนใดคนหนึ่ง
     */
    public function scopeForTeller($query, int $tellerId)
    {
        return $query->where('teller_id', $tellerId);
    }

    /**
     * ใช้เช็คง่าย ๆ ว่าคำขอถูกปฏิเสธหรือไม่
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
