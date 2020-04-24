$('.check-role').click((e)=>{
    const id = $(e.target).attr('data-id');
    $.get({
        url: `../api/toggle-admin/${id}`,
        success : (response) => {
            $('.alert-place').html(response)
        }
    });
});
