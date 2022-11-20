$(document).find('.withseparator').on({
    keyup: function() {
        formatCurrency($(this));
    },
    blur: function() {
        formatCurrency($(this), "blur");
    }
});

$(document).ready(function () {

    $('.refresh-rkas').click(function (e) {
        e.preventDefault();
        location.reload();
    });

    $('.unit').on('keyup change', function (e) {
        e.preventDefault();
        let this_row = $(this).closest('tr');

        let unit_price = this_row.find('.unit_price').val() || 0;
        let unit = $(this).val().replace(/[^0-9.]/g, '') || 0;

        let amount_total = parseInt(unit_price) * parseInt(unit);
        amount_total = Number(amount_total).toLocaleString('en', {
            maximumFractionDigits: 2,
            minimumFractionDigits: 2,
            currency: 'INR'
        });

        this_row.find('.amount_total').val(amount_total);
    });

    $('.unit_price').keyup(function (e) {
        e.preventDefault();
        let this_row = $(this).closest('tr');

        let unit = this_row.find('.unit').val() || 0;
        let unit_price = $(this).val().replace(/[^0-9.]/g, '') || 0;

        let amount_total = parseInt(unit) * parseInt(unit_price);
        amount_total = Number(amount_total).toLocaleString('en', {
            maximumFractionDigits: 2,
            minimumFractionDigits: 2,
            currency: 'INR'
        });

        this_row.find('.amount_total').val(amount_total);

    });

    $('.rkas-1').change(function (e) {

        e.preventDefault();

        let this_row = $(this).closest('tr');
        let this_td = $(this).closest('td');
        let received_funds = $(this).data('received_funds');
        let amount_total_label = this_row.find('.amount_total').val();
        let this_value_label = $(this).val();

        let amount_total = amount_total_label.replace(/[^0-9.]/g, '') || 0;
        let this_value = this_value_label.replace(/[^0-9.]/g, '') || 0;

        let summary_row = 0;
        let summaries = this_row.find('.rkas');
        summaries.each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_row = parseInt(summary_row) + parseInt(this_value)
        });

        let summary_col = 0;
        $('.rkas-1').each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_col = parseInt(summary_col) + parseInt(this_value)
        });

        if (parseInt(this_value) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${received_funds}`);
        } else if (parseInt(this_value) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${amount_total_label}`);
        } else if (parseInt(summary_row) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`telah melampaui sisa maksimal harga total`);
        } else if (parseInt(summary_col) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            let interval = parseInt(summary_col) - parseInt(received_funds);
            interval = Number(interval).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            $(this).next().html(`telah melampaui maksimal pemasukan Rp. ${interval}`);
        } else {
            $(this).next().css('display', 'none');

            let alocation = parseInt(amount_total) - parseInt(summary_row);

            let data = {
                row_amount_total: this_row.find('.amount_total').val().replace(/[^0-9.]/g, '') || 0,
                amount_total: this_value || 0,
                pemasukan_bos_detail_id: this_td.find('.pemasukan_detail_id').val(),
                golongan_rkas_name: this_td.find('.golongan_rkas_name').val(),
                golongan_rkas_id: this_td.find('.golongan_rkas_id').val(),
                sub_golongan_rkas_name: this_td.find('.sub_golongan_rkas_name').val(),
                sub_golongan_rkas_id: this_td.find('.sub_golongan_rkas_id').val(),
                description: this_td.find('.description').val(),
                volume: this_td.find('.volume').val(),
                unit: this_row.find('.unit').val(),
                unit_price: this_row.find('.unit_price').val().replace(/[^0-9.]/g, '') || 0,
            }

            storeRKAS(data)

            alocation = Number(alocation).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            if (alocation <= 0) {
                this_row.find('.alocation').html('Terpenuhi')
            } else {
                this_row.find('.alocation').html(alocation)
            }
        }

    });

    $('.rkas-2').change(function (e) {

        e.preventDefault();

        let this_row = $(this).closest('tr');
        let this_td = $(this).closest('td');
        let received_funds = $(this).data('received_funds');
        let amount_total_label = this_row.find('.amount_total').val();
        let this_value_label = $(this).val();

        let amount_total = amount_total_label.replace(/[^0-9.]/g, '') || 0;
        let this_value = this_value_label.replace(/[^0-9.]/g, '') || 0;

        let summary_row = 0;
        let summaries = this_row.find('.rkas');
        summaries.each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_row = parseInt(summary_row) + parseInt(this_value)
        });

        let summary_col = 0;
        $('.rkas-2').each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_col = parseInt(summary_col) + parseInt(this_value)
        });

        if (parseInt(this_value) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${received_funds}`);
        } else if (parseInt(this_value) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${amount_total_label}`);
        } else if (parseInt(summary_row) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`telah melampaui sisa maksimal harga total`);
        } else if (parseInt(summary_col) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            let interval = parseInt(summary_col) - parseInt(received_funds);
            interval = Number(interval).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            $(this).next().html(`telah melampaui maksimal pemasukan Rp. ${interval}`);
        } else {
            $(this).next().css('display', 'none');
            let alocation = parseInt(amount_total) - parseInt(summary_row);

            let data = {
                row_amount_total: this_row.find('.amount_total').val().replace(/[^0-9.]/g, '') || 0,
                amount_total: this_value || 0,
                pemasukan_bos_detail_id: this_td.find('.pemasukan_detail_id').val(),
                golongan_rkas_name: this_td.find('.golongan_rkas_name').val(),
                golongan_rkas_id: this_td.find('.golongan_rkas_id').val(),
                sub_golongan_rkas_name: this_td.find('.sub_golongan_rkas_name').val(),
                sub_golongan_rkas_id: this_td.find('.sub_golongan_rkas_id').val(),
                description: this_td.find('.description').val(),
                volume: this_td.find('.volume').val(),
                unit: this_row.find('.unit').val(),
                unit_price: this_row.find('.unit_price').val().replace(/[^0-9.]/g, '') || 0,
            }

            storeRKAS(data);

            alocation = Number(alocation).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            if (alocation <= 0) {
                this_row.find('.alocation').html('Terpenuhi')
            } else {
                this_row.find('.alocation').html(alocation)
            }
        }

    });

    $('.rkas-3').change(function (e) {

        e.preventDefault();

        let this_row = $(this).closest('tr');
        let this_td = $(this).closest('td');
        let received_funds = $(this).data('received_funds');
        let amount_total_label = this_row.find('.amount_total').val();
        let this_value_label = $(this).val();

        let amount_total = amount_total_label.replace(/[^0-9.]/g, '') || 0;
        let this_value = this_value_label.replace(/[^0-9.]/g, '') || 0;

        let summary_row = 0;
        let summaries = this_row.find('.rkas');
        summaries.each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_row = parseInt(summary_row) + parseInt(this_value)
        });

        let summary_col = 0;
        $('.rkas-3').each(function () {

            let this_value = $(this).val().replace(/[^0-9.]/g, '') || 0;
            summary_col = parseInt(summary_col) + parseInt(this_value)
        });

        if (parseInt(this_value) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${received_funds}`);
        } else if (parseInt(this_value) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`jangan lebih dari ${amount_total_label}`);
        } else if (parseInt(summary_row) > parseInt(amount_total)) {
            $(this).next().css('display', 'block');
            $(this).next().html(`telah melampaui sisa maksimal harga total`);
        } else if (parseInt(summary_col) > parseInt(received_funds)) {
            $(this).next().css('display', 'block');
            let interval = parseInt(summary_col) - parseInt(received_funds);
            interval = Number(interval).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            $(this).next().html(`telah melampaui maksimal pemasukan Rp. ${interval}`);
        } else {
            $(this).next().css('display', 'none');
            let alocation = parseInt(amount_total) - parseInt(summary_row);
            let data = {
                row_amount_total: this_row.find('.amount_total').val().replace(/[^0-9.]/g, '') || 0,
                amount_total: this_value || 0,
                pemasukan_bos_detail_id: this_td.find('.pemasukan_detail_id').val(),
                golongan_rkas_name: this_td.find('.golongan_rkas_name').val(),
                golongan_rkas_id: this_td.find('.golongan_rkas_id').val(),
                sub_golongan_rkas_name: this_td.find('.sub_golongan_rkas_name').val(),
                sub_golongan_rkas_id: this_td.find('.sub_golongan_rkas_id').val(),
                description: this_td.find('.description').val(),
                volume: this_td.find('.volume').val(),
                unit: this_row.find('.unit').val(),
                unit_price: this_row.find('.unit_price').val().replace(/[^0-9.]/g, '') || 0,
            }

            storeRKAS(data);
            alocation = Number(alocation).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            if (alocation <= 0) {
                this_row.find('.alocation').html('Terpenuhi')
            } else {
                this_row.find('.alocation').html(alocation)
            }
        }

    });

    const storeRKAS = (data) => {

        $.ajax({
            type: "POST",
            url: `${BASE_URL}/rkas/store`,
            data: data,
            success: function (response) {
                console.log(response);
            }
        });
    }

});
