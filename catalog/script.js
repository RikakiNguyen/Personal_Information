// script.js
$(document).ready(function() {
    // Show first tab content by default
    $('#info').addClass('show active');
    
    // Handle tab clicks
    $('.nav-link').click(function(e) {
        e.preventDefault();
        
        // Remove active class from all tabs and content
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show active');
        
        // Add active class to clicked tab
        $(this).addClass('active');
        
        // Show corresponding content
        const tabId = $(this).data('tab');
        $(`#${tabId}`).addClass('show active');
    });
});