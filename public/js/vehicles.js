if (window.location.pathname.includes('/panel-control/vehicles')) {
    document.addEventListener("DOMContentLoaded", function () {
        const vehicleForm = document.getElementById('vehicleForm');
        const editVehicleForm = document.getElementById('editVehicleForm');

        if (vehicleForm) {
            vehicleForm.addEventListener('submit', addVehicle);
        }

        if (editVehicleForm) {
            editVehicleForm.addEventListener('submit', updateVehicle);
        }

        fetchVehicles();
    });

    async function fetchVehicles() {
        try {
            const rawToken = getCookie('token');
            if (!rawToken) {
                console.warn("Token tidak ditemukan");
                performActionLogout();
                return;
            }
            const decodedToken = decodeURIComponent(rawToken);

            const response = await axios.get("/api/panel-control/vehicles", {
                headers: {
                    "Authorization": `Bearer ${decodedToken}`
                },
                withCredentials: true
            });

            displayVehicles(response.data.data);
        } catch (error) {
            console.error("Gagal fetch data kendaraan:", error);
        }
    }

    async function addVehicle(event) {
        event.preventDefault();

        const vehicleForm = event.target;
        const licensePlate = vehicleForm.querySelector('#license_plate').value.trim();
        const type = vehicleForm.querySelector('#type').value.trim();
        const brand = vehicleForm.querySelector('#brand').value.trim();
        const color = vehicleForm.querySelector('#color').value.trim();
        const isStolenInput = vehicleForm.querySelector('input[name="is_stolen"]:checked');
        const isStolen = isStolenInput ? isStolenInput.value : null;

        // Error elements
        const licensePlateError = vehicleForm.querySelector('#license_plateError');
        const typeError = vehicleForm.querySelector('#typeError');
        const brandError = vehicleForm.querySelector('#brandError');
        const colorError = vehicleForm.querySelector('#colorError');
        const isStolenError = vehicleForm.querySelector('#is_stolenError');

        // Reset error messages
        if (licensePlateError) licensePlateError.textContent = "";
        if (typeError) typeError.textContent = "";
        if (brandError) brandError.textContent = "";
        if (colorError) colorError.textContent = "";
        if (isStolenError) isStolenError.textContent = "";

        try {
            const rawToken = getCookie('token');
            if (!rawToken) {
                performActionLogout();
                return;
            }
            const decodedToken = decodeURIComponent(rawToken);

            const response = await axios.post("/api/panel-control/vehicles", {
                license_plate: licensePlate,
                type: type,
                brand: brand,
                color: color,
                is_stolen: isStolen
            }, {
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${decodedToken}`
                },
                withCredentials: true
            });

            Swal.fire({
                icon: 'success',
                title: response.data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            setTimeout(() => {
                const modalEl = document.getElementById('addVehicleModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                vehicleForm.reset();
                fetchVehicles();
            }, 500);

        } catch (error) {
            if (error.response?.status === 422) {
                const data = error.response.data;
                const fields = ['license_plate', 'type', 'brand', 'color', 'is_stolen'];
                fields.forEach(field => {
                    const errorElement = document.getElementById(`${field}Error`);
                    if (errorElement && data.errors[field]) {
                        errorElement.textContent = data.errors[field][0];
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: error.response?.data?.message || 'Terjadi kesalahan.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            }
        }
    }

    function clearEditFormErrors() {
        document.getElementById("editLicensePlateError").textContent = "";
        document.getElementById("editTypeError").textContent = "";
        document.getElementById("editBrandError").textContent = "";
        document.getElementById("editColorError").textContent = "";
        document.getElementById("editIsStolenError").textContent = "";
    }

    function displayVehicles(data) {
        const tableBody = document.getElementById("VehicleTableBody");

        if ($.fn.DataTable.isDataTable('#vehiclesTable')) {
            $('#vehiclesTable').DataTable().clear().destroy();
        }
        tableBody.innerHTML = "";

        if (data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center">Data Vehicles Not Found</td></tr>`;
            return;
        }

        window.vehicleData = data;

        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${item.license_plate}</td>
                <td>${item.type}</td>
                <td>${item.brand}</td>
                <td>${item.color}</td>
                <td>
  <span style="color: ${Number(item.is_stolen) === 1 ? 'red' : 'green'};">
    ${Number(item.is_stolen) === 1 ? 'Dicuri' : 'Aman'}
  </span>
</td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editVehicleModal" onclick="showEditVehicleModal(${item.id}, ${index})">Edit</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteVehicle(${item.id})">Hapus</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        $('#vehiclesTable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Tidak ada data yang tersedia",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    }

    function showEditVehicleModal(id, index) {
        clearEditFormErrors();
        const item = window.vehicleData[index];

        document.getElementById("editVehicleId").value = id;
        document.getElementById("editLicensePlate").value = item.license_plate || '';
        document.getElementById("editType").value = item.type || '';
        document.getElementById("editBrand").value = item.brand || '';
        document.getElementById("editColor").value = item.color || '';

        if (item.is_stolen) {
            document.getElementById("editIsStolenYes").checked = true;
        } else {
            document.getElementById("editIsStolenNo").checked = true;
        }
    }

    async function updateVehicle(event) {
        event.preventDefault();
        clearEditFormErrors();

        const id = document.getElementById("editVehicleId").value;
        const license_plate = document.getElementById("editLicensePlate").value.trim();
        const type = document.getElementById("editType").value.trim();
        const brand = document.getElementById("editBrand").value.trim();
        const color = document.getElementById("editColor").value.trim();
        const is_stolen = document.getElementById("editIsStolenYes").checked ? 1 : 0;

        try {
            const token = decodeURIComponent(getCookie('token'));

            const response = await axios.put(`/api/panel-control/vehicles/${id}`, {
                license_plate,
                type,
                brand,
                color,
                is_stolen
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                withCredentials: true
            });

            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: response.data.message || "Berhasil memperbarui kendaraan"
            });

            const modalEl = document.getElementById('editVehicleModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            setTimeout(() => {
                fetchVehicles();
            }, 1000);
        } catch (error) {
            if (error.response?.status === 422) {
                const errors = error.response.data.errors;
                if (errors.license_plate) document.getElementById("editLicensePlateError").textContent = errors.license_plate[0];
                if (errors.type) document.getElementById("editTypeError").textContent = errors.type[0];
                if (errors.brand) document.getElementById("editBrandError").textContent = errors.brand[0];
                if (errors.color) document.getElementById("editColorError").textContent = errors.color[0];
                if (errors.is_stolen) document.getElementById("editIsStolenError").textContent = errors.is_stolen[0];
            } else {
                const errorMessage = error.response?.data?.message || "Terjadi kesalahan saat memperbarui kendaraan.";
                showErrorToast(errorMessage);
            }
        }
    }

    async function confirmDeleteVehicle(id) {
        const result = await Swal.fire({
            icon: 'warning',
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen!",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        });

        if (result.isConfirmed) {
            deleteVehicle(id);
        }
    }

    async function deleteVehicle(id) {
        try {
            const token = decodeURIComponent(getCookie('token'));

            const response = await axios.delete(`/api/panel-control/vehicles/${id}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                withCredentials: true
            });

            Swal.fire({
                icon: 'success',
                title: response.data.message || 'Data berhasil dihapus',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            setTimeout(() => location.reload(), 1000);
        } catch (error) {
            const errorMessage = error.response?.data?.message || "Terjadi kesalahan saat menghapus data.";
            showErrorToast(errorMessage);
        }
    }
}
