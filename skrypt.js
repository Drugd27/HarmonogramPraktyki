function refresh() {
    let refresh = document.getElementById("auto_refresh").checked;
    console.log("Auto-refresh checkbox state:", refresh); // Debugging

    localStorage.setItem("auto_refresh", refresh);

    if (refresh) {
        console.log("Włączyłeś auto-refresh. Strona się odświeży za 3 minuty.");
        window.setTimeout(
            function() {
                window.location.reload();
            },
            3000 // Interwał w milisekundach
        );
    } else {
        console.log("Auto-refresh jest wyłączony");
    }
}

window.onload = function() {
    let savedState = localStorage.getItem("auto_refresh") ==="true";
    document.getElementById("auto_refresh").checked = savedState;

    refresh();

};