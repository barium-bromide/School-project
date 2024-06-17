function changeFontSize(value) {
    let table = document.getElementById('table');
    let currentSize = table.style.fontSize || 1.5;

    if (value == 0) {
        table.style.fontSize = "1.5rem";
    } else {
        table.style.fontSize = parseFloat(currentSize) + value + "rem";
    }
}