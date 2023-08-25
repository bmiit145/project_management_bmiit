// Assuming you're using Laravel Mix or a similar build tool
import toastr from 'toastr';

// Initialize Toastr
toastr.options = {
    positionClass: 'toast-top-right', // Adjust as needed
    closeButton: true,
    progressBar: true,
};

// You can also configure other options as needed
// For example: toastr.options.timeOut = 5000; // 5 seconds
