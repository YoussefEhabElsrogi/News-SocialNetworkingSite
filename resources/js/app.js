import "./bootstrap";

// Function to increment notification counters
function incrementNotificationCounter(selector) {
    let count = Number($(selector).text());
    count++;
    $(selector).text(count);
}

// Listen for notifications for users
if (role === "user") {
    window.Echo.private("users." + userId).notification((event) => {
        try {
            // Fallback for missing data
            let postTitle =
                event.post_title.length > 20
                    ? event.post_title.slice(0, 20) + "..."
                    : event.post_title;

            let link = event.link ?? "#";

            // Append notification to the dropdown
            $("#push-notification").prepend(`
                <div class="dropdown-item d-flex justify-content-between align-items-center">
                    <span>Post: ${postTitle}</span>
                    <a href="${link}?notify=${event.id}">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            `);

            // Increment notification counter
            incrementNotificationCounter("#notification-count");
        } catch (error) {
            console.error("Error handling user notification:", error);
        }
    });
}

// Listen for notifications for admins
if (role === "admin") {
    window.Echo.private("admins." + adminId).notification((event) => {
        try {
            // Fallback for missing data
            let contactTitle = event.contact_title ?? "No Title";
            let link = event.link ?? "#";
            let date = event.date
                ? moment(event.date).fromNow()
                : moment().fromNow();

            // Append notification to the dropdown
            $("#notify-admin").prepend(`
                <a class="dropdown-item d-flex align-items-center"
                    href="${link}?notify_admin=${event.id}">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">${date}</div>
                        <span class="font-weight-bold">${contactTitle}</span>
                    </div>
                </a>
            `);

            // Hide empty notification
            $("#empty-notification").hide();

            // Increment notification counter
            incrementNotificationCounter("#count-admin");
        } catch (error) {
            console.error("Error handling admin notification:", error);
        }
    });
}
