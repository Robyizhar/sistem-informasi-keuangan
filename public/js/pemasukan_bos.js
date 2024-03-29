$(document).ready(function () {
    $('#form-save-update').validate({
        ignore: [],
        errorClass: "text-danger",
        errorElement: 'div',
        validClass: "form-success",
        rules: {
            year: { required: true },
            type: { required: true },
        },
        messages: {
            year: {
                required: "silahkan mengisi year"
            },
            type: {
                required: "silahkan mengisi type"
            },
        },
        errorPlacement: function (error, element) {
            if (element.parent('.inline-form').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.text-danger').each(function () {
                $(this).closest('.inline-form').addClass('error-class').append($(this));
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').removeClass("has-error");
        }
    });
});

$('.triggerSub').on('click', function () {

    if ($(".sub-list").length >= 3) {

        Swal.fire({
            text: `Jangan lebih dari 3 dong !`,
            target: '.wrapper',
            customClass: {
                container: 'position-fixed'
            },
            toast: true,
            position: 'top-right'
        });

    } else {

        let tr_clone = $(".template-sub-list").clone();
        tr_clone.removeClass('template-sub-list');
        tr_clone.addClass('sub-list');
        $("#table-data-sub").append(tr_clone);
        resetDataSub();

    }
});

function getDataDetail () {
    $.ajax({
        url: `${BASE_URL}/pemasukan-bos/get-detail`,
        type: "POST",
        dataType: 'json',
        data: { id: $('#id').val() },
        success: function (result) {

            result.forEach(row => {

                let tr_clone = $(".template-sub-list").clone();

                tr_clone.removeClass('template-sub-list');
                tr_clone.addClass('sub-list');
                tr_clone.find(".sub_name").val(row.name);
                tr_clone.find(".sub_id").val(row.id)

                let received_funds = Number(row.received_funds).toLocaleString('en', {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2,
                    currency: 'INR'
                });

                tr_clone.find(".sub_received_funds").val(received_funds)
                tr_clone.find(".sub_start_date").val(row.start_date)
                tr_clone.find(".sub_end_date").val(row.end_date)
                tr_clone.find(".removesub").attr('disabled', 'disabled')

                $("#table-data-sub").append(tr_clone);
                resetDataSub();

            });
        }
    });
}

function resetDataSub (){

    let name = $('#year').val();
    let index = 0;
    $(".sub-list").each(function () {

        let another = this;
        search_index = $(this).attr("childidx");
        $(this).find('input,select').each(function () {
            this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
            $(another).attr("childidx", index);
        });
        $(this).find('.index').html(index + 1)
        $(this).find('.sub_name').val(`Pemasukan Tahun ${name} Tahap ${index + 1}`);

        $(this).find('.withseparator').on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });

        $(this).find('.removesub').click(function (e) {

            e.preventDefault();
            let this_row = $(this).closest('tr');

            Swal.fire({
                title: 'Hapus data ini ?',
                text: "Anda tidak akan dapat memulihkan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this_row.remove();
                    Swal.fire( 'Berhasil!', 'Data berhail dihapus.', 'success' );
                    resetDataSub ()
                }
            });
        });

        index++;

    });
}
