/**
 * TechnicalBabaOffice - Admin JS
 */
$(document).ready(function () {

  /* ========== Confirm Delete ========== */
  $(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    const url  = $(this).attr('href');
    const item = $(this).data('item') || 'this item';
    if (confirm('Are you sure you want to delete ' + item + '?\n\nYeh action undo nahi ho sakta!')) {
      window.location.href = url;
    }
  });

  /* ========== Toggle Active Status (AJAX) ========== */
  $(document).on('change', '.toggle-status', function () {
    const id     = $(this).data('id');
    const type   = $(this).data('type');
    const val    = this.checked ? 1 : 0;
    const $this  = $(this);

    $.post('ajax.php', { action: 'toggle_status', id, type, value: val, csrf: $('meta[name=csrf]').attr('content') })
      .done(function (res) {
        if (!res.success) {
          alert('Update failed: ' + res.message);
          $this.prop('checked', !$this.prop('checked'));
        }
      })
      .fail(function () {
        $this.prop('checked', !$this.prop('checked'));
        alert('Server error. Please try again.');
      });
  });

  /* ========== Auto-dismiss alerts ========== */
  setTimeout(function () {
    $('.alert-dismissible').fadeOut(500);
  }, 4000);

  /* ========== YouTube ID preview ========== */
  $('#youtube_id').on('input', function () {
    const id = $(this).val().trim();
    const preview = $('#yt-preview');
    if (id.length === 11) {
      preview.attr('src', 'https://img.youtube.com/vi/' + id + '/hqdefault.jpg')
             .show();
    } else {
      preview.hide();
    }
  });

});
