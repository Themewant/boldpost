(function ($) {
    'use strict';

    var DATA = window.boldpoNoticeData || {};

    function persistDismiss(noticeId) {
        if (!noticeId || !DATA.ajaxUrl || !DATA.nonce) {
            return;
        }
        $.post(DATA.ajaxUrl, {
            action: 'boldpo_notice_ignore_plugin_notice',
            nonce: DATA.nonce,
            notice_id: noticeId
        });
    }

    $(document).on('click', '.boldpo-notice-maybe-later', function (e) {
        e.preventDefault();
        var $btn    = $(this);
        var $notice = $btn.closest('.boldpo-notice');
        var id      = $btn.data('notice_id') || $notice.data('notice_id');

        persistDismiss(id);
        $notice.fadeOut(180, function () { $(this).remove(); });
    });

    // Also persist when the WP core "X" dismiss button is clicked.
    $(document).on('click', '.boldpo-notice .notice-dismiss', function () {
        var $notice = $(this).closest('.boldpo-notice');
        var id      = $notice.data('notice_id');
        persistDismiss(id);
    });

})(jQuery);
