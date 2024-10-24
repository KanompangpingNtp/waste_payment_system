    // ฟังก์ชันเพื่อแปลงวันที่เป็นภาษาไทย
    function formatThaiDate(dateString) {
        const thaiMonths = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];

        const date = new Date(dateString);
        const day = date.getDate();
        const month = thaiMonths[date.getMonth()];
        const year = date.getFullYear() + 543; // เพิ่ม 543 ปีสำหรับปีไทย

        return `${day} ${month} ${year}`;
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('td[data-date]').forEach((element) => {
            const dateStr = element.getAttribute('data-date');
            element.textContent = formatThaiDate(dateStr);
        });
    });
