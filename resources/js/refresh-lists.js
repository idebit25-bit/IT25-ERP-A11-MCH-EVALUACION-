// Avisar a los listados de otras pestañas después de un guardado correcto.
const changeKey = 'capital-humano:last-change';
let pendingRefresh = false;

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.changeSaved === '1') {
        try {
            localStorage.setItem(changeKey, `${Date.now()}-${Math.random()}`);
        } catch {
            // El guardado y la redirección funcionan aunque no haya almacenamiento.
        }
    }
});

function refreshList() {
    if (document.body?.dataset.refreshList !== '1') return;
    if (document.visibilityState === 'hidden') {
        pendingRefresh = true;
        return;
    }
    window.location.reload();
}

window.addEventListener('storage', (event) => {
    if (event.key === changeKey && event.newValue) refreshList();
});
document.addEventListener('visibilitychange', () => {
    if (pendingRefresh && document.visibilityState === 'visible') refreshList();
});
window.addEventListener('pageshow', (event) => {
    if (event.persisted) refreshList();
});
