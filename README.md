# WordPress Notes Plugin

A lightweight, clean WordPress plugin for managing notes with both admin and public interfaces. Built with modern coding standards and optimized for performance.

## 🚀 Features

- **Admin Interface** - Full CRUD operations for managing notes
- **Public Display** - Shortcode support for displaying notes publicly
- **Responsive Design** - Mobile-friendly interface
- **Form Validation** - Client-side validation with user feedback
- **Auto-resize Textarea** - Dynamic textarea with character counter
- **Keyboard Shortcuts** - Ctrl+S to save, Escape to clear
- **Clean Code** - Under 100 lines per file, fully modular
- **Security** - WordPress nonces and data sanitization

## 📁 File Structure

```
simple-notes-plugin/
├── notes.php          # Main plugin file (95 lines)
├── notes.css          # Styling (85 lines)
├── notes.js           # JavaScript functionality (85 lines)
└── README.md          # This documentation
```

## 🔧 Installation

### Method 1: Manual Installation
1. Download the plugin files
2. Upload to `/wp-content/plugins/notes/` directory
3. Activate the plugin in WordPress admin
4. Access via **Notes** menu in admin dashboard

### Method 2: Direct Upload
1. Zip the three files: `notes.php`, `notes.css`, `notes.js`
2. Upload via WordPress admin → Plugins → Add New → Upload
3. Activate the plugin

## 💻 Usage

### Admin Interface
1. Navigate to **Notes** in your WordPress admin menu
2. Add new notes using the form
3. View, edit, or delete existing notes
4. All notes are stored in your WordPress database

### Public Display
1. Create a new page or post
2. Add the shortcode: `[notes_public]`
3. Publish the page
4. Visitors can view all notes without logging in

## 🎨 Customization

### CSS Styling
The plugin uses clean, minimal CSS that inherits WordPress admin styles. Customize by modifying `notes.css`:

```css
.note-item {
    background: #fff;
    padding: 20px;
    border-left: 4px solid #0073aa;
}
```

### JavaScript Features
Enhanced UX features in `notes.js`:
- Auto-resize textarea
- Character counter
- Form validation
- Keyboard shortcuts
- Smooth animations

## 🔒 Security Features

- **Nonce Verification** - All forms protected with WordPress nonces
- **Data Sanitization** - Input sanitized using WordPress functions
- **SQL Injection Protection** - Uses WordPress $wpdb methods
- **XSS Prevention** - Output escaped with esc_html()

## 📱 Responsive Design

The plugin is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones
- All modern browsers

## 🛠️ Technical Details

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

### Database
Creates a single table: `wp_notes`

```sql
CREATE TABLE wp_notes (
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    title varchar(200) NOT NULL,
    content text NOT NULL,
    created datetime DEFAULT CURRENT_TIMESTAMP
);
```

### Hooks Used
- `admin_menu` - Adds admin menu item
- `admin_init` - Handles form submissions
- `register_activation_hook` - Creates database table

## 🚀 Deployment Options

### Free Hosting Platforms
- **InfinityFree** - Traditional WordPress hosting
- **Netlify** - Static site deployment
- **Vercel** - Modern web deployment
- **Railway** - Full-stack hosting
- **GitHub Pages** - Direct from repository

### Quick Deploy to Netlify
1. Fork this repository
2. Connect to Netlify
3. Deploy automatically
4. Get live URL instantly

## 🎯 Live Demo

- **Admin Demo**: [View Admin Interface](https://hemanth090.github.io/Simple-note-plugin)
- **Public Demo**: [View Public Notes](https://hemanth090.github.io/Simple-note-plugin)

## 📝 Changelog

### Version 1.0.0
- Initial release
- Admin interface for note management
- Public shortcode display
- Responsive design
- Form validation
- Keyboard shortcuts
- Auto-resize textarea
- Character counter

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

GPL v2 or later - Same as WordPress

## 🐛 Bug Reports

Found a bug? Please create an issue with:
- WordPress version
- PHP version
- Steps to reproduce
- Expected vs actual behavior

## 💡 Feature Requests

Have an idea? Open an issue with:
- Clear description
- Use case explanation
- Mockups if applicable

## 🔗 Links

- **Repository**: [GitHub](https://github.com/hemanth090/Simple-note-plugin)
- **Issues**: [Report Bugs](https://github.com/hemanth090/Simple-note-plugin/issues)
- **WordPress**: [Plugin Directory](https://wordpress.org/plugins/)

## 👨‍💻 Author

**Hemanth**
- GitHub: [@hemanth090](https://github.com/hemanth090)
- Plugin: Simple Notes for WordPress

---

⭐ **Star this repository if you find it helpful!**

Made with ❤️ for the WordPress community