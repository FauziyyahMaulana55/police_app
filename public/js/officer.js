if (window.location.pathname.includes('/panel-control/officers')) {
    document.addEventListener("DOMContentLoaded", function () {
        const officerForm = document.getElementById('officerForm');
        const editOfficerForm = document.getElementById('editOfficerForm');

        if (officerForm) officerForm.addEventListener('submit', addOfficer);
        if (editOfficerForm) editOfficerForm.addEventListener('submit', updateOfficer);

        fetchOfficers();
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    async function fetchOfficers() {
        try {
            const token = decodeURIComponent(getCookie('token'));
            const response = await axios.get('/api/panel-control/officers', {
                headers: { Authorization: `Bearer ${token}` },
                withCredentials: true
            });
            displayOfficers(response.data.data);
        } catch (error) {
            console.error("Gagal memuat data officer:", error);
        }
    }

    async function addOfficer(event) {
        event.preventDefault();
        const form = event.target;

        const data = {
            name: form.querySelector('#name').value.trim(),
            badge_number: form.querySelector('#badge_number').value.trim(),
            rank: form.querySelector('#rank').value.trim(),
            assigned_area: form.querySelector('#assigned_area').value.trim(),
        };

        // reset error fields
        ['name', 'badge_number', 'rank', 'assigned_area'].forEach(f => {
            const el = form.querySelector(`#${f}Error`);
            if (el) el.textContent = "";
        });

        try {
            const token = decodeURIComponent(getCookie('token'));
            const response = await axios.post('/api/panel-control/officers', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                withCredentials: true
            });

            Swal.fire({
                icon: 'success',
                title: response.data.message || 'Berhasil menambahkan',
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000
            });

            // close modal, reset form, refresh data
            bootstrap.Modal.getInstance(document.getElementById('addOfficerModal')).hide();
            form.reset();
            fetchOfficers();

        } catch (error) {
            if (error.response?.status === 422) {
                const errs = error.response.data.errors;
                for (let f in errs) {
                    const el = form.querySelector(`#${f}Error`);
                    if (el) el.textContent = errs[f][0];
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: error.response?.data?.message || 'Terjadi kesalahan.',
                    toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 2000
                });
            }
        }
    }

    function displayOfficers(data) {
        const tbody = document.getElementById("officerTableBody");
        if ($.fn.DataTable.isDataTable('#officerTable')) {
            $('#officerTable').DataTable().clear().destroy();
        }

        tbody.innerHTML = data.length ? '' : `<tr><td colspan="6" class="text-center">Data Officer Kosong</td></tr>`;

        window.officerData = data;

        data.forEach((item, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td>${item.name}</td>
                <td>${item.badge_number}</td>
                <td>${item.rank}</td>
                <td>${item.assigned_area}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editOfficerModal" onclick="showEditOfficerModal(${item.id}, ${idx})">
                        <i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger" onclick="confirmDeleteOfficer(${item.id})">
                                <i class="fas fa-trash"></i> Hapus</button>
                </td>`;
            tbody.appendChild(tr);
        });

        $('#officerTable').DataTable({
            responsive: true, autoWidth: false,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" },
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Tidak ada data tersedia"
            }
        });
    }

    function showEditOfficerModal(id, index) {
        clearEditErrors();
        const o = window.officerData[index];
        document.getElementById("editOfficerId").value = id;
        document.getElementById("editName").value = o.name;
        document.getElementById("editBadgeNumber").value = o.badge_number;
        document.getElementById("editRank").value = o.rank;
        document.getElementById("editAssignedArea").value = o.assigned_area;
    }

    async function updateOfficer(e) {
        e.preventDefault();
        clearEditErrors();

        const id = document.getElementById("editOfficerId").value;
        const data = {
            name: document.getElementById("editName").value.trim(),
            badge_number: document.getElementById("editBadgeNumber").value.trim(),
            rank: document.getElementById("editRank").value.trim(),
            assigned_area: document.getElementById("editAssignedArea").value.trim(),
        };

        try {
            const token = decodeURIComponent(getCookie('token'));
            const res = await axios.put(`/api/panel-control/officers/${id}`, data, {
                headers: { Authorization: `Bearer ${token}`, 'Content-Type': 'application/json' },
                withCredentials: true
            });
            Swal.fire({
                icon: 'success',
                title: res.data.message || 'Berhasil update',
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000
            });
            bootstrap.Modal.getInstance(document.getElementById('editOfficerModal')).hide();
            fetchOfficers();
        } catch (error) {
            if (error.response?.status === 422) {
                const errs = error.response.data.errors;
                for (let f in errs) {
                    const el = document.getElementById(`edit${f.charAt(0).toUpperCase() + f.slice(1)}Error`);
                    if (el) el.textContent = errs[f][0];
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Update',
                    text: error.response?.data?.message || 'Terjadi kesalahan.',
                    toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 2000
                });
            }
        }
    }

    async function confirmDeleteOfficer(id) {
        const res = await Swal.fire({
            icon: 'warning',
            title: 'Yakin ingin menghapus?',
            text: 'Data ini akan dihapus permanen!',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        });

        if (res.isConfirmed) {
            deleteOfficer(id);
        }
    }


    async function deleteOfficer(id) {
        try {
            const token = decodeURIComponent(getCookie('token'));
            const res = await axios.delete(`/api/panel-control/officers/${id}`, {
                headers: { Authorization: `Bearer ${token}` }, withCredentials: true
            });
            Swal.fire({
                icon: 'success',
                title: res.data.message || 'Berhasil dihapus',
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000
            });
            fetchOfficers();
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menghapus',
                text: error.response?.data?.message || 'Terjadi kesalahan.',
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000
            });
        }
    }

    function clearEditErrors() {
        ['Name', 'BadgeNumber', 'Rank', 'AssignedArea'].forEach(f => {
            const el = document.getElementById(`edit${f}Error`);
            if (el) el.textContent = "";
        });
    }

    window.showEditOfficerModal = showEditOfficerModal;
    window.confirmDeleteOfficer = confirmDeleteOfficer;
}
