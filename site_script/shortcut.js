// Object to keep track of pressed keys
const keysPressed = {};

// Add event listeners for keydown and keyup
document.addEventListener("keydown", (event) => {
    keysPressed[event.key.toLowerCase()] = true;

    // Check if Shift + O + S is pressed
    if (keysPressed["shift"] && keysPressed["o"] && keysPressed["s"]) {
        alert("Shortcut Shift + O + S triggered!");
        // Perform your desired action here
        window.location.href = "/initiation_page.html";
    }
});

document.addEventListener("keyup", (event) => {
    // Remove the key from the keysPressed object when released
    delete keysPressed[event.key.toLowerCase()];
});
