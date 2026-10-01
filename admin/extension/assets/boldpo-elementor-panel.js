/**
 * Keeps the "Edit Template" button in the BoldPost widget's Elementor panel
 * pointing at the template the user has selected.
 *
 * This was embedded as a <script> inside a Controls_Manager::RAW_HTML control.
 * The logic is unchanged; it is now a file enqueued on Elementor's editor hook,
 * and the admin URL it needs is localized rather than interpolated into JS.
 */
(function () {
    function updateEditBtn() {
        var sel = document.querySelector('[data-setting="template_id"]');
        var btn = document.getElementById('boldpo-edit-template-btn');
        if (!sel || !btn) return;
        var id = sel.value;
        if (id) {
            btn.href = boldpoElementorPanel.editUrl + '?post=' + id + '&action=edit';
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
        } else {
            btn.href = '#';
            btn.style.opacity = '0.5';
            btn.style.pointerEvents = 'none';
        }
    }

    updateEditBtn();

    var obs = new MutationObserver(updateEditBtn);
    var panel = document.querySelector('.elementor-panel');
    if (panel) obs.observe(panel, { childList: true, subtree: true, attributes: true });
})();
