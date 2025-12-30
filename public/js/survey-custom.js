
        // ==================================
        // SELECTION FUNCTIONS
        // ==================================
        function updateSelection() {
            const checkboxes = document.querySelectorAll('.responden-check:checked');
            const count = checkboxes.length;
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = count;

            if (count > 0) {
                bulkActions.classList.add('show');
            } else {
                bulkActions.classList.remove('show');
            }

            // Update card selection style
            document.querySelectorAll('.responden-card').forEach(card => {
                const checkbox = card.querySelector('.responden-check');
                if (checkbox && checkbox.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });

            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.responden-check');
            document.getElementById('selectAll').checked = count === allCheckboxes.length && count > 0;
        }

        document.getElementById('selectAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.responden-check');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelection();
        });

        function deselectAll() {
            document.querySelectorAll('.responden-check').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateSelection();
        }

        function deleteSelected() {
            const checkboxes = document.querySelectorAll('.responden-check:checked');
            const ids = Array.from(checkboxes).map(cb => parseInt(cb.value));

            if (ids.length === 0) {
                showCustomDialog('Peringatan', 'Pilih responden yang ingin dihapus', false);
                return;
            }

            showCustomDialog(
                'Hapus Responden yang Dipilih?',
                `Anda akan menghapus ${ids.length} responden beserta SEMUA data terkait (kuesioner, usaha, dll). Tindakan ini tidak dapat dibatalkan!`,
                true,
                () => submitBulkDelete(ids)
            );
        }

        function deleteAllResponden() {
            const ids = Array.from(document.querySelectorAll('.responden-check'))
                .map(cb => parseInt(cb.value));

            if (ids.length === 0) {
                showCustomDialog('Peringatan', 'Tidak ada responden untuk dihapus', false);
                return;
            }

            showCustomDialog(
                'Hapus SEMUA Responden?',
                `Anda akan menghapus SEMUA ${ids.length} responden beserta SEMUA data terkait (kuesioner, usaha, dll). Tindakan ini tidak dapat dibatalkan!`,
                true,
                () => submitBulkDelete(ids)
            );
        }

        function showCustomDialog(title, message, showConfirmBtn, confirmCallback) {
            const overlay = document.getElementById('customDialogOverlay');
            const dialogTitle = document.getElementById('dialogTitle');
            const dialogMessage = document.getElementById('dialogMessage');
            const dialogActions = document.getElementById('dialogActions');

            dialogTitle.textContent = title;
            dialogMessage.textContent = message;

            if (showConfirmBtn) {
                dialogActions.innerHTML = `
                                    <button type="button" class="custom-dialog-btn cancel" onclick="closeCustomDialog()">
                                        Batal
                                    </button>
                                    <button type="button" class="custom-dialog-btn confirm" id="confirmDialogBtn">
                                        Hapus
                                    </button>
                                `;
                document.getElementById('confirmDialogBtn').onclick = () => {
                    confirmCallback();
                    closeCustomDialog();
                };
            } else {
                dialogActions.innerHTML = `
                                    <button type="button" class="custom-dialog-btn cancel" onclick="closeCustomDialog()">
                                        Tutup
                                    </button>
                                `;
            }

            // Remove previous warning class
            document.getElementById('customDialog').classList.remove('warning');
            
            // Add warning class if it's a delete confirmation (showConfirmBtn is true)
            if (showConfirmBtn) {
                document.getElementById('customDialog').classList.add('warning');
            }

            overlay.classList.add('show');
        }

        function closeCustomDialog() {
            document.getElementById('customDialogOverlay').classList.remove('show');
        }

        function submitBulkDelete(ids) {
            const form = document.getElementById('bulkDeleteForm');
            
            // Clear existing inputs
            const existingInputs = form.querySelectorAll('input[name="responden_ids[]"]');
            existingInputs.forEach(input => input.remove());

            // Add new inputs
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'responden_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            form.submit();
        }
