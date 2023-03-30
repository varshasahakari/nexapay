$(function () {
    $('#login').validate({
        errorClass: "text-danger",
        submitHandler: function (form) {
            $('#success_div').hide();
            $('#error_div').hide();
            var data_array = $("#login").serializeArray();
            var encryptedData = encryptData(data_array);
            $.ajax({
                url: "http://localhost:8080/api/login",
                type: "post",
                data: { data: encryptedData },
                success: function (d) {
                    let data = decryptData(d);
                    $('#success_div').show();
                    $('#login').hide();
                    $('#formFooter').hide();
                    // alert(d);
                    // console.log(data);
                },
                error:function (d) {
                    // console.log(d.responseText);
                    let data = decryptData(d.responseText);
                    // alert(d);
                    // console.log(data);
                    $('#success_div').hide();
                    $('#error_div').show();
                    $('#error_msg').html(data.message);
                },
            });
        }
    });

    // new user registration form validation check
    $('#register').validate({
        errorClass: "text-danger",
        rules: {
            password: {
                minlength: 5
            },
            confirm_password: {
                minlength: 5,
                equalTo: '[name="password"]'
            }
        },
        submitHandler: function (form) {
            $('#success_div').hide();
            $('#error_div').hide();
            var data_array = $("#register").serializeArray();
            var encryptedData = encryptData(data_array);
            $.ajax({
                url: "http://localhost:8080/api/register",
                type: "post",
                data: { data: encryptedData },
                success: function (d) {
                    let data = decryptData(d);
                    $('#success_div').show();
                    $('#register').hide();
                    // alert(d);
                    // console.log(data);
                },
                error:function (d) {
                    let data = decryptData(d.responseText);
                    // alert(d);
                    // console.log(data);
                    $('#success_div').hide();
                    $('#error_div').show();
                    $('#error_msg').html(data.error);
                },
            });
        }
    });
});

let encryptData = (data_array) => {
    let string_data = '';
    data_array.forEach((obj, i) => {
        if (string_data == '') {
            string_data = `${obj.name}=${obj.value}`;
        } else {
            string_data = `${string_data}~${obj.name}=${obj.value}`;
        }
    });
    // console.log(string_data);
    let string_data_salt = string_data + SALT;
    let hash = CryptoJS.SHA256(string_data_salt).toString(); // hash the data with SHA-256
    let string_data_hash = string_data + "~hash=" + hash;
    let encryptedData = CryptoJS.AES.encrypt(string_data_hash, AES_ENCRYPTION_KEY, { iv: AES_IV, mode: CryptoJS.mode.CBC }); // encrypt the data with AES-CBC-256
    return encryptedData.toString();
}

let decryptData = (encryptedData) => {
    let decryptedDataObj = CryptoJS.AES.decrypt(encryptedData, AES_ENCRYPTION_KEY, { iv: AES_IV, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 });
    let decryptedData = CryptoJS.enc.Utf8.stringify(decryptedDataObj);

    // console.log("decryptedData", decryptedData);
    let field_array = decryptedData.split("~");
    // console.log(field_array);

    let string_data = '';
    let response_hash = '';
    let response_data = [];
    field_array.forEach((obj, i) => {
        // console.log([obj, i]);
        let fields = obj.split("=");
        // console.log(fields);
        if (fields[0] == 'hash') {
            response_hash = fields[1];
            return;
        }
        response_data[fields[0]] = fields[1];
        if (string_data == '') {

            string_data = `${fields[0]}=${fields[1]}`;
        } else {
            string_data = `${string_data}~${fields[0]}=${fields[1]}`;
        }
    });
    // console.log(response_data);
    // console.log(string_data);
    let string_data_salt = string_data + SALT;
    let hash = CryptoJS.SHA256(string_data_salt).toString(); // hash the data with SHA-256
    if (response_hash == hash) {
        return response_data;
    } else {
        // console.log(hash);
        return false;
    }
}
