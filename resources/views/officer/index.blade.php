@extends('components.master')

@section('content')
    <div class="container-fluid pt-2 d-flex justify-content-center">
        <div class="card shadow-sm w-100" style="max-width: 900px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Daftar Officer</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOfficerModal">
                    <i class="fas fa-plus"></i> Tambah Officer
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped table-hover" id="officerTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Badge Number</th>
                            <th>Rank</th>
                            <th>Assigned Area</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="officerTableBody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Officer -->
    <div class="modal fade" id="addOfficerModal" tabindex="-1" aria-labelledby="addOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Officer Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="officerForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <small id="nameError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="badge_number" class="form-label">Badge Number</label>
                            <input type="text" class="form-control" id="badge_number" name="badge_number">
                            <small id="badge_numberError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="rank" class="form-label">Rank</label>
                            <input type="text" class="form-control" id="rank" name="rank">
                            <small id="rankError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="assigned_area" class="form-label">Area Penugasan</label>
                            <input type="text" class="form-control" id="assigned_area" name="assigned_area">
                            <small id="assigned_areaError" class="text-danger"></small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Officer -->
    <div class="modal fade" id="editOfficerModal" tabindex="-1" aria-labelledby="editOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Officer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editOfficerForm">
                        <input type="hidden" id="editOfficerId" name="officer_id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name">
                            <small id="editNameError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editBadgeNumber" class="form-label">Badge Number</label>
                            <input type="text" class="form-control" id="editBadgeNumber" name="badge_number">
                            <small id="editBadgeNumberError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editRank" class="form-label">Rank</label>
                            <input type="text" class="form-control" id="editRank" name="rank">
                            <small id="editRankError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="editAssignedArea" class="form-label">Area Penugasan</label>
                            <input type="text" class="form-control" id="editAssignedArea" name="assigned_area">
                            <small id="editAssignedAreaError" class="text-danger"></small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan Script -->
    <script src="{{ asset('js/officers.js') }}"></script>
@endsection
