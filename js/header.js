

function viewNotify(id) {
    window.location.href = `./post.php?product_id=${id}`;
}

function reloadPage() {
    window.location.reload();
}

function viewNotify(value) {
    window.location.href = `./post.php?product_id=${value}`;
}

function updateViewNotify(id, value) {
    console.log("🚀 ~ updateViewNotify ~ id:", id)
    console.log("🚀 ~ updateViewNotify ~ value:", value)

    fetch('./update_notify.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ user_id: value, id: id }),
    })
        .then(response => response.json())
        .then(data => {
            // console.log('Success:', data);
            // คุณสามารถอัปเดต UI ที่นี่ถ้าต้องการ
            window.location.href = `./post.php?product_id=${value}`;
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}
function deteleViewNotify(id, value) {

    fetch('./delete_notify.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({action: "s", user_id: value, id: id }),
    })
        .then(response => response.json())
        .then(data => {
            // console.log('Success:', data);
            // คุณสามารถอัปเดต UI ที่นี่ถ้าต้องการ
            window.location.reload();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function deleteNotifyAll(user_id) {
    console.log("🚀 ~ deleteNotifyAll ~ user_id:", user_id)
    
    fetch('./delete_notify.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: "all", user_id: user_id}),
    })
        .then(response => response.json())
        .then(data => {
            // console.log('Success:', data);
            // คุณสามารถอัปเดต UI ที่นี่ถ้าต้องการ
            window.location.reload();
        })
        .catch((error) => {
            console.error('Error:', error);
        });

}

