let data_user
function onEdit(value) {
    const form = document.getElementById('form_show_text')
    const formEdit = document.getElementById('form_edit_input')

    if (value === 'edit') {
        form.style.display = 'none';
        formEdit.style.display = 'block';
    } else {
        form.style.display = 'block';
        formEdit.style.display = 'none';
        clearValue();
    }
}

function viewProfile(data) {
    data_user = data
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    document.getElementById('firstname').value = data.firstname;
    document.getElementById('lastname').value = data.lastname;
    document.getElementById('email').value = data.email;
    myModal.show();
}

function clearValue() {
    document.getElementById('profilePic').src = data_user.user_photo
    document.getElementById('firstname').value = data_user.firstname;
    document.getElementById('lastname').value = data_user.lastname;
    document.getElementById('email').value = data_user.email;
}

function closeModal() {
    const form = document.getElementById('form_show_text')
    const formEdit = document.getElementById('form_edit_input')
    var myModalElement = document.getElementById('exampleModal');
    const formPassword = document.getElementById('password_form_change');
    document.getElementById('current_password').value = "";
    document.getElementById('new_password').value = "";
    var myModal = bootstrap.Modal.getInstance(myModalElement);
    form.style.display = 'block';
    formEdit.style.display = 'none';
    formPassword.style.display = 'none';
    myModal.hide();
}

function changePassword() {
    const formPassword = document.getElementById('password_form_change');
    // Check if the element is currently visible
    const isVisible = getComputedStyle(formPassword).display !== 'none';

    // Toggle visibility
    formPassword.style.display = isVisible ? 'none' : 'block';
    document.getElementById('current_password').value = "";
    document.getElementById('new_password').value = "";
}

function saveChanges() {
    var userId = data_user.user_id;
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var currentPassword = $('#current_password').val();
    console.log("🚀 ~ saveChanges ~ currentPassword:", currentPassword)
    var newPassword = $('#new_password').val();
    var fileInput = document.getElementById('fileInput');
    var formData = new FormData();

    formData.append('user_id', userId);
    formData.append('firstname', firstname);
    formData.append('lastname', lastname);
    formData.append('email', email);

    // ถ้า newPassword ไม่มีค่า ให้ set currentPassword เป็นค่าว่าง
    if (newPassword) {
        formData.append('new_password', newPassword);
    } else {
        currentPassword = '';
    }
    console.log("🚀 ~ saveChanges ~ currentPassword:", currentPassword)

    formData.append('current_password', currentPassword);

    if (fileInput.files[0]) {
        formData.append('user_photo', fileInput.files[0]);
    }

    $.ajax({
        url: 'edit_user_script.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status === 'success') {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "ข้อมูลถูกบันทึกเรียบร้อยแล้ว",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    window.location.reload();
                });
            } else if (jsonResponse.status === 'error') {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: jsonResponse.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

document.getElementById('fileInput').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profilePic').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});