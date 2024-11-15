import "./bootstrap";

window.Echo.private("App.Models.User." + id).notification((event) => {
    console.log("Notification received:", event);
});
