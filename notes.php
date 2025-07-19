<?php
/**
 * Plugin Name: Notes
 * Description: Simple notes manager for WordPress
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

class NotesPlugin {
    private $table;
    
    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'notes';
        $this->init();
    }
    
    private function init() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'handle_actions']);
        add_shortcode('notes_public', [$this, 'public_display']);
        register_activation_hook(__FILE__, [$this, 'activate']);
    }
    
    public function activate() {
        global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id int(11) AUTO_INCREMENT PRIMARY KEY,
            title varchar(200) NOT NULL,
            content text NOT NULL,
            created datetime DEFAULT CURRENT_TIMESTAMP
        ) {$wpdb->get_charset_collate()};";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        if (!$wpdb->get_var("SELECT COUNT(*) FROM {$this->table}")) {
            $wpdb->insert($this->table, ['title' => 'Welcome', 'content' => 'Your first note!']);
        }
    }
    
    public function menu() {
        add_menu_page('Notes', 'Notes', 'edit_posts', 'notes', [$this, 'page'], 'dashicons-edit');
    }
    
    public function handle_actions() {
        global $wpdb;
        
        if (isset($_POST['save']) && wp_verify_nonce($_POST['_wpnonce'], 'save_note')) {
            $title = sanitize_text_field($_POST['title']);
            $content = sanitize_textarea_field($_POST['content']);
            if ($title && $content) {
                $wpdb->insert($this->table, compact('title', 'content'));
                wp_redirect(admin_url('admin.php?page=notes&saved=1'));
                exit;
            }
        }
        
        if (isset($_GET['delete']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_' . $_GET['delete'])) {
            $wpdb->delete($this->table, ['id' => intval($_GET['delete'])]);
            wp_redirect(admin_url('admin.php?page=notes&deleted=1'));
            exit;
        }
    }
    
    public function page() {
        global $wpdb;
        $notes = $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY id DESC");
        wp_enqueue_style('notes-css', plugin_dir_url(__FILE__) . 'notes.css');
        wp_enqueue_script('notes-js', plugin_dir_url(__FILE__) . 'notes.js', ['jquery']);
        
        echo '<div class="wrap"><h1>Notes</h1>';
        
        if (isset($_GET['saved'])) echo '<div class="notice notice-success"><p>Note saved!</p></div>';
        if (isset($_GET['deleted'])) echo '<div class="notice notice-success"><p>Note deleted!</p></div>';
        
        $this->render_form();
        $this->render_notes($notes);
        echo '</div>';
    }
    
    private function render_form() {
        echo '<div class="note-form"><form method="post">';
        wp_nonce_field('save_note');
        echo '<h2>Add New Note</h2>
              <input type="text" name="title" placeholder="Note title..." required>
              <textarea name="content" placeholder="Write your note here..." required></textarea>
              <input type="submit" name="save" value="Save Note" class="button-primary">
              </form></div>';
    }
    
    private function render_notes($notes) {
        echo '<div class="notes-list">';
        if ($notes) {
            foreach ($notes as $note) {
                $delete_url = wp_nonce_url("?page=notes&delete={$note->id}", "delete_{$note->id}");
                echo "<div class='note-item'>
                        <h3>" . esc_html($note->title) . "</h3>
                        <p>" . nl2br(esc_html($note->content)) . "</p>
                        <div class='note-meta'>
                            <span>" . date('M j, Y', strtotime($note->created)) . "</span>
                            <a href='{$delete_url}' onclick='return confirm(\"Delete?\")' class='delete-link'>Delete</a>
                        </div>
                      </div>";
            }
        } else {
            echo '<div class="no-notes"><p>No notes yet. Create your first note above!</p></div>';
        }
        echo '</div>';
    }
    
    public function public_display() {
        global $wpdb;
        $notes = $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY id DESC");
        wp_enqueue_style('notes-css', plugin_dir_url(__FILE__) . 'notes.css');
        
        ob_start();
        echo '<div class="public-notes">';
        if ($notes) {
            foreach ($notes as $note) {
                echo "<div class='note-item'>
                        <h3>" . esc_html($note->title) . "</h3>
                        <p>" . nl2br(esc_html($note->content)) . "</p>
                        <div class='note-meta'>
                            <span>" . date('M j, Y', strtotime($note->created)) . "</span>
                        </div>
                      </div>";
            }
        } else {
            echo '<div class="no-notes"><p>No notes available.</p></div>';
        }
        echo '</div>';
        return ob_get_clean();
    }
}

new NotesPlugin();