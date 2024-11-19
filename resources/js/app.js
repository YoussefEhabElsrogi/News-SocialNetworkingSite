import "./bootstrap";

window.Echo.private("users." + userId).notification((event) => {
    console.log(event);
});
