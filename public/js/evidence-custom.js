
    // ==================================
    // SELECTION FUNCTIONS
    // ==================================
    function updateSelection() {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        const count = checkboxes.length;
        const selectedCount = document.getElementById('selectedCount');
        const btnDeselect = document.getElementById('btnDeselect');
        const btnDeleteSelected = document.getElementById('btnDeleteSelected');

        if (selectedCount) {
             selectedCount.textContent = count;
        }

        if (count > 0) {
            if (btnDeselect) btnDeselect.style.display = 'inline-flex';
            if (btnDeleteSelected) btnDeleteSelected.style.display = 'inline-flex';
        } else {
            if (btnDeselect) btnDeselect.style.display = 'none';
            if (btnDeleteSelected) btnDeleteSelected.style.display = 'none';
        }

        // Update card selection style
        document.querySelectorAll('.evidence-card').forEach(card => {
            const checkbox = card.querySelector('.file-checkbox');
            if (checkbox && checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });

        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.file-checkbox');
        const selectAll = document.getElementById('selectAll');
        if (selectAll && allCheckboxes.length > 0) {
             selectAll.checked = count === allCheckboxes.length;
        }
    }

    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.file-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelection();
    });

    function deselectAll() {
        document.querySelectorAll('.file-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateSelection();
    }

    function deleteSelected() {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        const ids = Array.from(checkboxes).map(cb => parseInt(cb.value));

        if (ids.length === 0) {
            showCustomDialog('Peringatan', 'Pilih file yang ingin dihapus', false, null, 'warning');
            return;
        }

        showCustomDialog(
            'Hapus File yang Dipilih?',
            `Anda akan menghapus ${ids.length} file yang dipilih. Tindakan ini tidak dapat dibatalkan!`,
            true,
            () => submitBulkDelete(ids),
            'warning'
        );
    }

    function deleteAllFiles() {
        // Visual: Select all checkboxes
        document.querySelectorAll('.file-checkbox').forEach(cb => cb.checked = true);
        document.getElementById('selectAll').checked = true;
        updateSelection();

        const ids = Array.from(document.querySelectorAll('.file-checkbox'))
            .map(cb => parseInt(cb.value));

        if (ids.length === 0) {
            showCustomDialog('Peringatan', 'Tidak ada file untuk dihapus', false, null, 'warning');
            return;
        }

        showCustomDialog(
            'Hapus SEMUA File?',
             `Anda akan menghapus SEMUA ${ids.length} file yang ada. Tindakan ini tidak dapat dibatalkan!`,
            true,
            () => submitBulkDelete(ids),
            'warning'
        );
    }

    function showCustomDialog(title, message, showConfirmBtn, confirmCallback, type = 'info') {
        const overlay = document.getElementById('customDialogOverlay');
        const dialog = document.getElementById('customDialog');
        const dialogTitle = document.getElementById('dialogTitle');
        const dialogMessage = document.getElementById('dialogMessage');
        const dialogActions = document.getElementById('dialogActions');
        const dialogIcon = document.getElementById('dialogIcon');

        dialogTitle.textContent = title;
        dialogMessage.textContent = message;

        // Reset classes
        dialog.classList.remove('warning', 'success', 'error');
        dialog.classList.add(type);

        // Set Icon
        if (type === 'warning') dialogIcon.textContent = '⚠';
        else if (type === 'success') dialogIcon.textContent = '✓';
        else if (type === 'error') dialogIcon.textContent = '✕';
        else dialogIcon.textContent = 'ℹ';

        if (showConfirmBtn) {
            dialogActions.innerHTML = `
                                <button type="button" class="custom-dialog-btn cancel" onclick="closeCustomDialog()">
                                    Batal
                                </button>
                                <button type="button" class="custom-dialog-btn confirm" id="confirmDialogBtn">
                                    Hapus
                                </button>
                            `;
            const newConfirmBtn = document.getElementById('confirmDialogBtn');
            newConfirmBtn.onclick = () => {
                closeCustomDialog();
                if (confirmCallback) confirmCallback();
            };
        } else {
            dialogActions.innerHTML = `
                                <button type="button" class="custom-dialog-btn confirm" onclick="closeCustomDialog()" style="width: 100%;">
                                    OK
                                </button>
                            `;
        }

        overlay.classList.add('show');
    }

    function closeCustomDialog() {
        const overlay = document.getElementById('customDialogOverlay');
        overlay.classList.remove('show');
    }

    // Close dialog when clicking outside
    document.getElementById('customDialogOverlay').addEventListener('click', function (e) {
        if (e.target === this) {
            closeCustomDialog();
        }
    });

    function submitBulkDelete(ids) {
        const form = document.getElementById('bulkDeleteForm');

        // Remove any existing file_ids[] inputs
        form.querySelectorAll('input[name="file_ids[]"]').forEach(el => el.remove());

        // Add file_ids as array elements
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'file_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        form.submit();
    }
