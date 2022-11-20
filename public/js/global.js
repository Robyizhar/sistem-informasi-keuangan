function formatNumber(n) {
    let xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return xx;
}

function formatDecimal(n) {
    let xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
    return xx;
}

function formatCurrency(input, blur) {

    let input_val = input.val();

    if (input_val === "")
        return;

    let original_len = input_val.length;
    let caret_pos = input.prop("selectionStart");

    if (input_val.indexOf(".") >= 0) {

        let decimal_pos = input_val.indexOf(".");
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);

        left_side = formatNumber(left_side);
        right_side = formatDecimal(right_side);

        if (blur === "blur")
            right_side += "00";


        right_side = right_side.substring(0, 2);
        input_val = "" + left_side + "." + right_side;

    } else {
        input_val = formatNumber(input_val);
        input_val = "" + input_val;

        if (blur === "blur")
            input_val += ".00";

    }

    input.val(input_val);
    let updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}
