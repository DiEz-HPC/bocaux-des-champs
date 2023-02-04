
document.addEventListener("htmx:beforeRequest", function (event) {
    if (event.detail.requestConfig.parameters.status && event.detail.requestConfig.parameters.status == 2) {
        if (!confirm("Voulez-vous vraiment supprimer ce message ?")) {
            event.preventDefault();
            event.detail.elt.value = event.detail.elt.dataset.initialvalue;
            event.detail.elt.querySelector (`option[value="${
                event.detail.elt.dataset.initialvalue
            }"]`).selected = true;
        } else {
            document.getElementById (`line-${
                event.detail.elt.dataset.lineid
            }`).remove();
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    handleStatusChange();
    const modal = new Modal();
});

const handleStatusChange = () => {
    const selectors = document.querySelectorAll('select[name="status"]');

    for (let i = 0; i < selectors.length; i++) {
        selectors[i].addEventListener('change', function () {
            let value = selectors[i].value;
            let lineId = selectors[i].dataset.lineid;
            let status = document.getElementById (`message-status-${lineId}`);
            if (value == 0) {
                status.innerHTML = '<span class="badge badge-danger">Non publié</span>';
            } else if (value == 1) {
                status.innerHTML = '<span class="badge badge-success">Publié</span>';
            }
        });
    }
}

$.fn.dataTable.ext.order['dom-select'] = function (settings, col) {
    return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
        return $('select', td).val();
    });
};
$(document).ready(function () {
    $('#contactTable').DataTable({
        columns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null, {
                orderDataType: 'dom-select'
            },
        ],
        searching: false,
        language: {
            lengthMenu: 'Nombre de résultats par page _MENU_',
            zeroRecords: 'Aucun message pour le moment',
            info: '_PAGE_ sur _PAGES_'
        }
    });
});