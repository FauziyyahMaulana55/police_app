if (window.location.pathname.includes('/panel-control/vehicles')) {
    document.addEventListener("DOMContentLoaded", function () {
        const vehicleForm = document.getElementById('vehicleForm');

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

        vehicleForm.addEventListener("submit", async function (event) {
            event.preventDefault();

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
                    console.warn("Token tidak ditemukan");
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
                }, 500);

                // Refresh list kendaraan setelah submit sukses
                await fetchVehicles();
            } catch (error) {
                if (error.response) {
                    const { status, data } = error.response;

                    if (status === 422 && data.errors) {
                        const fields = ['license_plate', 'type', 'brand', 'color', 'is_stolen'];
                        fields.forEach(field => {
                            const errorElement = document.getElementById(`${field}Error`);
                            if (errorElement && data.errors[field]) {
                                const messages = data.errors[field];
                                errorElement.textContent = Array.isArray(messages) ? messages.join(', ') : messages;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            text: data.message || 'Terjadi kesalahan, silakan coba lagi.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server tidak merespon',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                }
            }
        });

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
                    <td><span style="color: ${item.is_stolen ? 'red' : 'green'};">
                            ${item.is_stolen ? 'Dicuri' : 'Aman'}
                        </span></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editVehicleModal${item.id}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDeleteVehicle(${item.id})">Hapus</button>

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
        fetchVehicles();
    });
}
async function confirmDeleteVehicle(id) {
    const result = await Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This data will be permanently deleted!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    });


    if (result.isConfirmed) {
        deleteVehicle(id); // Perbaikan penting di sini!
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
            title: response.data.message || 'Data deleted successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });


        document.getElementById('VehicleTableBody').innerHTML = '';
        setTimeout(() => location.reload(), 1000);
    } catch (error) {
        console.error("Gagal menghapus data:", error);
        const errorMessage = error.response.data?.message || "Terjadi kesalahan saat menghapus data.";
        showErrorToast(errorMessage);
    }
}
