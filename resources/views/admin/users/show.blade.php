@extends('layouts.admin')

@section('title', 'Teller Details')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">👁️ Teller Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <!-- View Mode -->
            <div id="view-mode">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <span class="badge
                        @if($user->status == 'approved') bg-success
                        @elseif($user->status == 'pending') bg-warning text-dark
                        @else bg-danger @endif">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Teller ID:</strong> {{ $user->teller_id ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Role:</strong>
                            <span class="badge bg-primary">{{ ucfirst($user->role ?? 'teller') }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Branch:</strong> {{ optional($user->branch)->name ?? 'Not Assigned' }}</p>
                        <p class="mb-2"><strong>Service Unit:</strong> {{ optional($user->unit)->name ?? 'Not Assigned' }}</p>
                        <p class="mb-2"><strong>Created:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mb-2"><strong>Last Updated:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if(!empty($user->attachments))
                <hr>
                <h6 class="fw-bold mb-3">Attachments</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($user->attachments as $filePath)
                    @php
                    $fileUrl = asset('storage/' . $filePath);
                    $fileName = basename($filePath);
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    @endphp
                    <div class="card p-2 shadow-sm d-flex flex-row align-items-center gap-2"
                        style="cursor: pointer; width: 220px; border: 1px solid #e2e8f0;"
                        onclick="openPreview('{{ $fileUrl }}', '{{ $fileName }}', '{{ $extension }}')">

                        @if(in_array($extension, ['jpg','jpeg','png']))
                        <img src="{{ $fileUrl }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        @elseif($extension === 'pdf')
                        <div class="d-flex align-items-center justify-content-center rounded bg-light" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-pdf-fill text-danger fs-4"></i>
                        </div>
                        @else
                        <div class="d-flex align-items-center justify-content-center rounded bg-light" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-earmark-text text-secondary fs-4"></i>
                        </div>
                        @endif

                        <div class="text-truncate" style="flex: 1;">
                            <span class="d-block small fw-bold text-truncate" title="{{ $fileName }}" style="color: #334155;">{{ $fileName }}</span>
                            <span class="d-block small text-muted" style="font-size: 0.75rem;">{{ strtoupper($extension) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($user->status == 'pending')
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Pending Approval:</strong> This teller account is awaiting approval.
                </div>
                @endif
            </div>

            <!-- Edit Form (Hidden by default) -->
            <form id="edit-mode" action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-none">
                @csrf
                @method('PUT')
                <h5 class="mb-3">✏️ Edit Teller Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Branch</label>
                        <select name="branch_id" class="form-select">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Service Unit</label>
                        <select name="unit_id" class="form-select" id="unit-select">
                            <option value="">-- Select Unit --</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}"
                                data-branch-id="{{ $unit->branch_id }}"
                                {{ $user->unit_id == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="toggleEdit()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex gap-2" id="action-buttons">
        @if($user->status == 'pending')
        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success" onclick="return confirm('Approve this teller?')">
                ✅ Approve
            </button>
        </form>
        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="rejected">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this teller?')">
                ❌ Reject
            </button>
        </form>
        @endif

        <button type="button" class="btn btn-warning" onclick="toggleEdit()">✏️ Edit</button>

        <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-info" onclick="return confirm('Reset password for this user?')">
                🔑 Reset Password
            </button>
        </form>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this teller?')">
                🗑️ Delete
            </button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">⬅️ Back</a>
    </div>
</div>

<script>
    function toggleEdit() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        const actionButtons = document.getElementById('action-buttons');

        if (editMode.classList.contains('d-none')) {
            // Switch to Edit Mode
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            actionButtons.classList.add('d-none');
        } else {
            // Switch to View Mode
            editMode.classList.add('d-none');
            viewMode.classList.remove('d-none');
            actionButtons.classList.remove('d-none');
        }
    }

    // Dynamic Branch-Unit Filtering
    document.addEventListener('DOMContentLoaded', function() {
        const branchSelect = document.querySelector('select[name="branch_id"]');
        const unitSelect = document.getElementById('unit-select');

        if (!branchSelect || !unitSelect) return;

        // Clone all options on load to preserve them
        const allOptions = Array.from(unitSelect.options).map(opt => opt.cloneNode(true));

        function filterUnits() {
            const selectedBranchId = branchSelect.value;
            const currentUnitId = unitSelect.value; // Capture current selection before clearing

            // Clear current options
            unitSelect.innerHTML = '';

            let foundSelected = false;

            allOptions.forEach(option => {
                // Always include placeholder
                if (option.value === "") {
                    unitSelect.appendChild(option.cloneNode(true));
                    return;
                }

                const unitBranchId = option.getAttribute('data-branch-id');

                // Logic: Show if no branch selected OR ID matches
                // Use loose comparison (==) to handle string vs number
                if (!selectedBranchId || unitBranchId == selectedBranchId) {
                    const newOption = option.cloneNode(true);
                    unitSelect.appendChild(newOption);

                    // Restore selection if it matches
                    if (newOption.value == currentUnitId) {
                        newOption.selected = true;
                        foundSelected = true;
                    }
                }
            });

            // If we didn't find the previously selected unit (e.g. branch changed), reset to placeholder
            if (!foundSelected) {
                unitSelect.value = "";
            }
        }

        // Event Listener
        branchSelect.addEventListener('change', filterUnits);

        // Initial Filter
        filterUnits();
    });
</script>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="height: 85vh; border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0 py-3 px-4" style="background: white; position: absolute; top: 0; left: 0; right: 0; z-index: 10;">
                <h5 class="modal-title text-dark fw-bold" id="previewTitle" style="font-size: 1.1rem;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background-color: #f1f5f9; padding: 10px; border-radius: 50%; opacity: 1;"></button>
            </div>
            <div class="modal-body p-0 bg-light d-flex align-items-center justify-content-center" id="previewContainer" style="padding-top: 60px !important;"></div>
        </div>
    </div>
</div>

<script>
    function openPreview(fileUrl, fileName, extension) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        document.getElementById('previewTitle').textContent = fileName;
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';

        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            container.innerHTML = `<img src="${fileUrl}" class="img-fluid shadow-sm" style="max-height: 100%; max-width: 100%; border-radius: 8px;">`;
        } else if (extension === 'pdf') {
            container.innerHTML = `<iframe src="${fileUrl}" width="100%" height="100%" style="border:0;"></iframe>`;
        } else {
            container.innerHTML = `
                <div class="text-center">
                    <div class="mb-3"><i class="bi bi-file-earmark-text text-secondary" style="font-size: 4rem;"></i></div>
                    <h5 class="text-secondary mb-3">Unable to preview</h5>
                    <a href="${fileUrl}" class="btn btn-primary px-4 rounded-pill" download>
                        <i class="bi bi-download me-2"></i> Download File
                    </a>
                </div>`;
        }
        modal.show();
    }
</script>
@endsection