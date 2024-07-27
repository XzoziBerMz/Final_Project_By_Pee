

function viewNotify(id) {
    window.location.href = `./post.php?product_id=${id}`;
}

function reloadPage() {
    window.location.reload();
}

function updateViewNotify(value) {
    // console.log("🚀 ~ updateViewNotify ~ value:", value)

    fetch('./update_notify.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ user_id: value })
    })
        .then(response => response.json())
        .then(data => {
            // console.log('Success:', data);
            // คุณสามารถอัปเดต UI ที่นี่ถ้าต้องการ
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

