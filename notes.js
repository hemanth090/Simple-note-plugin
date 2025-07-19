/**
 * Notes Plugin JavaScript - Enhanced UX
 * @version 1.0.0
 */

jQuery(document).ready(function($) {
    const NotesJS = {
        init() {
            this.setupTextarea();
            this.setupValidation();
            this.setupKeyboardShortcuts();
            this.setupUI();
        },
        
        setupTextarea() {
            const $textarea = $('textarea[name="content"]');
            
            // Auto-resize
            $textarea.on('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
            
            // Character counter
            $textarea.after('<div class="char-count" style="font-size:12px;color:#666;margin-top:5px;"></div>');
            $textarea.on('input', function() {
                const count = $(this).val().length;
                $(this).next('.char-count').text(`${count} characters`);
            }).trigger('input');
        },
        
        setupValidation() {
            $('form').on('submit', function(e) {
                const title = $('input[name="title"]').val().trim();
                const content = $('textarea[name="content"]').val().trim();
                
                if (title.length < 2) {
                    alert('Title must be at least 2 characters');
                    $('input[name="title"]').focus();
                    return false;
                }
                
                if (content.length < 5) {
                    alert('Content must be at least 5 characters');
                    $('textarea[name="content"]').focus();
                    return false;
                }
                
                // Show loading state
                $(this).find('input[type="submit"]')
                    .val('Saving...')
                    .prop('disabled', true);
            });
        },
        
        setupKeyboardShortcuts() {
            $(document).keydown(function(e) {
                // Ctrl+S or Cmd+S to save
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
                    e.preventDefault();
                    $('form').submit();
                }
                
                // Escape to clear form
                if (e.keyCode === 27) {
                    $('input[name="title"], textarea[name="content"]').val('');
                    $('input[name="title"]').focus();
                }
            });
        },
        
        setupUI() {
            // Auto-hide success messages
            $('.notice-success').delay(3000).fadeOut(500);
            
            // Focus first input
            $('input[name="title"]').focus();
            
            // Smooth scroll to form after delete
            if (window.location.href.includes('deleted=1')) {
                $('html, body').animate({
                    scrollTop: $('.note-form').offset().top - 50
                }, 500);
            }
            
            // Add hover effects to note items
            $('.note-item').hover(
                function() { $(this).css('transform', 'translateY(-2px)'); },
                function() { $(this).css('transform', 'translateY(0)'); }
            );
        }
    };
    
    NotesJS.init();
    console.log('Notes plugin loaded successfully');
});