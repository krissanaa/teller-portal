@extends('layouts.admin')

@section('title', 'Onboarding Requests')

@section('content')
@php
    use App\Models\TellerPortal\OnboardingRequest;
    use Illuminate\Support\Str;
@endphp

<style>
    :root {
        --admin-primary: #4f46e5;
        --admin-primary-dark: #4338ca;
        --admin-primary-light: #818cf8;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-neutral: #4b5563;
        --admin-border: rgba(17, 24, 39, 0.08);
        --admin-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        --admin-muted: #6b7280;
        --admin-bg: #f8fafc;
        --admin-card-bg: #ffffff;
    }

    body,
    .admin-onboarding-wrapper {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
        background: var(--admin-bg);
    }

    .admin-onboarding-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .headline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(115deg, rgba(79, 70, 229, 0.12), rgba(16, 185, 129, 0.12));
        border: 1px solid rgba(79, 70, 229, 0.18);
        border-radius: 18px;
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.08);
    }

    .headline h1 {
        margin: 0;
        font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        font-weight: 800;
        color: var(--admin-primary-dark);
    }

    .headline p {
        margin: 0.35rem 0 0;
        color: var(--admin-muted);
        font-size: 0.9rem;
    }

    .headline-user {
        text-align: right;
        color: var(--admin-primary-dark);
        font-weight: 600;
    }

    .headline-user small {
        display: block;
        color: var(--admin-muted);
        font-size: 0.78rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .summary-card {
        position: relative;
        background: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 1.15rem 1.25rem;
        box-shadow: var(--admin-shadow);
        overflow: hidden;
    }

    .summary-card::after {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0.25;
        background: linear-gradient(120deg, transparent, rgba(79, 70, 229, 0.15));
        pointer-events: none;
    }

    .summary-card.total::after { background: linear-gradient(120deg, transparent, rgba(79, 70, 229, 0.18)); }
    .summary-card.approved::after { background: linear-gradient(120deg, transparent, rgba(16, 185, 129, 0.2)); }
    .summary-card.pending::after { background: linear-gradient(120deg, transparent, rgba(245, 158, 11, 0.2)); }
    .summary-card.rejected::after { background: linear-gradient(120deg, transparent, rgba(239, 68, 68, 0.22)); }

    .summary-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.35rem;
        color: var(--admin-muted);
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .summary-value {
        display: block;
        font-size: clamp(1.8rem, 2.8vw, 2.2rem);
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    .summary-hint {
        font-size: 0.78rem;
        color: var(--admin-muted);
        margin-top: 0.25rem;
    }

    .filter-card {
        background: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        box-shadow: var(--admin-shadow);
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .filter-card h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-primary-dark);
    }

    .status-filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        border: 1px solid rgba(79, 70, 229, 0.15);
        background: rgba(79, 70, 229, 0.06);
        color: var(--admin-primary-dark);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .status-pill span {
        font-size: 0.78rem;
        color: rgba(79, 70, 229, 0.7);
        font-weight: 500;
    }

    .status-pill:hover {
        border-color: rgba(79, 70, 229, 0.4);
        background: rgba(79, 70, 229, 0.12);
    }

    .status-pill.is-active {
        border-color: var(--admin-primary);
        background: var(--admin-primary);
        color: #fff;
    }

    .status-pill.is-active span {
        color: #eef2ff;
    }

    .request-list {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
    }

    .request-card {
        background: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 18px;
        box-shadow: var(--admin-shadow);
        padding: 1.35rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }

    .request-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        border-radius: 18px 0 0 18px;
        background: rgba(79, 70, 229, 0.85);
    }

    .request-card.status-approved::before { background: rgba(16, 185, 129, 0.85); }
    .request-card.status-pending::before { background: rgba(245, 158, 11, 0.85); }
    .request-card.status-rejected::before { background: rgba(239, 68, 68, 0.85); }

    .request-header {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .request-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
    }

    .request-subtitle {
        margin: 0.25rem 0 0;
        color: var(--admin-muted);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.approved { background: rgba(16, 185, 129, 0.15); color: #047857; }
    .status-badge.pending { background: rgba(245, 158, 11, 0.18); color: #b45309; }
    .status-badge.rejected { background: rgba(239, 68, 68, 0.15); color: #b91c1c; }

    .request-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.85rem;
    }

    .meta-item {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
        background: rgba(148, 163, 184, 0.08);
        padding: 0.65rem 0.75rem;
        border-radius: 12px;
    }

    .meta-item i {
        color: var(--admin-primary);
        font-size: 1rem;
        margin-top: 0.15rem;
    }

    .meta-item span {
        display: block;
        font-size: 0.78rem;
        color: var(--admin-muted);
    }

    .meta-item strong {
        display: block;
        font-size: 0.86rem;
        color: #1f2937;
        font-weight: 700;
    }

    .request-notes {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .request-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.75rem;
        background: rgba(79, 70, 229, 0.08);
        border-radius: 999px;
        font-size: 0.78rem;
        color: var(--admin-primary-dark);
    }

    .request-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .request-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .request-actions .btn {
        border-radius: 10px;
        padding: 0.45rem 0.85rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .request-time {
        font-size: 0.78rem;
        color: var(--admin-muted);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: var(--admin-card-bg);
        border-radius: 18px;
        border: 1px solid var(--admin-border);
        color: var(--admin-muted);
    }

    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
        font-size: 0.85rem;
        color: var(--admin-muted);
    }

    @media (max-width: 768px) {
        .headline {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .headline-user {
            text-align: left;
        }

        .request-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .request-actions {
            width: 100%;
        }

        .request-actions .btn {
            flex: 1 1 auto;
            justify-content: center;
        }
    }
</style>


        @forelse($requests as $req)
            @php
                $attachmentsCount = is_array($req->attachments) ? count($req->attachments) : 0;
                $submittedAt = \Carbon\Carbon::parse($req->created_at);
                $tellerName = optional($req->teller)->name;
                $branchName = optional($req->branch)->name;
                $statusClass = 'status-' . $req->approval_status;
                $statusLabel = ucfirst($req->approval_status);
            @endphp
            <div class="request-card {{ $statusClass }}">
                <div class="request-header">
                    <div>
                        <div class="status-badge {{ $req->approval_status }}">
                            <i class="bi {{ $req->approval_status === 'approved' ? 'bi-check-circle' : ($req->approval_status === 'pending' ? 'bi-hourglass-split' : 'bi-x-circle') }}"></i>
                            {{ $statusLabel }}
                        </div>
                        <h3 class="request-title">{{ $req->store_name }}</h3>
                        @if($req->store_address)
                            <p class="request-subtitle"><i class="bi bi-geo-alt"></i> {{ Str::limit($req->store_address, 90) }}</p>
                        @endif
                    </div>
                    <div class="request-time">
                        <i class="bi bi-calendar-event"></i>
                        Submitted {{ $submittedAt->format('M d, Y \a\t h:i A') }}
                    </div>
                </div>

                <div class="request-meta-grid">
                    <div class="meta-item">
                        <i class="bi bi-person-circle"></i>
                        <div>
                            <strong>Teller</strong>
                            <span>{{ $tellerName ? $tellerName . ' (' . $req->teller_id . ')' : $req->teller_id }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-diagram-3"></i>
                        <div>
                            <strong>Branch</strong>
                            <span>{{ $branchName ?? 'Not specified' }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-briefcase"></i>
                        <div>
                            <strong>Business Type</strong>
                            <span>{{ $req->business_type ?? '–' }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-cpu"></i>
                        <div>
                            <strong>POS Serial</strong>
                            <span>{{ $req->pos_serial ?? '–' }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-bank"></i>
                        <div>
                            <strong>Bank Account</strong>
                            <span>{{ $req->bank_account ?? '–' }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-calendar-check"></i>
                        <div>
                            <strong>Installation</strong>
                            <span>{{ $req->installation_date ? \Carbon\Carbon::parse($req->installation_date)->format('M d, Y') : '–' }}</span>
                        </div>
                    </div>
                </div>

                <div class="request-notes">
                    <span class="request-tag">
                        <i class="bi bi-info-circle"></i>
                        Store status: {{ Str::title(str_replace('_', ' ', $req->store_status ?? 'unknown')) }}
                    </span>
                    <span class="request-tag">
                        <i class="bi bi-paperclip"></i>
                        Attachments: {{ $attachmentsCount }}
                    </span>
                    @if($req->admin_remark)
                        <span class="request-tag">
                            <i class="bi bi-chat-text"></i>
                            {{ Str::limit($req->admin_remark, 60) }}
                        </span>
                    @endif
                </div>

                <div class="request-footer">
                    <div class="request-actions">
                        <a href="{{ route('admin.onboarding.show', $req->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye"></i> View details
                        </a>
                        @if($req->approval_status === 'pending')
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="quickAction({{ $req->id }}, 'approve')">
                                <i class="bi bi-check2"></i> Approve
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="quickAction({{ $req->id }}, 'reject')">
                                <i class="bi bi-x"></i> Reject
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                <p>No onboarding requests found for this filter.</p>
            </div>
        @endforelse
    </div>

    @if($requests->hasPages())
        <div class="pagination-wrap">
            <span>Showing {{ $requests->firstItem() }} – {{ $requests->lastItem() }} of {{ $requests->total() }} requests</span>
            {{ $requests->links() }}
        </div>
    @endif
</div>

<form id="quick-action-form" method="POST" class="d-none">
    @csrf
</form>

<script>
    function quickAction(id, action) {
        const messages = {
            approve: 'Approve this onboarding request?',
            reject: 'Reject this onboarding request?'
        };

        if (!confirm(messages[action] || 'Proceed with this action?')) {
            return;
        }

        const form = document.getElementById('quick-action-form');
        form.action = `/admin/onboarding/${id}/${action}`;
        form.submit();
    }
</script>
@endsection
