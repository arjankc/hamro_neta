$(function() {

	// Confirm deleting resources
	$("form[data-confirm]").submit(function() {
		if ( ! confirm($(this).attr("data-confirm"))) {
			return false;
		}
	});

    editables();
});

function editables () {
    //defaults
    $.fn.editable.defaults.mode = 'inline';
    //enable / disable
    $('#enable').click(function() {
        $('#user .editable').editable('toggleDisabled');
    });
    //editables
    // id = $(".votes").siblings("[name=hiddenID]").val();
    $('.votes').editable({
        url: '/admin/candidates/votes',
        type: 'text',
        name: 'votes',
        title: 'Enter votes',
        ajaxOptions: {
            type: 'post'
        }
    });

    //make username required
    // $('.votes').editable('option', 'validate', function(v) {
    //     if(isNaN(v)) return 'Vote must be a number';
    // });

    $('#user .editable').on('hidden', function(e, reason){
        if(reason === 'save' || reason === 'nochange') {
            var $next = $(this).closest('tr').next().find('.editable');
            setTimeout(function() {
                $next.editable('show');
            }, 300);
        }
    });
}
