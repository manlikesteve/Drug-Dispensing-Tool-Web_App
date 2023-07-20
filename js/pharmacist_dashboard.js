// Disable the submit button after it is clicked
$('form').on('submit', function () {
    $('button[type="submit"]').prop('disabled', true);
});